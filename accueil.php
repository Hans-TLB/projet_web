<?php session_start();
if(!isset($_SESSION['user_id']))
{
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Ma Plateforme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="images/logo_eneam.png" alt="Logo ENEAM">
    <h1>Bienvenue sur ma plateforme</h1>
    <img src="images/logo_uac.png" alt="Logo UAC">
</header>

<nav>
    <a href="accueil.php">Accueil</a>
    <a href="articles.php">Articles</a>
    <a href="ventes.php">Ventes</a>
<a href="effectuer_vente.php">Effectuer une vente</a>
    <a href="clients.php">Liste clients</a> <a href="users.php">Liste users</a> 
    <a href="deconnexion.php" class="quitter">Quitter</a>
</nav>

<main>
    <div class="accueil-contenu">
        <h2>Bonjour, <?php echo $_SESSION['user_login']; ?> !</h2>
        <p>Que souhaitez-vous faire ?</p>
        <a href="articles.php" class="btn-accueil">Articles</a>
        <a href="ventes.php" class="btn-accueil">Ventes</a>
        <a href="clients.php" class="btn-accueil">Liste clients</a>
<a href="effectuer_vente.php" class="btn-accueil">Effectuer une vente</a>
<a href="users.php" class="btn-accueil">Liste users</a>
    </div>
</main>

</body>
</html>