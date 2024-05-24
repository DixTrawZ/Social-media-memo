<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
<link rel="shortcut icon" type="x-icon" href="MEMOf.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEMO</title>
        <style>
            header 
            {
                background-color:white;

                padding: 2px;
                padding-left: 10px;
                padding-right: 10px;
                color: black;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }
            .little-flex {
                display: flex;

            }

            header h1 
            {
                margin: 0;
            }

            header .profile-picture-container 
            {
                width: 40px;
                height: 40px;
                border-radius: 50%; 
                overflow: hidden; 
                cursor: pointer;
            }
            
            header .profile-picture 
            {
                width: 100%; 
                height: auto; 
                display: block; 
            }

            header input[type="text"] 
            {
                border-radius: 5px;
                background-color: white;
                padding: 10px;
                border: none;
                width: 200px;
                margin-right: 10px;
            }

            header button 
            {
             
                border-radius: 5px;
                border: none;
                cursor: pointer;
                background-color:transparent;
                color: white;
            }

            .search-container 
            {
                display: flex;
                width: 200px;
                align-items: center;
            }

            header button[type="button"] 
            {
                padding: 5px 10px;
                border-radius: 5px;
                border: none;
                cursor: pointer;
                background-color: red;
                color: white;
                margin-right: 10px; 
            }
            .logout:hover {
                background-color: red;
                padding: 3px;
                border-radius: 40%;
            }
.form_search {
    margin-left: 3rem;
    display: flex;
        align-items: center;
        justify-content: center;
        flex-grow: 3;
        padding: 0 250px;
    background-color:transparent;
}
        </style>
</head>
    <body>
        <header>
            <div class="little-flex">
            <h1>
                <a href="page_principale.php" style="color: white;">
                <span style="font-family: 'Pacifico', cursive; color: #42b72a; font-size: 40px;">MEMO</span>
                </a>
            </h1>
            <div class="search-container">
                <form class="form_search" action="page_resultat_recherche.php" method="POST">
                <input type="text" name="search_query" placeholder="Rechercher des utilisateurs...">
                <button type="submit">
                        <img src="./search-interface-symbol.png" style="width: 20px; height:20px; margin-top:10px;"/>
                    </button>        
                </form>
            </div>
            </div>
            <div class="little-flex">
           
            <div type="button" class="logout" style="position:absolute ;top:25px; right:10px;"  onclick="window.location.href='deconnexion.php'"> <img style="width: 30px ; height:30px;" src="./exit.png" /></div>
            <div type="button" class="notification-button" style="position:absolute ;top:25px; left:250px; " onclick="window.location.href='page_notifications.php'"><img style="width: 30px ; height:30px;" src="./cloche.png" /></div>
        
            <?php
                include 'connexion_bdd.php';

                if (session_status() == PHP_SESSION_NONE) 
                {
                    session_start();
                }
                if (!isset($_SESSION['user_id'])) {

                    header("Location: page_connexion.php");
                    exit();
                }
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT nom, prenom, photo_de_profil FROM users WHERE user_id='$user_id'";
                $result = $db_connexion->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $cheminImageProfil = $row['photo_de_profil'];
                    $nom = $row['nom'];
                    $prenom = $row['prenom'];
                } else {
                    $cheminImageProfil = 'photo_profile_generique.jpg';
                    $nom = '';
                    $prenom = '';
                }
                $db_connexion->close();

                echo '<div class="user-info" style="position:absolute ;top:15px; right:110px;">';
                echo '<p>' . htmlspecialchars($nom) . ' ' . htmlspecialchars($prenom) . '</p>';
                echo '</div>';

                echo '<div type="button" class="logout" style="position:absolute ;top:25px; right:10px;" onclick="window.location.href=\'deconnexion.php\'"><img style="width: 30px ; height:30px;" src="./exit.png" /></div>';

                echo '<a href="page_profile.php" class="profile-picture-container" style="position:absolute; top:20px; right:55px;"><img class="profile-picture" src="' . htmlspecialchars($cheminImageProfil) . '" alt="Photo cliquable"></a>';

            ?>
             </div>
        </header>
    </body>
</html>
