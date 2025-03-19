<?php 
    session_start(); 
    
    try { 
        $db = new PDO("mysql:host=localhost;dbname=jpo", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        if (isset($_POST['ok'])) { 
            if (isset($_POST["pnom"]) && !empty(trim($_POST["pnom"]))) {
                $pseudo = trim($_POST["pnom"]);
                $req = $db->prepare('INSERT INTO players(pseudo) VALUES(?)');
                $req->bindValue(1, $pseudo, PDO::PARAM_STR);
                $req->execute();
                
                $_SESSION['pseudoPlayer'] = $pseudo; 
                $msg1 = "Enregistrement d'un nouveau joueur";  
            } else {
                $msg2 = "Veuillez remplir tous les champs";
            }
        }

    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZZ JPO</title>
    <style>
        body {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          height: 100vh;
          margin: 0;
          padding: 0;
        }
        input[type='text']{
            border:none;
            outline:none;
            border:1px solid #4CAF50 !important;
            /* margin: 50px auto; */
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="submit"]{
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s;
        }
        label{
            font-size: 1.2em;
            margin-bottom: 20px;
            font-family:sans-serif;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['pseudoPlayer'])): ?> 
        <?php require 'quizJPO.php'; ?>
    <?php else: ?>
    <form method="POST">
        <label for="">Renseigner votre pseudonyme pour jouer</label><br>
        <input type="text" placeholder="Votre pseudo ici" name="pnom">
        <input type="submit" value="Valider" name="ok"><br>
        
        <?php if (isset($msg1)) echo "<p style='color:green;'>$msg1</p>"; ?>
        <?php if (isset($msg2)) echo "<p style='color:red;'>$msg2</p>"; ?>
    </form>
    <?php endif; ?>
</body>
</html>
