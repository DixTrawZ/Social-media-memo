<?php include 'header.php'; ?>
<?php include 'connexion_bdd.php'; ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Changement de photo de profil</title>
            <style>
                body 
                {
                    background-color: white; 
                    font-family: 'Poppins', sans-serif;
                }

                .container {
    background-color: #ffffff;
    width: 50%;
    margin: 50px auto; 
    padding: 20px;
    text-align: center;
    box-shadow: 0 0px 10px rgba(0, 0, 0, 1); 
    border-radius: 10px; 
}


                h2 
                {
                    margin-bottom: 20px; 
                }

                input[type="file"] 
                {
                    display: none; 
                }

                label {
    background-color: #007bff;
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block; 
    transition: background-color 0.3s; 
}


label:hover {
    background-color: #0056b3; 
}

input[type="submit"] {
    background-color: #28a745;
    color: #ffffff;
    padding: 12px 24px; 
    border: none;
    border-radius: 8px; 
    cursor: pointer;
    margin-top: 20px;
    font-size: 16px; /
    font-weight: bold; 
    transition: background-color 0.3s; }


input[type="submit"]:hover {
    background-color: #218838; 
}


            </style>
    </head>
    <body>
        <div class="container">
            <h2>
                Changer de photo de profil
            </h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="upload-photo">
    <img src="./image.png" alt="Icône de photo" style="vertical-align: middle; margin-right: 5px;">
    Choisir une photo


                    
                </label>
                <input type="file" name="photo" id="upload-photo" accept="image/*">
                <br>
                <input type="submit" name="submit" value="Confirmer">
            </form>

            <?php
                if (isset($_POST['submit'])) 
                {
                    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) 
                    {
                        $nomFichier = $_FILES['photo']['name'];
                        $cheminFichier = $nomFichier;
                        move_uploaded_file($_FILES['photo']['tmp_name'], $cheminFichier);
                        $user_id = $_SESSION['user_id'];
                        $sql = "UPDATE Users SET photo_de_profil='$cheminFichier' WHERE user_id='$user_id'";

                        if ($db_connexion->query($sql) === TRUE) 
                        {
                            echo "Photo de profil mise à jour avec succès.";
                        } 
                        else 
                        {
                            echo "Erreur lors de la mise à jour de la photo de profil : " . $db_connexion->error;
                        }
                        $db_connexion->close();
                    } 
                    else 
                    {
                        echo "Erreur lors du téléchargement de la photo.";
                    }
                }
            ?>
        </div>
    </body>
</html>
