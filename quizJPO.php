<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);


if(isset($_POST['logout'])){
    try{
        session_destroy();
        session_unset();
        header('location: index.php');
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}


// Décode les données JSON envoyées
if (isset($_POST['score'])){
    $score = $_POST['score'];
    $pseudo = $_SESSION['pseudoPlayer'];
    echo 'le score envoyer est : '. htmlspecialchars($score);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Interactif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .question-container {
            padding: 20px;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #e7f5e7;
        }
        .question {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .options {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .options li {
            margin: 0;
        }
        .option-btn {
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
        .option-btn:hover {
            background-color: #45a049;
        }
        .option-btn:active {
            background-color: #3e8e41;
        }
        .selected {
            background-color: #45a049 !important; /* Met en surbrillance l'option sélectionnée */
        }
        .timer {
            text-align: center;
            font-size: 1.2em;
            margin-top: 10px;
        }
        .result {
            text-align: center;
            font-size: 1.5em;
        }
    </style>
</head>
<body>

<div class="container">
    <label for="">Nom Players: <?php echo htmlspecialchars($_SESSION['pseudoPlayer']); ?></label>
    <h1>Quiz Interactif</h1><br>
    
    <div id="quiz">
        <div id="question-container" class="question-container">
            <div class="question" id="question">Question ici</div>
            <ul class="options" id="options">
                <!-- Les options seront injectées ici -->
            </ul>
        </div>
        <div id="timer" class="timer"></div>
    </div>
    <div id="result-container" class="result" style="display: none;">
        <p id="result"></p>
    </div> 

    <form method="post">
        <button name="logout">logout</button>
    </form>
</div>

<script src="quizjpo.js"></script>

</body>
</html>
