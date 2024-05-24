<?php
    session_start();
    if (isset($_SESSION['erreur'])) 
    {
        echo "<p style='color: red;'>".$_SESSION['erreur']."</p>";
        unset($_SESSION['erreur']);
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">

    <meta charset="UTF-8">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion</title>
    <link rel="shortcut icon" type="x-icon" href="MEMOf.png">
    <style>
        body 
        {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5; 
            margin: 0;
            padding: 0;
        }

        .container 
        {
            right: -300px;
            top: 100px; 
            width: 300px;
            margin: 0 auto;
            padding-top: 50px;
            background-color: #fff; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            padding: 20px; 
            position: relative; 
        }

        .memo-text
        {
            position: absolute;
            top: 30%;
            font-family: 'Pacifico', cursive; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); 
            left: -700px; 
            transform: translateY(-50%);
            font-size: 50px; 
            color: #42b72a; 
            writing-mode: horizontal; 
            text-orientation: mixed; 
            text-align: center;
            
        }

        .slogan
        {
            position: absolute;
            top: 45%;
            left: -700px; 
            transform: translateY(-50%);
            font-size: 18px; 
            text-orientation: mixed;
            color: #000000; 
            
        }

        input[type="text"], input[type="password"] 
        {
            
            width: calc(100% - 10px); 
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 4px; 
        }

        input[type="submit"] 
        {
           
            background-color: #42b72a; 
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: calc(100% - 10px); 
            border-radius: 4px; 
        }

        input[type="submit"]:hover 
        {
            background-color: #36a420; 
        }

        a 
        {
            color: #385898; 
            text-decoration: none; 
        }
        a:hover 
        {
            text-decoration: underline; 
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="memo-text">MEMO</div> 
        <div class="slogan"> 
        MEMORIES, où les souvenirs fleurissent et les liens se tissent!
        </div>
        <h2> 
            Connexion à MEMO
        </h2>
        <form action="connexion.php" method="post">
            <label for="email">
                Email:
            </label>
            <input type="text" id="email" name="email" required>
            <label for="password">
                Mot de passe:
            </label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Se connecter" style="font-size: 16px;">
        </form>
        <p>
            Pas encore de compte? Rejoinez nous vite!
            <a href="page_inscription.php">
                S'inscrire
            </a>
        </p>
    </div>
</body>
</html>
