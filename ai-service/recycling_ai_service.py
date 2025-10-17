from flask import Flask, request, jsonify
from datetime import datetime

app = Flask(__name__)

# ========================================
# 1. CLASSIFICATION DE DÉCHETS
# ========================================

@app.route('/classify-waste', methods=['POST'])
def classify_waste():
    """
    Classifie un déchet basé sur ses caractéristiques
    """
    try:
        data = request.get_json()
        
        # Récupération des données
        waste_type = data.get('type', '').lower()
        weight = float(data.get('weight', 0))
        description = data.get('description', '').lower()
        
        # Logique de classification simplifiée
        classification = classify_waste_logic(waste_type, weight, description)
        
        return jsonify({
            'success': True,
            'classification': classification,
            'confidence': classification['confidence'],
            'recommended_method': classification['recommended_method']
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 400

def classify_waste_logic(type_, weight, description):
    """
    Logique de classification des déchets (version simplifiée)
    """
    # Mots-clés pour chaque catégorie
    plastic_keywords = ['bouteille', 'bottle', 'plastique', 'plastic', 'emballage', 'packaging']
    glass_keywords = ['verre', 'glass', 'bocal', 'jar', 'vitre']
    paper_keywords = ['papier', 'paper', 'carton', 'cardboard', 'journal', 'newspaper']
    metal_keywords = ['métal', 'metal', 'canette', 'can', 'boîte', 'tin']
    organic_keywords = ['organique', 'organic', 'nourriture', 'food', 'restes', 'leftovers']
    electronic_keywords = ['électronique', 'electronic', 'téléphone', 'phone', 'ordinateur', 'computer']
    
    # Classification basée sur les mots-clés
    if any(keyword in type_ or keyword in description for keyword in plastic_keywords):
        category = 'Plastique'
        confidence = 0.85
        method = 'Recyclage mécanique'
    elif any(keyword in type_ or keyword in description for keyword in glass_keywords):
        category = 'Verre'
        confidence = 0.90
        method = 'Fusion et moulage'
    elif any(keyword in type_ or keyword in description for keyword in paper_keywords):
        category = 'Papier'
        confidence = 0.80
        method = 'Pulpage et reformage'
    elif any(keyword in type_ or keyword in description for keyword in metal_keywords):
        category = 'Métal'
        confidence = 0.88
        method = 'Fusion et refonte'
    elif any(keyword in type_ or keyword in description for keyword in organic_keywords):
        category = 'Organique'
        confidence = 0.75
        method = 'Compostage'
    elif any(keyword in type_ or keyword in description for keyword in electronic_keywords):
        category = 'Électronique'
        confidence = 0.70
        method = 'Démantèlement et récupération'
    else:
        category = 'Mixte'
        confidence = 0.50
        method = 'Tri manuel puis recyclage'
    
    return {
        'category': category,
        'confidence': confidence,
        'recommended_method': method,
        'recyclability_score': min(confidence * 100, 95)
    }

# ========================================
# 2. PRÉDICTION DE QUALITÉ
# ========================================

@app.route('/predict-quality', methods=['POST'])
def predict_quality():
    """
    Prédit la qualité du produit recyclé
    """
    try:
        data = request.get_json()
        
        # Récupération des données
        waste_type = data.get('waste_type', '')
        recycling_method = data.get('recycling_method', '')
        waste_condition = data.get('waste_condition', 'good')
        storage_days = int(data.get('storage_days', 0))
        
        # Prédiction de qualité simplifiée
        quality_prediction = predict_quality_logic(
            waste_type, recycling_method, waste_condition, storage_days
        )
        
        return jsonify({
            'success': True,
            'quality_prediction': quality_prediction
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 400

def predict_quality_logic(waste_type, method, condition, storage_days):
    """
    Logique de prédiction de qualité (version simplifiée)
    """
    # Score de base selon le type de déchet
    base_scores = {
        'Plastique': 80,
        'Verre': 90,
        'Papier': 75,
        'Métal': 85,
        'Organique': 70,
        'Électronique': 60
    }
    
    # Score selon la méthode
    method_multipliers = {
        'Recyclage mécanique': 1.0,
        'Fusion et moulage': 0.95,
        'Pulpage et reformage': 0.9,
        'Fusion et refonte': 0.98,
        'Compostage': 0.8,
        'Démantèlement et récupération': 0.7
    }
    
    # Score selon l'état
    condition_multipliers = {
        'excellent': 1.0,
        'good': 0.9,
        'fair': 0.7,
        'poor': 0.5
    }
    
    # Dégradation selon le stockage
    storage_penalty = min(storage_days * 0.5, 20)  # Max 20% de perte
    
    # Calcul du score final
    base_score = base_scores.get(waste_type, 70)
    method_mult = method_multipliers.get(method, 0.8)
    condition_mult = condition_multipliers.get(condition, 0.8)
    
    final_score = (base_score * method_mult * condition_mult) - storage_penalty
    final_score = max(final_score, 10)  # Minimum 10%
    
    # Classification de la qualité
    if final_score >= 85:
        quality_level = 'Excellent'
        color = 'success'
    elif final_score >= 70:
        quality_level = 'Bon'
        color = 'primary'
    elif final_score >= 50:
        quality_level = 'Moyen'
        color = 'warning'
    else:
        quality_level = 'Faible'
        color = 'danger'
    
    return {
        'score': round(final_score, 1),
        'level': quality_level,
        'color': color,
        'recommendations': get_quality_recommendations(final_score)
    }

def get_quality_recommendations(score):
    """
    Recommandations basées sur le score de qualité
    """
    if score >= 85:
        return ["Qualité excellente", "Idéal pour produits premium"]
    elif score >= 70:
        return ["Qualité correcte", "Convient pour usage standard"]
    elif score >= 50:
        return ["Qualité moyenne", "Considérer un prétraitement"]
    else:
        return ["Qualité faible", "Recyclage non recommandé", "Considérer la réutilisation"]

# ========================================
# 3. ESTIMATION DE PRIX
# ========================================

@app.route('/estimate-price', methods=['POST'])
def estimate_price():
    """
    Estime le prix optimal d'un produit recyclé
    """
    try:
        data = request.get_json()
        
        # Récupération des données
        product_name = data.get('product_name', '')
        waste_category = data.get('waste_category', '')
        quality_score = float(data.get('quality_score', 70))
        recycling_cost = float(data.get('recycling_cost', 10))
        market_demand = float(data.get('market_demand', 50))  # 0-100
        
        # Estimation du prix
        price_estimation = estimate_price_logic(
            product_name, waste_category, quality_score, recycling_cost, market_demand
        )
        
        return jsonify({
            'success': True,
            'price_estimation': price_estimation
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 400

def estimate_price_logic(product_name, category, quality, cost, demand):
    """
    Logique d'estimation de prix (version simplifiée)
    """
    # Prix de base selon la catégorie (DT)
    base_prices = {
        'Plastique': 25,
        'Verre': 30,
        'Papier': 15,
        'Métal': 40,
        'Organique': 20,
        'Électronique': 60
    }
    
    # Multiplicateurs
    quality_multiplier = quality / 100
    demand_multiplier = 0.5 + (demand / 100)  # 0.5 à 1.5
    cost_multiplier = 1 + (cost / 100)  # Coût intégré
    
    # Calcul du prix
    base_price = base_prices.get(category, 25)
    estimated_price = base_price * quality_multiplier * demand_multiplier * cost_multiplier
    
    # Arrondi à 2 décimales
    estimated_price = round(estimated_price, 2)
    
    # Marge de profit suggérée
    profit_margin = estimated_price * 0.3  # 30% de marge
    final_price = estimated_price + profit_margin
    
    return {
        'base_price': round(base_price, 2),
        'estimated_price': round(estimated_price, 2),
        'final_price': round(final_price, 2),
        'profit_margin': round(profit_margin, 2),
        'confidence': min(quality / 100, 0.95)
    }

# ========================================
# 4. GÉNÉRATION DE DESCRIPTIONS
# ========================================

@app.route('/generate-description', methods=['POST'])
def generate_description():
    """
    Génère une description marketing pour un produit recyclé
    """
    try:
        data = request.get_json()
        
        product_name = data.get('product_name', 'Produit recyclé')
        source_material = data.get('source_material', '')
        recycling_method = data.get('recycling_method', '')
        specifications = data.get('specifications', {})
        
        # Génération de la description
        description = generate_description_logic(
            product_name, source_material, recycling_method, specifications
        )
        
        return jsonify({
            'success': True,
            'description': description
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 400

def generate_description_logic(name, material, method, specs):
    """
    Logique de génération de description (version simplifiée)
    """
    # Templates de base
    templates = {
        'Plastique': f"Produit {name} fabriqué à partir de {material} recyclé. Chaque article contribue à la réduction des déchets plastiques et participe à l'économie circulaire.",
        'Verre': f"Article {name} créé à partir de {material} recyclé. Le verre recyclé conserve toutes ses propriétés et peut être recyclé à l'infini.",
        'Papier': f"Produit {name} issu du recyclage de {material}. Fabriqué de manière écologique, il respecte l'environnement tout en offrant une qualité optimale.",
        'Métal': f"Article {name} conçu à partir de {material} recyclé. Résistant et durable, il allie performance et respect de l'environnement.",
        'Organique': f"Produit {name} naturel issu du compostage de {material}. 100% biodégradable et respectueux de l'environnement.",
        'Électronique': f"Article {name} créé à partir de composants électroniques recyclés. Innovation et durabilité au service de l'environnement."
    }
    
    # Description de base
    base_description = templates.get(material, f"Produit {name} fabriqué à partir de {material} recyclé.")
    
    # Ajout des spécifications
    if specs:
        specs_text = " Spécifications : "
        for key, value in specs.items():
            specs_text += f"{key}: {value}, "
        specs_text = specs_text.rstrip(", ")
        base_description += specs_text
    
    # Ajout de la méthode de recyclage
    if method:
        base_description += f" Méthode de recyclage : {method}."
    
    # Ajout de l'impact écologique
    impact_text = " Chaque achat contribue à la réduction des déchets et à la préservation de notre planète. 🌍♻️"
    base_description += impact_text
    
    return base_description

# ========================================
# 5. ROUTE DE SANTÉ
# ========================================

@app.route('/health', methods=['GET'])
def health_check():
    """
    Vérification de l'état du service
    """
    return jsonify({
        'status': 'healthy',
        'service': 'Simple Recycling AI Service',
        'version': '1.0.0',
        'timestamp': datetime.now().isoformat()
    })

# ========================================
# 6. ROUTE D'ACCUEIL
# ========================================

@app.route('/', methods=['GET'])
def home():
    """
    Page d'accueil du service IA
    """
    return jsonify({
        'message': '🧠 Service IA Waste2Product - Module Recyclage (Version Simple)',
        'version': '1.0.0',
        'endpoints': [
            'POST /classify-waste - Classification des déchets',
            'POST /predict-quality - Prédiction de qualité',
            'POST /estimate-price - Estimation de prix',
            'POST /generate-description - Génération de descriptions',
            'GET /health - État du service'
        ]
    })

if __name__ == '__main__':
    print("🚀 Démarrage du service IA Waste2Product (Version Simple)...")
    print("📡 Port: 5002")
    print("🔗 Endpoints disponibles:")
    print("   - POST /classify-waste")
    print("   - POST /predict-quality") 
    print("   - POST /estimate-price")
    print("   - POST /generate-description")
    print("   - GET /health")
    app.run(debug=True, port=5002)
