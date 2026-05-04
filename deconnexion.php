<?php
session_start();      // On démarre la session pour pouvoir la détruire
session_destroy();    // Supprime toutes les données de la session (déconnecte le client)
header("Location: index.php");  // Redirige vers la page d'accueil
exit();
?>