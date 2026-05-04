<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Ma Plateforme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
<h2>Connexion</h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="application/x-www-form-urlencoded">
<fieldset>
<legend><b>Vos identifiants</b></legend>
<table>
    <tr><td>Login :</td><td><input type="text" name="login" size="40" maxlength="50"/></td></tr>
    <tr><td>Mot de passe :</td><td><input type="password" name="mot_de_passe" size="40"/></td></tr>
    <tr>
        <td><input type="reset" value="Effacer"></td>
        <td><input type="submit" value="Se connecter"></td>
    </tr>
</table>
</fieldset>
</form>

<?php
include("connexion.php");
$idcom = connexobjet('projet_web','myparam');

if(!empty($_POST['login']) && !empty($_POST['mot_de_passe']))
{
    $login        = $idcom->escape_string($_POST['login']);
    $mot_de_passe = $idcom->escape_string($_POST['mot_de_passe']);

    $requete = "SELECT * FROM users WHERE login='$login' AND mot_de_passe='$mot_de_passe'";
    $result  = $idcom->query($requete);

    if($result->num_rows == 1)
    {
        $user = $result->fetch_row();
        $_SESSION['user_id']    = $user[0];
        $_SESSION['user_login'] = $user[1];

        echo "<script type='text/javascript'>alert('Bienvenue ".$user[1]." !');
        window.location='accueil.php';</script>";
        $idcom->close();
    }
    else
    {
        echo "<h3>Login ou mot de passe incorrect !</h3>";
    }
}
else { echo "<h3>Formulaire à compléter !</h3>"; }
?>

<p style="margin-top:15px;">Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
</main>

</body>
</html>