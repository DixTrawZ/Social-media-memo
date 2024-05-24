<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}
if (!isset($_SESSION['user_id'])) 
{
    header("Location: page_connexion.php");
    exit();
}

include 'connexion_bdd.php';
$user_id = $_SESSION['user_id'];

if (isset($_POST['contenu'])) 
{
    $contenu = $_POST['contenu'];
} 

if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) 
{
    $nomFichier = uniqid() . '_' . $_FILES['image']['name'];
    $cheminImage = $nomFichier;
    move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage);
} 
else 
{
    $cheminImage = NULL;
}

$sql = "INSERT INTO posts (user_id, contenu_text, contenu_photo) VALUES ('$user_id', '$contenu', '$cheminImage')";

if ($db_connexion->query($sql) === TRUE) 
{
    header("Location: page_profile.php");
    exit();
} 
else 
{
    echo "Erreur: " . $sql . "<br>" . $db_connexion->error;
}

$db_connexion->close();
?>
