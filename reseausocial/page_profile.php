<?php include 'header.php'; ?>
<?php
    if (!isset($_SESSION['user_id'])) 
    {
        header("Location: page_connexion.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];
    include 'connexion_bdd.php';
    $sql = "SELECT nom, prenom, photo_de_profil FROM Users WHERE user_id='$user_id'";
    $result = $db_connexion->query($sql);

    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        $nom_utilisateur = $row['nom'];
        $prenom_utilisateur = $row['prenom'];
        $photo_de_profil = $row['photo_de_profil'];
    } 
    else 
    {
        $nom_utilisateur = "Nom";
        $prenom_utilisateur = "PrÃ©nom";
        $photo_de_profil = "photo_profile_generique.jpg";
    }
    $sql_posts = "SELECT contenu_text, contenu_photo, post_id FROM Posts WHERE user_id='$user_id' ORDER BY date_post DESC";
    $result_posts = $db_connexion->query($sql_posts);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil</title>
        <style>
                body 
                {
                    font-family:'Poppins', sans-serif;
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
                    position: relative ; 
                    margin-bottom: 100px;
                    text-align: center;
                    float : left ; 
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
                    background-color: #4CAF50;
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

                .lists-container {
                   display : flex ; 
                   flex-direction: row;
                
                   justify-content: space-between;
                   width: 95%;
                   margin-bottom: 20px;
                }  
                   
                .posts-list {
                    display: flex; 
                    justify-content:center; 
                    flex-direction: column ; 
                    width: 60%; 
                    background-color : White;
                
                
                }
           
               .friends-list {
                  display : flex; 
                  flex-direction : row; 
                  flex-wrap : wrap ;
                   width: 30%;
                   background-color : White; 
                   right: 20px;
                   margin : 20px;
                }  
                
                
                .list h3 
                {
                    
                    background-color : white ;
                    margin-top: 10px;
                    text-align: center; 
                  
                }

                #nouveau-post 
                {
                    
                    margin-top: 20px;
                    border:  0px;
                    padding: 10px;
                    border-radius: 5px;
                    background-color: white;
                    text-align: center; 
                }

                #nouveau-post h2 
                {
                    display : inline; 
                    justify-content: center; 
                
                    padding: 10px;
                    margin-top: 10px;
                    margin-bottom:10px; 
                    font-size: 18px;
                }

                #nouveau-post textarea 
                {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    width: 100%;
                    padding: 15px;
                    margin-top:10px;
                    border-radius: 5px;
                    border: 0px ;
                    resize: vertical;
                    box-sizing: border-box
                }

                #nouveau-post input[type="file"] 
                {
                    margin-bottom: 10px;
                    padding-bottom:5px;
                    padding-top:5px;
                }

                #nouveau-post input[type="submit"] 
                {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    background-color:#45a049;
                    color: white ;
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
                    
                    display: flex ;
                    justify-content:space-between  ; 
                    flex-direction : column; 
                    margin:40px;
                    padding: 30px;
                    background-color:white;
                    border-radius: 10px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .post h3 
                {
                    display: inline;
                    margin-top: 0;
                }

                .post img 
                {
                    
                    max-width:100%;
                    height: auto;
                    border-radius: 0px;
                    margin-top: 10px;
                }
               
                .interactions-container{
                 display: flex; 
                 flex-direction:row; 
                 justify-content: flex-end; 
                 align-items : center;
                }
                
                
                .like-button 
                {
                   
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
                 vertical-align : middle;
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
                    vertical-align : middle; 
                }

                .friend 
                {
                   display : flex;  
                   flex-direction: row;  
                   justify-content : space-between;  
                  border-radius : 10px; 
                   box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    padding: 20px; 
                    margin-bottom: 20px; 

                }


                .friend img 
                {
                    width: 50px; 
                    height: 60px;
                    border-radius: 50%; 
                    margin-right: 10px; 
                    
                }

                .friend-details 
                {
                    
                    display: flex;
                    flex-direction: row;
                    justify-content : space-between; 
                    gap : 20px; 
                }

                .friend p
                {
                   
                    display: flex;
                    flex-direction: row;
                    justify-content : space-between; 
                }

                .like-count 
                {
                    border: none;
                    font-size: 25px;
                    margin-right: 10px;
                   padding: 5px 10px;
                    vertical-align : middle; 
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
            <a href="page_changement_pdp.php"><button id="change-photo">Changer la photo de profil</button></a>
            <div id="user-info">
                <h2><?php echo $nom_utilisateur . " " . $prenom_utilisateur; ?></h2>
            </div>
        </div>
           <div class="lists-container"> 
              <div class="friends-list">
                   <?php
                   $session_user_id = $_SESSION['user_id'];
                    $sql_friends = "SELECT U.user_id, U.nom, U.prenom, U.photo_de_profil 
                                FROM Users U 
                                JOIN friends F ON (U.user_id = F.user_id1 OR U.user_id = F.user_id2) 
                                WHERE (F.user_id1='$session_user_id' OR F.user_id2='$session_user_id') 
                                AND U.user_id != '$session_user_id'";
                   $result_friends = $db_connexion->query($sql_friends);

                       if ($result_friends->num_rows > 0) {
                      echo '<div class="list">';
                      echo '<h3>Liste d\'amis</h3>';
                      while ($row_friend = $result_friends->fetch_assoc()) {
                        $profile_link = 'page_profile_visiteur.php?user_id=' . $row_friend['user_id'];
                        echo '<div class="friend">';
                        echo '<a href="' . $profile_link . '">';
                        echo '<img src="' . $row_friend['photo_de_profil'] . '" alt="Photo de profil">';
                        echo '</a>';
                        echo '<p> ' . $row_friend['nom'] . '</p>';
                        echo '<p>' . $row_friend['prenom'] . '</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                    } else {
                    echo '<div class="list">';
                    echo '<h3>Liste d\'amis</h3>';
                    echo '<p>Aucun ami Ã  afficher.</p>';
                        echo '</div>';
                     }
                     ?>
              </div>

              <div class="posts-list">
                 <div class="list">
                   <h3>Posts</h3>
                    <div id="nouveau-post">
                    <h2>Publier un nouveau post</h2>
                    <form action="ajout_post.php" method="POST" enctype="multipart/form-data">
                        <textarea name="contenu" rows="4" cols="50" placeholder="Exprimez-vous..."></textarea>
                        <br>
                        <input type="file" name="image" accept="image/*"> 
                        <br>
                        <input type="submit" value="Publier">
                    </form>
                </div>
                <br>
                <br>
                <?php
                    if ($result_posts->num_rows > 0) {
                        while ($row_post = $result_posts->fetch_assoc()) {
                            echo '<div class="post">';
                            echo '<h3>' . $nom_utilisateur . " " . $prenom_utilisateur . '</h3>';
                            echo '<p>' . $row_post['contenu_text'] . '</p>';

                            if (!empty($row_post['contenu_photo'])) {
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
                ?>                   
                </div>
                </div>
        </div>
    </div>
</body>
</html>
