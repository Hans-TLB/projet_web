<?php session_start();
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un article - Ma Plateforme</title>
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
<h2>Ajouter un article</h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="application/x-www-form-urlencoded">
<fieldset>
<legend><b>Nouvel article</b></legend>
<table>
    <tr><td>Code article :</td><td><input type="text" name="id_article" size="10" maxlength="10"/></td></tr>
    <tr><td>Désignation :</td><td><input type="text" name="designation" size="40" maxlength="100"/></td></tr>
    <tr><td>Prix :</td><td><input type="text" name="prix" size="10" maxlength="10"/></td></tr>
    <tr><td>Catégorie :</td><td>
        <select name="categorie">
            <option value="video">Vidéo</option>
            <option value="informatique">Informatique</option>
            <option value="photo">Photo</option>
            <option value="divers">Divers</option>
        </select>
    </td></tr>
    <tr>
        <td><input type="reset" value="Effacer"></td>
        <td><input type="submit" value="Ajouter"></td>
    </tr>
</table>
</fieldset>
</form>

<?php
include("connexion.php");
$idcom = connexobjet('projet_web','myparam');

if(!empty($_POST['id_article']) && !empty($_POST['designation']) && !empty($_POST['prix']))
{
    $id_article  = $idcom->escape_string($_POST['id_article']);
    $designation = $idcom->escape_string($_POST['designation']);
    $prix        = $idcom->escape_string($_POST['prix']);
    $categorie   = $idcom->escape_string($_POST['categorie']);

    $requete = "INSERT INTO articles VALUES('$id_article','$designation','$prix','$categorie')";
    $result  = $idcom->query($requete);

    if(!$result)
    {
        echo $idcom->errno;
        echo $idcom->error;
        echo "<script type='text/javascript'>alert('Erreur : ".$idcom->error."')</script>";
    }
    else
    {
        echo "<script type='text/javascript'>alert('Article ajouté avec succès !');
        window.location='articles.php';</script>";
        $idcom->close();
    }
}
else { echo "<h3>Formulaire à compléter !</h3>"; }
?>

</main>
</body>
</html>