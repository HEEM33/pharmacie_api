<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue</title>
</head>
<body>
    <h2>Bonjour {{ $user->name }},</h2>
    <p>Votre compte a été créé avec succès.</p>
    <p><strong>Email :</strong> {{ $user->email }}</p>
    <p><strong>Mot de passe :</strong> {{ $password }}</p>
    <p>Veuillez vous connecter et changer votre mot de passe dès que possible.</p>
</body>
</html>
