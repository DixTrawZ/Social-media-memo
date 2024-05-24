<?php
include 'connexion_bdd.php';
session_start();
if (isset($_POST['add_friend_button'])) 
{
    $user_id = $_POST['user_id'];
    $session_user_id = $_POST['session_user_id'];
    $sql = "SELECT * FROM friends WHERE (user_id1='$user_id' AND user_id2='$session_user_id') OR (user_id1='$session_user_id' AND user_id2='$user_id')";
    $result = $db_connexion->query($sql);

    if ($result->num_rows > 0) 
    {
        $_SESSION['message'] = "Vous êtes déjà amis.";
    } 
    else 
    {
        $sql_insert = "INSERT INTO friends (user_id1, user_id2, date_ajout) VALUES ('$user_id', '$session_user_id', NOW())";
        
        if ($db_connexion->query($sql_insert) === TRUE) 
        {
            $_SESSION['message'] = "Vous êtes désormais amis.";
        }
    }
    header("Location: page_profile_visiteur.php?user_id=$user_id");
    exit();
}
?>
