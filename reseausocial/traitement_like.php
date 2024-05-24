<?php
    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    include 'connexion_bdd.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (isset($_SESSION['user_id'])) 
        {
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['user_id'];
            $check_like_query = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
            $check_like_result = $db_connexion->query($check_like_query);

            if ($check_like_result->num_rows > 0) 
            {
                $delete_like_query = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
                $db_connexion->query($delete_like_query);
            } 
            else 
            {
                $add_like_query = "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')";
                $db_connexion->query($add_like_query);
            }
        }
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
?>
