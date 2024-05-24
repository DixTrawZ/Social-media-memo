<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">



        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceuil</title>
            <style>
                body 
                {
                    font-family: 'Poppins', sans-serif;
                    margin: 0;
                    padding: 0;
                }

                #container 
                {
                    display: flex;
                    justify-content: center;
                    align-items: flex-start;
                    height: 100vh;
                    padding-top: 20px;
                }

                #content 
                {
                    border-radius: 20px;
                    padding: 20px;
                    width: 90%; 
                    max-width: 800px; 
                }

                .post 
                {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

                    margin-bottom: 20px;
                    padding: 20px;
                    border-bottom: 1px solid #ccc;
                    border-radius: 10px;
                    background-color: #fff;
                }

                .user-info 
                {
                    display: flex;
                    
                    align-items: center;
                    margin-bottom: 10px;
                }

                .profile-pic 
                {
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                    margin-right: 10px;
                }

                .user-name {
                 margin: 0;
                 font-weight: bold;
                }

                .post-content 
                {
                    margin-bottom: 10px;
                }

                .content-text 
                {
                    margin: 0;
                }

                .post-image 
                {
                    max-width: 100%;
                    border-radius: 10px;
                    margin-top: 10px;
                }

                .post-footer 
                {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .post-date 
                {
                    font-family: 'Montserrat', sans-serif;
                    font-size: 11px;
                    margin: 0;
                    margin-left: 1rem;
                }

                .like-section 
                {
                    display: flex;
                    align-items: center;
                }

                .like-btn 
                {
                    background-color: transparent;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    padding: 5px 10px;
                    cursor: pointer;
                }
.like-btn img {
    
    width: 20px;
    height: 20px;
}
                .comment-btn
                {
                    margin-top: 1rem;
                    background-color: transparent;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    padding: 5px 10px;
                    cursor: pointer;
                }
                .comment-btn img {
                    width: 20px;
                    height: 20px;
                }
               
                .like-count 
                {
                    font-size: 30px;
                    margin: 0;
                    margin-left: 10px;
                }

            </style>
    </head>
    <body>
        <div id="container">
            <div id="content">
                <?php
                    include 'connexion_bdd.php';
                    $session_user_id = $_SESSION['user_id'];
                    $sql_friends_ids = "SELECT user_id1, user_id2 FROM friends WHERE user_id1='$session_user_id' OR user_id2='$session_user_id'";
                    $result_friends_ids = $db_connexion->query($sql_friends_ids);
                    $friend_ids = array();

                    while ($row_friend = $result_friends_ids->fetch_assoc()) 
                    {
                        if ($row_friend['user_id1'] != $session_user_id) 
                        {
                            $friend_ids[] = $row_friend['user_id1'];
                        }
                        if ($row_friend['user_id2'] != $session_user_id) 
                        {
                            $friend_ids[] = $row_friend['user_id2'];
                        }
                    }

                    if (!empty($friend_ids)) 
                    {
                        $friend_ids_string = implode(',', $friend_ids);
                        $sql_posts = "SELECT P.post_id, P.user_id, P.contenu_text, P.contenu_photo, P.date_post, U.nom, U.prenom, U.photo_de_profil 
                                      FROM Posts P 
                                      INNER JOIN Users U ON P.user_id = U.user_id 
                                      WHERE P.user_id IN ($friend_ids_string) 
                                      ORDER BY P.date_post DESC";
                        $result_posts = $db_connexion->query($sql_posts);

                        while ($row_post = $result_posts->fetch_assoc()) 
                        {
                            echo '<div class="post">';
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
                            echo '<img class="profile-pic" src="' . $row_post['photo_de_profil'] . '" alt="Photo de profil">';
                            echo '</a>';
                            
                            echo '<p class="user-name">' . $row_post['prenom'] . ' ' . $row_post['nom'] . '</p>';
                            $date_bd;

                            
                            $timestamp = strtotime($row_post['date_post']);
                            
                           
                            $date_formattee = date("l, F Y", $timestamp);
                            
                            
                           
                            echo '<p class="post-date">' . $date_formattee  .'</p>';

                            echo '</div>';
                            echo '<div class="post-content">';

                            echo '<p class="content-text">' . $row_post['contenu_text'] . '</p>';

                            if (!empty($row_post['contenu_photo'])) 
                            {
                                echo '<img class="post-image" src="' . $row_post['contenu_photo'] . '" alt="Photo du post">';
                            }
                            echo '</div>';
                            echo '<div class="post-footer">';
                            echo '<form action="page_commentaire.php" method="GET">';
                            echo '<input type="hidden" name="post_id" value="' . $row_post['post_id'] . '">';
                            echo '<button type="submit" class="comment-btn"><img src="./chat-bubble.png " /></button>';
                            echo '</form>';
                            echo '<form action="traitement_like.php" method="POST">';
                            echo '<input type="hidden" name="post_id" value="' . $row_post['post_id'] . '">';
                            echo '<div class="like-section">';
                            echo '<button type="submit" class="like-btn"><img src="./like.png" /></button>';
                            $sql_likes_count = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id='$row_post[post_id]'";
                            $result_likes_count = $db_connexion->query($sql_likes_count);
                            $row_likes_count = $result_likes_count->fetch_assoc();
                            $like_count = $row_likes_count['like_count'];
                            echo '<span class="like-count">' . $like_count . '</span>';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } 
                    else 
                    {
                        echo "<p>Aucun ami trouvé.</p>";
                    }

                ?>
            </div>
        </div>
    </body>
</html>
