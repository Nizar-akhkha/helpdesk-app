<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Code de vérification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #222;">
    <h2>Vérification de votre compte</h2>

    <p>Bonjour,</p>

    <p>Voici votre code de vérification :</p>

    <div style="font-size: 30px; font-weight: bold; letter-spacing: 4px; margin: 20px 0;">
        {{ $code }}
    </div>

    <p>Ce code expire dans 10 minutes.</p>

    <p>Si vous n'avez pas créé de compte, ignorez cet email.</p>
</body>
</html>