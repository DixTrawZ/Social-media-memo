<?php include 'header.php';?>

<?php
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        include 'connexion_bdd.php';
        $sql = "SELECT nom, prenom, photo_de_profil FROM Users WHERE user_id='$user_id'";
        $result = $db_connexion->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nom_utilisateur = $row['nom'];
            $prenom_utilisateur = $row['prenom'];
            $photo_de_profil = $row['photo_de_profil'];
        } else {
            $nom_utilisateur = "Nom";
            $prenom_utilisateur = "Prénom";
            $photo_de_profil = "photo_profile_generique.jpg";
        }

        $sql_posts = "SELECT contenu_text, contenu_photo, post_id FROM Posts WHERE user_id='$user_id' ORDER BY date_post DESC";
        $result_posts = $db_connexion->query($sql_posts);
    } else {
        header("Location: page_erreur.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Visiteur</title>
    <style>
       
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        #profile {
            position: relative;
            margin-bottom: 100px;
            text-align: center;
            float: left;
        }
        #profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: white;
            display: block;
            margin: 0 auto 10px;
        }
        #user-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .lists-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 95%;
            margin-bottom: 20px;
        }
        .list-posts {
            display: flex;
            justify-content: center;
            flex-direction: column;
            width: 60%;
            background-color: White;
        }
        .list-friends {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            width: 30%;
            background-color: White;
            margin: 20px;
        }
        .list h3 {
            background-color: white;
            margin-top: 10px;
            text-align: center;
        }
        .post {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            margin: 40px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .post h3 {
            display: inline;
            margin-top: 0;
        }
        .post img {
            max-width: 100%;
            height: auto;
            border-radius: 0px;
            margin-top: 10px;
        }
        .interactions-container {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
        }
        .like-button {
            background-color: transparent;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }
        .like-button img {
            width: 20px;
            height: 20px;
            vertical-align: middle;
        }
        .comment-btn {
            background-color: transparent;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            font-size: 14px;
        }
        .comment-btn img {
            width: 20px;
            height: 20px;
            vertical-align: middle;
        }
        .add_friend_button {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .friend {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .friend img {
            width: 50px;
            height: 60px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .friend-details {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            gap: 20px;
        }
        .friend p {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .like-count {
            border: none;
            font-size: 25px;
            margin-right: 10px;
            padding: 5px 10px;
            vertical-align: middle;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="profile">
            <a href="page_profile.php?user_id=<?php echo $user_id; ?>">
                <img src="<?php echo $photo_de_profil; ?>" alt="Photo de profil">
            </a>
            <div id="user-info">
                <h2><?php echo $nom_utilisateur . " " . $prenom_utilisateur; ?></h2>
                <?php
                    if (isset($_SESSION['message'])) {
                        $message = $_SESSION['message'];
                        echo "<p>$message</p>";
                        unset($_SESSION['message']);
                    }
                ?>
                <form action="ajouter_ami.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
                    <input type="hidden" name="session_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <button type="submit" name="add_friend_button" class="add_friend_button">Ajouter comme ami(e)</button>
                </form>
            </div>
        </div>
        <div class="lists-container">
            <div class="list-friends">
                <div class="list">
                    <h3>Liste d'amis</h3>
                    <?php
                        if (isset($_GET['user_id'])) {
                            $url_user_id = $_GET['user_id'];
                        }
                        $sql_friends = "SELECT U.user_id, U.nom, U.prenom, U.photo_de_profil
                                        FROM Users U
                                        JOIN friends F ON (U.user_id = F.user_id1 OR U.user_id = F.user_id2)
                                        WHERE (F.user_id1='$url_user_id' OR F.user_id2='$url_user_id')
                                        AND U.user_id != '$url_user_id'";
                        $result_amis = $db_connexion->query($sql_friends);

                        if ($result_amis->num_rows > 0) {
                            while ($row_ami = $result_amis->fetch_assoc()) {
                                if ($_SESSION['user_id'] != $row_ami['user_id']) {
                                    $profile_link = 'page_profile_visiteur.php?user_id=' . $row_ami['user_id'];
                                } else {
                                    $profile_link = 'page_profile.php';
                                }
                                echo '<div class="friend">';
                                echo '<a href="' . $profile_link . '">';
                                echo '<img src="' . $row_ami['photo_de_profil'] . '" alt="Photo de profil">';
                                echo '</a>';
                                echo '<div class="friend-details">';
                                echo '<p>' . $row_ami['nom'] . '</p>';
                                echo '<p>' . $row_ami['prenom'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "<p>Aucun ami à afficher.</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="list-posts" >
                <div class="list"> 
                   <h3>Posts </h3>
                    <?php
                    if ($result_posts->num_rows > 0) {
                        while ($row_post = $result_posts->fetch_assoc()) 
                        {
                            echo '<div class="post">';
                            echo '<h3>' . $nom_utilisateur . " " . $prenom_utilisateur . '</h3>';
                            echo '<p>' . $row_post['contenu_text'] . '</p>';

                            if (!empty($row_post['contenu_photo'])) 
                            {
                                echo '<img src="' . $row_post['contenu_photo'] . '" alt="Photo du post">';
                            }
                            $post_id = $row_post['post_id'];
                            $sql_likes_count = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id='$post_id'";
                            $result_likes_count = $db_connexion->query($sql_likes_count);
                            $row_likes_count = $result_likes_count->fetch_assoc();
                            $like_count = $row_likes_count['like_count'];
                            echo '<div class="interactions-container">';
                            echo '<form action="page_commentaire.php" method="GET">';
                            echo '<input type="hidden" name="post_id" value="' . $row_post['post_id'] . '">';
                            echo '<button type="submit" class="comment-btn"><img src="./chat-bubble.png " /></button>';
                            echo '</form>';
                            echo '<form action="traitement_like.php" method="POST">';
                            echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                            echo '<div class="like-container">';
                            echo '<button type="submit" class="like-button"><img src="./like.png" /></button>';
                            echo '<span class="like-count">' . $like_count . ' </span>';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } 
                    else 
                    {
                        echo '<p style="text-align: center; margin: 20px 0;">Aucun post à afficher.</p>';
                    }
                ?>     
                </div>            
            </div>
        </div>
    </body>
</html>
