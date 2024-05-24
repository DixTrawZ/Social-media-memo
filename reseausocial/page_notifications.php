<?php include 'header.php'; ?>
<?php
    if (!isset($_SESSION['user_id'])) 
    {
        header("Location: page_connexion.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        #profile 
        {
            position: relative;
            margin-bottom: 20px;
            text-align: center;
        }

        #profile img 
        {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #000; 
            display: block; 
            margin: 0 auto 10px; 
        }

        #change-photo 
        {
            background-color: #66cc99; 
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #user-info 
        {
            text-align: center;
            margin-bottom: 20px;
        }

        .lists 
        {
            display: flex;
            justify-content: space-around;
            width: 80%;
            margin-bottom: 20px;
        }

        .list 
        {
            width: 45%;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .list h3 
        {
            margin-top: 0;
        }

        #nouveau-post 
        {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        #nouveau-post h2 
        {
            margin-top: 0;
            font-size: 18px;
        }

        #nouveau-post textarea 
        {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
            box-sizing: border-box
        }

        #nouveau-post input[type="file"] 
        {
            margin-bottom: 10px;
        }

        #nouveau-post input[type="submit"] 
        {
            background-color: #66cc99; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #nouveau-post input[type="submit"]:hover 
        {
            background-color: #45a049;
        }

        .post 
        {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .post h3 
        {
            margin-top: 0;
        }

        .post img 
        {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }

        .like-button 
        {
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .friend 
        {
            border-radius: 10px; 
            border: 1px solid #ccc; 
            padding: 10px; 
            margin-bottom: 20px; 
        }

        .friend img 
        {
            width: 50px; 
            height: 50px;
            border-radius: 50%; 
            margin-right: 10px; 
        }

        .friend-details 
        {
            display: flex;
            flex-direction: column;
        }

        .friend p
        {
            margin: 0; 
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="lists">
            <?php

                $user_id = $_SESSION['user_id'];
                include 'connexion_bdd.php';
                $friends_query = "
                SELECT CASE 
                           WHEN user_id1 = '$user_id' THEN user_id2
                           ELSE user_id1
                       END AS friend_id
                FROM friends
                WHERE user_id1 = '$user_id' OR user_id2 = '$user_id'";                
            $result_friends = $db_connexion->query($friends_query);
                $session_user_id = $_SESSION['user_id'];
                if ($result_friends->num_rows > 0) 
                {
                    echo '<div class="list">';
                        echo "<h3>Notifications d'ajout d'ami</h3>";
                        while ($row_friend = $result_friends->fetch_assoc()) 
                    {
                        $friend_id = $row_friend['friend_id'];
                        $friend_info_query = "SELECT nom, prenom, photo_de_profil FROM users WHERE user_id = '$friend_id'";
                        $result_friend_info = $db_connexion->query($friend_info_query);

                        if ($result_friend_info->num_rows > 0) 
                        {
                            while ($row_info = $result_friend_info->fetch_assoc()) 
                            {
                                        if($_SESSION['user_id']!=$friend_id)
                                {
                                    $profile_link = 'page_profile_visiteur.php?user_id=' . $friend_id;
                                }
                                else
                                {
                                    $profile_link = 'page_profile.php';
                                }
                                $profile_link = 'page_profile_visiteur.php?user_id=' . $friend_id;
                                echo '<div class="friend">';
                                echo '<a href="' . $profile_link . '">';
                                echo '<img src="' . $row_info['photo_de_profil'] . '" alt="Photo de profil">';
                                echo '</a>';

                                echo '<div class="friend-details">';
                                echo '<p><strong>' . $row_info['prenom'] . ' ' . $row_info['nom'] . '</strong> Vous a ajouté comme ami ! </p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    }

                    echo '</div>';
                } 
                else 
                {
                    echo '<div class="list">';
                    echo '</div>';
                }
            ?>

            <div class="list">
                <h3>Notifications like / commentaires</h3>
                <?php
                    $posts_query = "SELECT post_id FROM posts WHERE user_id = '$user_id'";
                    $posts_result = $db_connexion->query($posts_query);
                    if ($posts_result->num_rows > 0) 
                    {
                        while ($post_row = $posts_result->fetch_assoc()) 
                        {
                            $post_id = $post_row['post_id'];
                            $likes_query = "SELECT user_id FROM likes WHERE post_id = '$post_id'";
                            $likes_result = $db_connexion->query($likes_query);

                            if ($likes_result->num_rows > 0) 
                            {
                                echo '<div class="friend-details">';
                                while ($like_row = $likes_result->fetch_assoc()) 
                                {
                                    $liker_id = $like_row['user_id'];
                                    $liker_info_query = "SELECT nom, prenom, photo_de_profil FROM users WHERE user_id = '$liker_id'";
                                    $liker_info_result = $db_connexion->query($liker_info_query);
                                    $liker_info = $liker_info_result->fetch_assoc();
                                    if($_SESSION['user_id']!=$liker_id)
                                    {
                                        $profile_link = 'page_profile_visiteur.php?user_id=' . $liker_id;
                                    }
                                    else
                                    {
                                        $profile_link = 'page_profile.php';
                                    }
                                    echo '<div class="friend">';
                                    echo '<a href="' . $profile_link . '">';
                                    echo '<img src="' . $liker_info['photo_de_profil'] . '" alt="Photo de profil">';
                                    echo '</a>';
                                    echo '<p><strong>' . $liker_info['nom'] . ' ' . $liker_info['prenom'] . '</strong> a aimé votre post.</p>';
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                        }
                    }

                    $session_user_id = $_SESSION['user_id'];
                    $posts_query = "SELECT post_id FROM posts WHERE user_id = '$session_user_id'";
                    $posts_result = $db_connexion->query($posts_query);
                    if ($posts_result->num_rows > 0) 
                    {
                        while ($post_row = $posts_result->fetch_assoc()) 
                        {
                            $post_id = $post_row['post_id'];
                            $comments_query = "SELECT user_id, contenu FROM commentaires WHERE post_id = '$post_id'";
                            $comments_result = $db_connexion->query($comments_query);
                            if ($comments_result->num_rows > 0) 
                            {
                                while ($comment_row = $comments_result->fetch_assoc()) 
                                {
                                    $user_id = $comment_row['user_id'];
                                    $contenu = $comment_row['contenu'];
                                    $user_info_query = "SELECT nom, prenom, photo_de_profil FROM users WHERE user_id = '$user_id'";
                                    $user_info_result = $db_connexion->query($user_info_query);
                                    $user_info = $user_info_result->fetch_assoc();
                                    if ($_SESSION['user_id'] != $user_id) 
                                    {
                                        $profile_link = 'page_profile_visiteur.php?user_id=' . $user_id;
                                    } 
                                    else 
                                    {
                                        $profile_link = 'page_profile.php';
                                    }
                                    echo '<div class="friend">';
                                    echo '<a href="' . $profile_link . '">';
                                    echo '<img src="' . $user_info['photo_de_profil'] . '" alt="Photo de profil">';
                                    echo '</a>';
                                    echo '<p><strong>' . $user_info['nom'] . ' ' . $user_info['prenom'] . '</strong> a commenté :</p>';
                                    echo '<p>' . $contenu . '</p>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    ?>                   
            </div>
        </div>
    </div>
</body>
</html>