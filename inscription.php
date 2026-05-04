<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Ma Plateforme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="images/logo_eneam.png" alt="Logo ENEAM">
    <h1>Bienvenue sur ma plateforme</h1>
    <img src="images/logo_uac.png" alt="Logo UAC">
</header>

<nav>
    <a href="index.php">Accueil</a>
    <a href="login.php">Se connecter</a>
</nav>

<main>
<h2>Créer un compte client</h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="application/x-www-form-urlencoded">
<fieldset>
<legend><b>Vos informations</b></legend>
<table>
    <tr><td>Nom :</td><td><input type="text" name="nom" size="40" maxlength="50"/></td></tr>
    <tr><td>Prénom :</td><td><input type="text" name="prenom" size="40" maxlength="50"/></td></tr>
    <tr><td>Âge :</td><td><input type="text" name="age" size="10" maxlength="3"/></td></tr>
    <tr><td>Adresse :</td><td><input type="text" name="adresse" size="40" maxlength="100"/></td></tr>
    <tr><td>Ville :</td><td><input type="text" name="ville" size="40" maxlength="50"/></td></tr>
    <tr><td>E-mail :</td><td><input type="text" name="mail" size="40" maxlength="100"/></td></tr>
    <tr><td>Téléphone :</td><td><input type="text" name="telephone" size="40" maxlength="20"/></td></tr>
    <tr><td>Mot de passe :</td><td><input type="password" name="mot_de_passe" size="40"/></td></tr>
    <tr>
        <td><input type="reset" value="Effacer"></td>
        <td><input type="submit" value="S'inscrire"></td>
    </tr>
</table>
</fieldset>
</form>

<?php
include("connexion.php");
$idcom = connexobjet('projet_web','myparam');

if(!empty($_POST['nom']) && !empty($_POST['adresse']) && !empty($_POST['ville']))
{
    $id_client = "\N";
    $nom          = $idcom->escape_string($_POST['nom']);
    $prenom       = $idcom->escape_string($_POST['prenom']);
    $age          = $idcom->escape_string($_POST['age']);
    $adresse      = $idcom->escape_string($_POST['adresse']);
    $ville        = $idcom->escape_string($_POST['ville']);
    $mail         = $idcom->escape_string($_POST['mail']);
    $telephone    = $idcom->escape_string($_POST['telephone']);
    $mot_de_passe = $idcom->escape_string($_POST['mot_de_passe']);

    $requete = "INSERT INTO clients VALUES('$id_client','$nom','$prenom','$age','$adresse','$ville','$mail','$telephone','$mot_de_passe')";
    $result  = $idcom->query($requete);

    if(!$result)
    {
        echo $idcom->errno;
        echo $idcom->error;
        echo "<script type='text/javascript'>alert('Erreur : ".$idcom->error."')</script>";
    }
    else
    {
        echo "<script type='text/javascript'>alert('Inscription réussie ! Votre numéro de client est : ".$idcom->insert_id."');
        window.location='login.php';</script>";
        $idcom->close();
    }
}
else { echo "<h3>Formulaire à compléter !</h3>"; }
?>

</main>
</body>
</html>