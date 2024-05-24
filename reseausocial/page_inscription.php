<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscription</title>
<link rel="shortcut icon" type="x-icon" href="MEMOf.png">
    
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f2f5; 
        margin: 0;
        padding: 0;
    }

    .container {
        width: 300px;
        margin: 50px auto 0; 
        padding-top: 50px;
        background-color: #fff; 
        border-radius: 8px; 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        padding: 20px; 
    }

    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0 20px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        border-radius: 4px; 
    }

    input[type="checkbox"] {
        margin-bottom: 20px; 
    }

    input[type="submit"] {
        background-color: #42b72a; 
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        border-radius: 4px; 
    }

    input[type="submit"]:hover {
        background-color: #36a420; 
    }

    a {
        color: #385898; 
        text-decoration: none; 
    }

    a:hover {
        text-decoration: underline; 
        cursor: pointer;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Inscription à <span style="font-family: 'Pacifico', cursive; color: #42b72a;">MEMO</span></h2>
    <form action="inscription.php" method="post" id="inscriptionForm">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <!-- Case à cocher pour les conditions d'utilisation -->
        <input type="checkbox" id="conditions" name="conditions" required>
        <label for="conditions">J'ai lu et j'accepte les <a href="#" id="conditionsLink">conditions d'utilisation</a></label>
        <input type="submit" value="S'inscrire" style="font-size: 16px;" id="submitButton" disabled>
    </form>
    <p>Déjà un compte? <a href="page_connexion.php">Se connecter</a></p>
</div>

<script>
    document.getElementById("conditions").addEventListener("change", function() {
        document.getElementById("submitButton").disabled = !this.checked;
    });

    document.getElementById("conditionsLink").addEventListener("click", function(event) {
        event.preventDefault();
        alert("Conditions d'utilisation de MEMORIES (MEMO)\n1. En utilisant MEMORIES, vous acceptez nos conditions d'utilisation.\n2. Respectez les lois en vigueur lors de l'utilisation de notre plateforme.\n3. Le contenu publié reste la propriété de son auteur.\n4. Votre vie privée est importante, consultez notre politique de confidentialité.\n5. Les publications et commentaires ne peuvent pas être supprimés.\n6. Une fois ajouté, un ami ne peut pas être supprimé.\n7. Les comptes ne peuvent pas être supprimés.\n8. MEMORIES se réserve le droit de modifier les conditions. \nEn utilisant MEMORIES, vous adhérez à ces conditions. Profitez de vos souvenirs partagés avec nous !");
    });
</script>

</body>
</html>
