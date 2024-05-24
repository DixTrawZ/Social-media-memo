<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "reseau_bdd";

$db_connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($db_connexion->connect_error) 
{
    die("Erreur de connexion à la base de données : " . $db_connexion->connect_error);
}
?>