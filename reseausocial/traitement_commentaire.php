<?php
    session_start();
    include 'connexion_bdd.php';

    if (isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['contenu_commentaire'])) 
    {
        $post_id = intval($_POST['post_id']);
        $user_id = intval($_POST['user_id']);
        $contenu_commentaire = trim($_POST['contenu_commentaire']);

        if (!empty($contenu_commentaire)) 
        {
            $sql_insert_comment = "INSERT INTO commentaires (post_id, user_id, contenu, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $db_connexion->prepare($sql_insert_comment);
            if ($stmt) 
            {
                $stmt->bind_param('iis', $post_id, $user_id, $contenu_commentaire);
                if ($stmt->execute()) 
                {
                    header('Location: page_commentaire.php?post_id=' . $post_id);
                    exit; 
                } 
                else 
                {
                    echo "Erreur lors de l'ajout du commentaire.";
                }
                $stmt->close();
            }
            else 
            {
                echo "Erreur lors de la préparation de la requête.";
            }
        } 
        else 
        {
            echo "Le contenu du commentaire ne peut pas être vide.";
        }
    } 
    else 
    {
        echo "Données insuffisantes pour ajouter un commentaire.";
    }
    $db_connexion->close();
?>
