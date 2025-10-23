from flask import Flask, request, jsonify
from openai import OpenAI
import os
from dotenv import load_dotenv
from flask_cors import CORS

load_dotenv()
app = Flask(__name__)

# ✅ Autoriser explicitement ton app Laravel
CORS(app, resources={r"/api/*": {"origins": "*"}})

client = OpenAI(api_key=os.getenv("OPENAI_API_KEY"))

@app.route('/api/ai/generate-description', methods=['POST'])
def generate_description():
    data = request.get_json()
    title = data.get('title', '')
    city = data.get('city', '')
    region = data.get('region', '')

    # 🧠 Prompt intelligent
    prompt = f"""
    Tu es un assistant spécialisé en campagnes de sensibilisation environnementale.
    Rédige une description fluide, engageante et réaliste pour la campagne intitulée "{title}",
    organisée à {city or "une ville tunisienne"} ({region or "Tunisie"}).
    Parle de la protection de l’environnement, de la participation citoyenne et de l’impact positif attendu.
    Sois professionnel, clair et motivant.
    """

    try:
        response = client.chat.completions.create(
            model="gpt-4o-mini",
            messages=[{"role": "user", "content": prompt}],
            max_tokens=180,
            temperature=0.8
        )
        description = response.choices[0].message.content.strip()
        return jsonify({"description": description})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
