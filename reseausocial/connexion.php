<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    include 'connexion_bdd.php';
    $email = $_POST['email'];
    $mot_de_passe = $_POST['password'];
    $sql = "SELECT user_id, mot_de_passe FROM Users WHERE email='$email'";
    $result = $db_connexion->query($sql);
    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        $hashed_password = $row['mot_de_passe'];

        if (password_verify($mot_de_passe, $hashed_password)) 
        {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: page_principale.php");
            exit();
        } 
        else 
        {
            $_SESSION['erreur'] = "Mot de passe incorrect.";
        }
    } 
    else 
    {
        $_SESSION['erreur'] = "Aucun utilisateur trouvé avec cet email.";
    }

    $db_connexion->close();
}

header("Location: page_connexion.php");
exit();
?>
