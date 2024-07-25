<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
</head>
<body>
    <h1>Profil de {{ $user->name }}</h1>
    
    <p>Nom complet : {{ $user->firstname }} {{ $user->name }}</p>
    <p>Email : {{ $user->email }}</p>
    <p>Unité : {{ $user->unite }}</p>
    <p>Numéro de poste : {{ $user->numero_de_poste }}</p>
    <p>Numéro de téléphone : {{ $user->numero_de_telephone }}</p>

    <a href="{{ route('dashboard') }}">Retour à l'accueil</a>
</body>
</html>
