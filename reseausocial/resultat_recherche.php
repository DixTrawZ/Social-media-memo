<?php
    include 'connexion_bdd.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $search_query = $_POST['search_query'];
        $sql = "SELECT * FROM Users WHERE nom LIKE '%$search_query%' OR prenom LIKE '%$search_query%'";
        $result = $db_connexion->query($sql);
        header("Location: page_resultat_recherche.php");
        exit();
    }
?>
