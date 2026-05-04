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
    <title>Effectuer une vente - Ma Plateforme</title>
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
    <a href="clients.php">Liste clients</a>
    <a href="users.php">Liste users</a>
    <a href="deconnexion.php" class="quitter">Quitter</a>
</nav>

<main>
<h2>Effectuer une vente</h2>

<?php
include("connexion.php");
$idcom = connexobjet('projet_web','myparam');
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="application/x-www-form-urlencoded">
<fieldset>
<legend><b>Nouvelle vente</b></legend>
<table>
    <tr>
        <td>Client :</td>
        <td>
        <select name="id_client" id="id_client" onchange="majClient()">
        <?php
        $req_clients = "SELECT id, nom, prenom FROM clients ORDER BY nom";
        $res_clients = $idcom->query($req_clients);
        while($client = $res_clients->fetch_row())
        {
            echo "<option value='".$client[0]."'>".$client[1]." ".$client[2]."</option>";
        }
        $res_clients->free();
        ?>
        </select>
        </td>
    </tr>
    <tr>
        <td>Article :</td>
        <td>
        <select name="id_article" id="id_article" onchange="majPrix()">
        <?php
        $req_articles = "SELECT id_article, designation, prix FROM articles ORDER BY designation";
        $res_articles = $idcom->query($req_articles);
        // On stocke les prix dans un tableau JavaScript
        echo "<script>var prix = {};</script>";
        while($article = $res_articles->fetch_row())
        {
            echo "<option value='".$article[0]."'>".$article[1]." (".$article[2]." FCFA)</option>";
            echo "<script>prix['".$article[0]."'] = ".$article[2].";</script>";
        }
        $res_articles->free();
        ?>
        </select>
        </td>
    </tr>
    <tr>
        <td>Nom :</td>
        <td><input type="text" id="nom" size="40" readonly/></td>
    </tr>
    <tr>
        <td>Prénom :</td>
        <td><input type="text" id="prenom" size="40" readonly/></td>
    </tr>
    <tr>
        <td>Adresse :</td>
        <td><input type="text" id="adresse" size="40" readonly/></td>
    </tr>
    <tr>
        <td>Ville :</td>
        <td><input type="text" id="ville" size="40" readonly/></td>
    </tr>
    <tr>
        <td>Téléphone :</td>
        <td><input type="text" id="telephone" size="40" readonly/></td>
    </tr>
    <tr>
        <td>Prix unitaire (FCFA) :</td>
        <td><input type="text" name="prix_unitaire" id="prix_unitaire" size="20" readonly/></td>
    </tr>
    <tr>
        <td>Quantité :</td>
        <td><input type="text" name="quantite" id="quantite" size="10" maxlength="5" onkeyup="calculMontant()"/></td>
    </tr>
    <tr>
        <td>Montant (FCFA) :</td>
        <td><input type="text" name="montant" id="montant" size="20" readonly/></td>
    </tr>
    <tr>
        <td><input type="reset" value="Effacer"></td>
        <td><input type="submit" value="Enregistrer la vente"></td>
    </tr>
</table>
</fieldset>
</form>

<!-- Script JavaScript pour calculer automatiquement le prix et le montant -->
<script type="text/javascript">
var clients = {};
<?php
$idcom2 = connexobjet('projet_web','myparam');
$req = "SELECT id, nom, prenom, adresse, ville, telephone FROM clients";
$res = $idcom2->query($req);
while($c = $res->fetch_row())
{
    echo "clients[".$c[0]."] = {nom:'".$c[1]."', prenom:'".$c[2]."', adresse:'".$c[3]."', ville:'".$c[4]."', telephone:'".$c[5]."'};";
}
$res->free();
$idcom2->close();
?>

function majClient()
{
    var id = document.getElementById('id_client').value;
    if(clients[id])
    {
        document.getElementById('nom').value       = clients[id].nom;
        document.getElementById('prenom').value    = clients[id].prenom;
        document.getElementById('adresse').value   = clients[id].adresse;
        document.getElementById('ville').value     = clients[id].ville;
        document.getElementById('telephone').value = clients[id].telephone;
    }
}

function majPrix()
{
    var id_article    = document.getElementById('id_article').value;
    var prix_unitaire = prix[id_article];
    document.getElementById('prix_unitaire').value = prix_unitaire;
    calculMontant();
}

function calculMontant()
{
    var prix_unitaire = parseFloat(document.getElementById('prix_unitaire').value);
    var quantite      = parseInt(document.getElementById('quantite').value);
    if(!isNaN(prix_unitaire) && !isNaN(quantite))
    {
        document.getElementById('montant').value = prix_unitaire * quantite;
    }
}

window.onload = function()
{
    majPrix();
    majClient();
}
</script>

<?php
if(!empty($_POST['id_client']) && !empty($_POST['id_article']) && !empty($_POST['quantite']))
{
    $id_vente      = "\N";
    $id_client     = $idcom->escape_string($_POST['id_client']);
    $id_article    = $idcom->escape_string($_POST['id_article']);
    $quantite      = $idcom->escape_string($_POST['quantite']);
    $prix_unitaire = $idcom->escape_string($_POST['prix_unitaire']);
    $montant       = $idcom->escape_string($_POST['montant']);

    $requete = "INSERT INTO ventes VALUES('$id_vente','$id_client','$id_article','$quantite',NOW(),'$montant')";
    $result  = $idcom->query($requete);

    if(!$result)
    {
        echo $idcom->errno;
        echo $idcom->error;
        echo "<script type='text/javascript'>alert('Erreur : ".$idcom->error."')</script>";
    }
    else
    {
        echo "<script type='text/javascript'>alert('Vente enregistrée avec succès !');
        window.location='ventes.php';</script>";
        $idcom->close();
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'POST') { echo "<h3>Formulaire à compléter !</h3>"; }
?>

</main>

</body>
</html>