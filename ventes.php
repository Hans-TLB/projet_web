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
    <title>Ventes - Ma Plateforme</title>
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
<h2>Liste des ventes</h2>

<?php
include("connexion.php");
$idcom = connexobjet('projet_web','myparam');

$requete = "SELECT v.id, c.nom, c.prenom, a.designation, v.quantite, v.date_vente FROM ventes v, clients c, articles a WHERE v.id_client=c.id AND v.id_article=a.id_article ORDER BY v.date_vente DESC";
$result  = $idcom->query($requete);

if(!$result)
{
    echo "Lecture impossible";
}
else
{
    $nbvente = $result->num_rows;
    $nbcol   = $result->field_count;
    $titres  = $result->fetch_fields();

    echo "<h3>Il y a $nbvente vente(s) enregistrée(s)</h3>";

    echo "<table border='1'><tr>";
    foreach($titres as $nomcol => $val)
    {
        echo "<th>".$titres[$nomcol]->name."</th>";
    }
    echo "</tr>";

    for($i=0; $i<$nbvente; $i++)
    {
        $ligne = $result->fetch_row();
        echo "<tr>";
        for($j=0; $j<$nbcol; $j++)
        {
            echo "<td>".$ligne[$j]."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
    $idcom->close();
}
?>

<br>
<a href="effectuer_vente.php"><input type="button" value="Effectuer une vente"></a>
<a href="accueil.php"><input type="button" value="Quitter"></a>

</main>

</body>
</html>