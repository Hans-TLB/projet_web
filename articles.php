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
    <title>Articles - Ma Plateforme</title>
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
<h2>Liste des articles</h2>

<?php
include("connexion.php");
$idcom = connexobjet('projet_web','myparam');

// Requête SQL pour lire tous les articles (Exemple 15-4)
$requete = "SELECT * FROM articles ORDER BY designation";
$result  = $idcom->query($requete);

if(!$result)
{
    echo "Lecture impossible";
}
else
{
    $nbart  = $result->num_rows;   // Nombre d'articles trouvés
    $nbcol  = $result->field_count; // Nombre de colonnes
    $titres = $result->fetch_fields(); // Récupère les noms des colonnes

    echo "<h3>Il y a $nbart article(s) dans la base</h3>";

    // Affichage des titres du tableau
    echo "<table border='1'><tr>";
    foreach($titres as $nomcol => $val)
    {
        echo "<th>".$titres[$nomcol]->name."</th>";
    }
    echo "</tr>";

    // Affichage des lignes du tableau
    for($i=0; $i<$nbart; $i++)
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
    $result->free();  // Libère la mémoire occupée par le résultat
    $idcom->close();
}
?>

<br>
<a href="ajouter_article.php"><input type="button" value="Ajouter un article"></a>
<a href="accueil.php"><input type="button" value="Quitter"></a>

</main>
</body>
</html>