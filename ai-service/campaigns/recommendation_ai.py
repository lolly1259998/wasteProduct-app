from flask import Flask, request, jsonify
from flask_cors import CORS
from openai import OpenAI
import os, numpy as np
from dotenv import load_dotenv
from sklearn.metrics.pairwise import cosine_similarity
from geopy.geocoders import Nominatim
from geopy.distance import geodesic
from datetime import datetime

load_dotenv()
app = Flask(__name__)
CORS(app)
client = OpenAI(api_key=os.getenv("OPENAI_API_KEY"))
geolocator = Nominatim(user_agent="waste2product_ai")

# --- Nettoyage robuste du nom de ville ---
def clean_city(city):
    if not city or city.lower() == "tunisie":
        return None
    city_name = city.split(",")[0].strip().title()
    for suffix in [" Nord", " Sud", " Est", " Ouest"]:
        city_name = city_name.replace(suffix, "")
    return city_name

# --- Similarité géographique améliorée ---
def geo_similarity(city1, city2):
    city1_clean = clean_city(city1)
    city2_clean = clean_city(city2)

    if not city1_clean or not city2_clean:
        return (0.1, None)  # (similarity, distance)

    try:
        loc1 = geolocator.geocode(city1_clean + ", Tunisie", timeout=5)
        loc2 = geolocator.geocode(city2_clean + ", Tunisie", timeout=5)
        if not loc1 or not loc2:
            return (0.1, None)

        dist = geodesic((loc1.latitude, loc1.longitude),
                        (loc2.latitude, loc2.longitude)).km

        # Calcul du score géographique
        if dist <= 10:
            sim = 1.0
        elif dist <= 30:
            sim = 0.85
        elif dist <= 60:
            sim = 0.6
        elif dist <= 100:
            sim = 0.4
        else:
            sim = 0.0  # ❌ Trop loin → exclusion

        return (sim, round(dist, 1))
    except Exception as e:
        print(f"Geo error: {e}")
        return (0.1, None)

# --- Obtenir l'embedding d'un texte ---
def get_embedding(text):
    if not text:
        text = " "
    resp = client.embeddings.create(model="text-embedding-3-small", input=text)
    return np.array(resp.data[0].embedding)

# --- Route pour les recommandations ---
@app.route("/api/ai/recommendations", methods=["POST"])
def recommend():
    data = request.get_json()
    user_city = data.get("city", "Sousse")
    user_history = data.get("history", "")
    campaigns = data.get("campaigns", [])

    # Log the entire input for debugging
    print(f"Received request: user_city={user_city}, user_history={user_history}, campaigns={campaigns}")

    # Filtrer les campagnes actives et en cours
    current_date = datetime.now().date()
    print(f"Current date: {current_date}")

    valid_campaigns = []
    for c in campaigns:
        # Vérifier les champs requis
        if not all(key in c for key in ["id", "title", "city", "status", "end_date"]):
            print(f"Campagne {c.get('id', 'inconnue')} exclue : champs manquants - {c}")
            continue

        # Vérifier que end_date est une chaîne valide
        end_date_str = c.get("end_date")
        if not end_date_str or end_date_str.lower() == "null":
            print(f"Campagne {c.get('id')} exclue : end_date manquant ou None - {end_date_str}")
            continue

        try:
            end_date = datetime.strptime(end_date_str, "%Y-%m-%d").date()
            # Normalize status to lowercase for comparison
            status = c.get("status", "").lower()
            if status in ["active", "draft"] and end_date >= current_date:
                valid_campaigns.append(c)
                print(f"Campagne {c.get('id')} inclue : status={status}, end_date={end_date}")
            else:
                print(f"Campagne {c.get('id')} exclue : status={status}, end_date={end_date}")
        except ValueError as e:
            print(f"Erreur de format de date pour campagne {c.get('id')} : {e}, end_date={end_date_str}")
            continue

    if not valid_campaigns:
        print("Aucune campagne valide trouvée. Données reçues :", campaigns)
        return jsonify({"recommendations": [], "message": "Aucune campagne active trouvée"})

    user_text = f"Utilisateur habitant à {user_city}, ayant participé à {user_history or 'aucune campagne'}"
    user_emb = get_embedding(user_text)

    results = []
    for c in valid_campaigns:
        desc = f"{c['title']} {c.get('description', '')} {c.get('city', '')} {c.get('region', '')}"
        emb = get_embedding(desc)

        sem = cosine_similarity([user_emb], [emb])[0][0]
        geo, dist = geo_similarity(user_city, c.get("city"))

        #Exclure les campagnes trop éloignées
        if geo == 0.0:
            print(f"❌ Campagne {c['title']} ignorée (distance > 100 km)")
            continue

        score = round(0.5 * sem + 0.5 * geo, 3)

        results.append({
            "id": c["id"],
            "title": c["title"],
            "city": c.get("city"),
            "region": c.get("region"),
            "semantic_similarity": round(float(sem), 3),
            "geo_similarity": round(float(geo), 3),
            "similarity": score,
"image": c.get("image", "").strip() if c.get("image") else "https://cdn-icons-png.flaticon.com/512/4248/4248314.png"

        })


    results.sort(key=lambda x: x["similarity"], reverse=True)
    print(f"Recommendations: {results}")
    return jsonify({"recommendations": results[:5]})

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)