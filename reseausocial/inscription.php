<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        include 'connexion_bdd.php';
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = password_hash($_POST['password'], PASSWORD_DEFAULT); 
        $image_generique = "photo_profile_generique.jpg";
        $sql = "INSERT INTO Users (nom, prenom, email, mot_de_passe, photo_de_profil) VALUES ('$nom', '$prenom', '$email', '$mot_de_passe', '$image_generique')";
        
        if ($db_connexion->query($sql) === TRUE) 
        {
            header("Location: page_connexion.php");
            exit();
        } 
        else 
        {
            echo "Erreur: " . $sql . "<br>" . $db_connexion->error;
        }
        $db_connexion->close();
    }
?>
