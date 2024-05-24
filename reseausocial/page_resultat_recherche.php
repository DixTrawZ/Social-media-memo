<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Résultats de recherche</title>
            <style>
                body 
                {
                    font-family: 'Poppins', sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: white; 
                }

                .container 
                {
                    width: 80%;
                    margin: 20px auto;
                    background-color: white; 
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                .user {
              display: flex;
               align-items: center;
               margin-bottom: 10px;
                padding: 10px;
                  border: 1px solid #e0e0e0; 
                 border-radius: 10px; 
                 box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
                 background-color: #fff; 
}

                .user img 
                {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    margin-right: 10px;
                }

                .user-details 
                {
                    font-size: 16px;
                }
            </style>
    </head>
    <body>
        <div class="container">
            <?php
                include 'connexion_bdd.php';
                if ($_SERVER["REQUEST_METHOD"] == "POST") 
                {
                    $search_query = $_POST['search_query'];
                    $sql = "SELECT * FROM Users WHERE nom LIKE '%$search_query%' OR prenom LIKE '%$search_query%'";
                    $result = $db_connexion->query($sql);
                }
                while ($row = $result->fetch_assoc()) 
                {
                    echo '<div class="user">';

                    if($_SESSION['user_id']!=$row['user_id'])
                    {
                        $profile_link = 'page_profile_visiteur.php?user_id=' . $row['user_id'];
                    }
                    else
                    {
                        $profile_link = 'page_profile.php';
                    }
                    echo '<a href="' . $profile_link . '">';
                    echo '<img src="' . $row['photo_de_profil'] . '" alt="Photo de profil">';
                    echo '</a>';
                    echo '<div class="user-details">';
                    echo '<p>Nom: ' . $row['nom'] . '</p>';
                    echo '<p>Prénom: ' . $row['prenom'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
    </body>
</html>
