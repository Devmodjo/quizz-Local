// Définition des questions du quiz
const questions = [
    {
        question: "Quelle est la capitale de la France ?",
        options: ["Paris", "Londres", "Rome", "Madrid"],
        correctAnswer: "Paris"
    },
    {
        question: "Combien de continents y a-t-il ?",
        options: ["5", "6", "7", "8"],
        correctAnswer: "7"
    },
    {
        question: "Qui a écrit 'Les Misérables' ?",
        options: ["Victor Hugo", "Émile Zola", "Marcel Proust", "Molière"],
        correctAnswer: "Victor Hugo"
    },
    {
        question: "Quelle est la couleur du cheval blanc d'Henri IV ?",
        options: ["Blanc", "Noir", "Rouge", "Vert"],
        correctAnswer: "Blanc"
    },
    {
        question: "Quelle est la capitale de l'Espagne ?",
        options: ["Paris", "Londres", "Rome", "Madrid"],
        correctAnswer: "Madrid"
    },
    {
        question: "Quelle est la capitale de l'Italie ?",
        options: ["Paris", "Londres", "Rome", "Madrid"],
        correctAnswer: "Rome"
    },
    {
        question: "Quelle est la capitale du Royaume-Uni ?",
        options: ["Paris", "Londres", "Rome", "Madrid"],
        correctAnswer: "Londres"
    },
    {
        question: "Quelle est la capitale de l'Allemagne ?",
        options: ["Paris", "Londres", "Berlin", "Madrid"],
        correctAnswer: "Berlin"
    },
    {
        question: "Quelle est la capitale de la Belgique ?",
        options: ["Paris", "Bruxelles", "Rome", "Madrid"],
        correctAnswer: "Bruxelles"
    },
    {
        question: "Quelle est la capitale du Portugal ?",
        options: ["Paris", "Lisbonne", "Rome", "Madrid"],
        correctAnswer: "Lisbonne"
    }
];

let currentQuestionIndex = 0;
let score = 0;
let timer; 
let timeLeft = 10; 
let questionAnswered = false;

// Fonction pour afficher la question actuelle
function showQuestion() {
    const questionData = questions[currentQuestionIndex];
    document.getElementById('question').innerText = questionData.question;
    const optionsList = document.getElementById('options');
    optionsList.innerHTML = ''; 

    questionData.options.forEach(option => {
        const li = document.createElement('li');
        li.innerHTML = `<button class="option-btn" onclick="selectOption('${option}', this)">${option}</button>`;
        optionsList.appendChild(li);
    });

    timeLeft = 10;
    document.getElementById('timer').innerText = `Temps restant: ${timeLeft} secondes`;

    startTimer();
    questionAnswered = false;
}

// Fonction pour démarrer le timer
function startTimer() {
    clearInterval(timer); // Évite d'avoir plusieurs timers actifs
    timer = setInterval(function () {
        timeLeft--;
        document.getElementById('timer').innerText = `Temps restant: ${timeLeft} secondes`;

        if (timeLeft <= 0) {
            clearInterval(timer);
            nextQuestion();
        }
    }, 1000);
}

// Fonction pour gérer la sélection d'une option
function selectOption(option, button) {
    if (!questionAnswered) {
        clearInterval(timer); // Arrêter le timer dès qu'une réponse est donnée
        questionAnswered = true;
        button.classList.add("selected");

        const correctAnswer = questions[currentQuestionIndex].correctAnswer;
        if (option === correctAnswer) {
            score++;
        }

        setTimeout(nextQuestion, 1000); 
    }
}

// Fonction pour passer à la question suivante
function nextQuestion() {
    currentQuestionIndex++;

    if (currentQuestionIndex < questions.length) {
        showQuestion();
    } else {
        showResult();
    }
}

// Fonction pour afficher les résultats
function showResult() {
    document.getElementById('quiz').style.display = 'none';
    const resultContainer = document.getElementById('result-container');
    resultContainer.style.display = 'block';
    document.getElementById('result').innerText = `Vous avez obtenu ${score} sur ${questions.length} bonnes réponses.`;

    console.log("Score à envoyer:", score);

    // Envoi du score au serveur via fetch
    if(score){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'quizJPO.php', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log("score envoyer avec succes : ", xhr.responseText);
            }
        }
        // envoyer le score
        xhr.send("score=" + encodeURIComponent(score));
    } else {
        console.error("Erreur lors de l'envoi du score:");
    }
    // fetch('quizJPO.php', {
    //     method: "POST",
    //     headers: {
    //         "Content-Type": "application/json"
    //     },
    //     body: JSON.stringify({ 'score': score })
    // })
    // .then(response => response.json())
    // .then(data => {
    //     console.log(data.message);
    // })
    // .catch(error => {
    //     console.error("Erreur lors de l'envoi du score:", error);
    // });
}
// Initialisation du quiz
showQuestion();
