<?php session_start();
// Si le client est déjà connecté, on le redirige vers l'accueil
if(isset($_SESSION['client_id']))
{
    header("Location: accueil.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma Plateforme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
    <div class="accueil-contenu">
        <h2>Bienvenue sur notre plateforme</h2>
        <p>Veuillez vous inscrire ou vous connecter pour accéder au site.</p>
        <a href="inscription.php" class="btn-accueil">S'inscrire</a>
        <a href="login.php" class="btn-accueil">Se connecter</a>
    </div>
</main>
</body>
</html>