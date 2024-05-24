<?php
    include 'header.php';
    include 'connexion_bdd.php';

    if(isset($_GET['post_id'])) 
    {
        $post_id = $_GET['post_id'];
        $sql_post_details = "SELECT P.post_id, P.user_id, P.contenu_text, P.contenu_photo, P.date_post, U.nom, U.prenom, U.photo_de_profil 
                             FROM Posts P 
                             INNER JOIN Users U ON P.user_id = U.user_id 
                             WHERE P.post_id = '$post_id'";
        $result_post_details = $db_connexion->query($sql_post_details);
        if($result_post_details->num_rows > 0) 
        {
            $row_post = $result_post_details->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires</title>
    <style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: white;
    margin: 0;
    padding: 0;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center; 
    justify-content: flex-start;
    padding: 20px;
}

.post-details,
.comment-section,
.commentaires {
    width: 100%; 
    max-width: 800px; 
    background-color: #ffffff; 
    border-radius: 15px; 
    padding: 20px; 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 20px auto; 
    overflow: hidden; 
    box-sizing: border-box; 
}

.post-image {
    max-width: 100%; 
    height: auto; 
    display: block; 
    margin-top: 10px; }

.commentaire {
    border-bottom: 2px solid #ccc;
    padding-bottom: 20px; 
    margin-bottom: 20px; 
    width: 100%;
    box-sizing: border-box; 
}


.commentaire:hover {
    border-color: #666; 
}


.user-info {
    display: flex;
    align-items: center;
}

.profile-pic {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.contenu-commentaire {
    margin: 10px 0; 
}

.comment-date {
    color: #555; 
    font-size: 12px; 
    font-weight: bold; 
}


textarea {
    width: 100%; 
    max-width: 100%; 
    box-sizing: border-box; 
    margin-bottom: 10px; 
    padding: 10px; 
    border: 1px solid #ddd; 
    border-radius: 5px; 
}

button  
                {
                    background-color: transparent;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    padding: 5px 10px;
                    cursor: pointer;
                }
button img {
    
    width: 20px;
    height: 20px;
}
.post-date {
    font-size: 14px; 
    color: #888; 
    margin-top: 5px; 
    font-style: italic; 
}


    </style>
</head>
<body>
    <div class="post-details">
        <div class="user-info">
            <?php
                if($_SESSION['user_id']!=$row_post['user_id'])
                {
                    $profile_link = 'page_profile_visiteur.php?user_id=' . $row_post['user_id'];
                }
                else
                {
                    $profile_link = 'page_profile.php';
                }
                echo '<a href="' . $profile_link . '">';
                echo '<img class="profile-pic" src="' . $row_post['photo_de_profil'] . '" alt="Photo de profil">';
                echo '</a>';
            ?>
            <h3 class="user-name"><?php echo $row_post['prenom'] . ' ' . $row_post['nom']; ?></h3>
        </div>

        <div class="post-content">
            <p class="content-text"><?php echo $row_post['contenu_text']; ?></p>
            <?php if (!empty($row_post['contenu_photo'])) { ?>
                <img class="post-image" src="<?php echo $row_post['contenu_photo']; ?>" alt="Photo du post">
            <?php } ?>
        </div>

        <div class="post-footer">
            <p class="post-date">Date de publication: <?php echo $row_post['date_post']; ?></p>
        </div>
    </div>

    <div class="comment-section">
        <h2>Poster un commentaire</h2>
        <form action="traitement_commentaire.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <textarea name="contenu_commentaire" rows="4" cols="50" placeholder="Écrivez votre commentaire ..."></textarea><br>
            <button type="submit" class="button"><img src="./Envoyer.png " /></button>
        </form>
    </div>

    <div class="commentaires">
        <h2>Commentaires</h2>
        <?php
            include 'connexion_bdd.php';
            if (isset($_GET['post_id'])) 
            {
                $post_id = intval($_GET['post_id']); 
                $sql_get_comments = "SELECT C.contenu, C.created_at, U.nom, U.prenom, U.photo_de_profil
                                    FROM commentaires C
                                    INNER JOIN Users U ON C.user_id = U.user_id
                                    WHERE C.post_id = ?
                                    ORDER BY C.created_at DESC"; 

                if ($stmt = $db_connexion->prepare($sql_get_comments)) 
                {
                    $stmt->bind_param('i', $post_id); 
                    $stmt->execute(); 
                    $result = $stmt->get_result(); 
                    if ($result->num_rows > 0) 
                    {
                        echo '<div class="commentaires">';
                        while ($row_comment = $result->fetch_assoc()) 
                        {
                            echo '<div class="commentaire">'; 
                            echo '<div class="user-info">';
                            if($_SESSION['user_id']!=$row_post['user_id'])
                            {
                                $profile_link = 'page_profile_visiteur.php?user_id=' . $row_post['user_id'];
                            }
                            else
                            {
                                $profile_link = 'page_profile.php';
                            }
                            echo '<a href="' . $profile_link . '">';
                            echo '<img class="profile-pic" src="' . htmlspecialchars($row_comment['photo_de_profil']) . '" alt="Photo de profil">';
                            echo '</a>';
                            echo '<span class="user-name">' . htmlspecialchars($row_comment['prenom'] . ' ' . $row_comment['nom']) . '</span>';
                            echo '</div>'; 
                            echo '<p class="contenu-commentaire">' . htmlspecialchars($row_comment['contenu']) . '</p>';
                            echo '<p class="comment-date">' . htmlspecialchars($row_comment['created_at']) . '</p>';
                            echo '</div>'; 
                        }
                        echo '</div>'; 
                    } 
                    else 
                    {
                        echo '<p>Aucun commentaire trouvé pour cette publication.</p>';
                    }
                    $stmt->close();
                } 
                else 
                {
                    echo 'Erreur lors de la préparation de la requête.';
                }
            } 
            else 
            {
                echo 'Identifiant du post non fourni.';
            }
            $db_connexion->close();
        ?>

    </div>
</body>
</html>

<?php
        } 
        else 
        {

            echo "Post non trouvé.";
        }
    } 
    else 
    {
        echo "Identifiant de publication non spécifié.";
    }
?>