from flask import Flask, request, jsonify
from sklearn.linear_model import LinearRegression
import pandas as pd
import joblib
import numpy as np
import os

app = Flask(__name__)

# =========================================================
# 🔹 SERVICE 1 : IA DE CLASSEMENT DES DÉCHETS
# =========================================================
@app.route('/')
def home():
    return "✅ Service IA Waste2Product est en ligne 🧠"

@app.route('/predict', methods=['POST'])
def predict_waste():
    """
    Prédit l'action à effectuer selon le type de déchet :
    recycler, composter, réutiliser ou donner
    weight est en kg
    """
    data = request.get_json(force=True)
    type_ = data.get('type', '').lower()
    category = data.get('category', '').lower()
    weight = float(data.get('weight', 0))

    if 'glass' in type_ or 'glass' in category:
        prediction = 'Recycle in green bin 🟢'
    
        # Ensuite le papier/carton
    elif 'paper' in type_ or 'cardboard' in type_ or 'paper' in category or 'cardboard' in category:
        prediction = 'Recycle in yellow bin color🟡'
    
        # Puis le plastique
    elif 'plastic' in type_ or 'plastic' in category:
        prediction = 'Recycle in blue bin ♻️'
    
        # Déchets organiques
    elif 'food' in type_ or 'organic' in type_ or 'food' in category or 'organic' in category:
        prediction = 'Compost 🍂'
    
        # Pour les petits objets légers
    elif weight < 0.5:
        prediction = 'Reuse ♻️'
    
        # Par défaut - SIMPLIFIÉ
    else:
           prediction = 'Recycle'

    return jsonify({'prediction': prediction})

# =========================================================
# 🔹 SERVICE 2 : IA POUR LES POINTS DE COLLECTE
# =========================================================
class CollectionAIService:
    def get_model_path(self, point_id):
        return f"model_{point_id}.pkl"

    def train_model(self, point_id, data):
        """
        Entraîne le modèle sur les données réelles du point de collecte.
        data = liste de dicts avec 'day' (jours) et 'volume' (en kg)
        """
        df = pd.DataFrame(data)
        if not {'day', 'volume'}.issubset(df.columns):
            raise ValueError("Les données doivent contenir les champs 'day' et 'volume'.")
        if len(df) < 2:
            raise ValueError("Pas assez de données pour entraîner le modèle (minimum 2 jours).")

        X = df[['day']]
        y = df['volume']  # Volume en kg
        model = LinearRegression()
        model.fit(X, y)

        model_path = self.get_model_path(point_id)
        joblib.dump(model, model_path)

        print(f"✅ Modèle IA pour point {point_id} entraîné (volumes en kg).")
        return {
            "coef": model.coef_.tolist(),
            "intercept": float(model.intercept_),
            "samples": len(df)
        }

    def predict_volume(self, point_id, day):
        """
        Prédit le volume en kg pour un jour donné
        """
        model_path = self.get_model_path(point_id)
        if not os.path.exists(model_path):
            raise ValueError("Le modèle n'est pas encore entraîné pour ce point.")

        model = joblib.load(model_path)

        X_new = np.array([[day]])
        prediction = model.predict(X_new)  # Prédiction en kg
        return float(prediction[0])

collection_ai = CollectionAIService()

# =========================================================
# 🔹 ROUTES FLASK POUR LES POINTS DE COLLECTE
# =========================================================
@app.route('/collection/train', methods=['POST'])
def train_collection():
    try:
        payload = request.get_json(force=True)
        point_id = payload['point_id']
        data = payload['data']
        result = collection_ai.train_model(point_id, data)
        return jsonify({
            "message": "✅ Modèle entraîné avec succès",
            "details": result
        })
    except KeyError as e:
        return jsonify({"error": f"Champ manquant: {str(e)}"}), 400
    except Exception as e:
        print(f"❌ Erreur entraînement : {str(e)}")
        return jsonify({"error": str(e)}), 400

@app.route('/collection/predict', methods=['POST'])
def predict_collection():
    try:
        payload = request.get_json(force=True)
        day = int(payload['day'])
        point_id = payload['point_id']
        prediction = collection_ai.predict_volume(point_id, day)  # En kg
        return jsonify({
            "day": day,
            "predicted_volume": round(prediction, 2)  # En kg
        })
    except KeyError as e:
        return jsonify({"error": f"Champ manquant: {str(e)}"}), 400
    except Exception as e:
        print(f"❌ Erreur prédiction : {str(e)}")
        return jsonify({"error": str(e)}), 400

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5000, debug=True)
