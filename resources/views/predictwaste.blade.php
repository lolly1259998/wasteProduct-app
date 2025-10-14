@extends('back.layout')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard IA</title>
</head>
<body>
<h1>Prédiction IA pour la gestion des déchets</h1>

<form action="{{ route('ai.predict') }}" method="POST">
    @csrf
    <label>Type:</label>
    <input type="text" name="type" required><br>
    
    <label>Poids:</label>
    <input type="number" step="0.01" name="weight" required><br>
    
    <label>Catégorie:</label>
    <input type="text" name="category" required><br>
    
    <label>Description:</label>
    <input type="text" name="description"><br>

    <button type="submit">Envoyer à l'IA</button>
</form>

@if(isset($prediction))
    <h2>Prédiction IA : {{ $prediction }}</h2>
@endif

</body>
</html>
