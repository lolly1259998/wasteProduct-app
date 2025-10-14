from flask import Flask, request, jsonify

app = Flask(__name__)

# ✅ Route d'accueil (pour éviter l'erreur 404)
@app.route('/')
def home():
    return "Bienvenue dans le service d'intelligence artificielle WasteProduct 🧠"

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    type_ = data.get('type', '').lower()
    category = data.get('category', '').lower()
    weight = float(data.get('weight', 0))

    if 'plastic' in type_ or 'bottle' in category:
        prediction = 'recycler'
    elif 'food' in category or 'organic' in type_:
        prediction = 'composter'
    elif weight < 0.5:
        prediction = 'réutiliser'
    else:
        prediction = 'donner'

    return jsonify({'prediction': prediction})

if __name__ == '__main__':
    app.run(port=5000)
