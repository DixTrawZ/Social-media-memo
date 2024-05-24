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
        $sql_posts = "SELECT P.user_id, P.contenu_text, P.contenu_photo, P.date_publication, U.nom, U.prenom, U.photo_de_profil 
                      FROM Posts P 
                      INNER JOIN Users U ON P.user_id = U.user_id 
                      WHERE P.user_id IN ($friend_ids_string) 
                      ORDER BY P.date_publication DESC";
        $result_posts = $db_connexion->query($sql_posts);

        while ($row_post = $result_posts->fetch_assoc()) 
        {
            echo '<div class="post">';
            echo '<div class="user-info">';
            echo '<img src="' . $row_post['photo_de_profil'] . '" alt="Photo de profil">';
            echo '<h3>' . $row_post['nom'] . ' ' . $row_post['prenom'] . '</h3>';
            echo '</div>';
            echo '<p>Contenu Text: ' . $row_post['contenu_text'] . '</p>';

            if (!empty($row_post['contenu_photo'])) 
            {
                echo '<img src="' . $row_post['contenu_photo'] . '" alt="Photo du post">';
            }
            echo '<p>Date de publication: ' . $row_post['date_publication'] . '</p>';
            echo '<button onclick="likePost(' . $row_post['post_id'] . ')">Like</button>';
            echo '</div>';
        }
    }
    else 
    {
        echo "<p>Aucun ami trouvé.</p>";
    }
?>