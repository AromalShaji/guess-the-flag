<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess the Flag</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-gradient: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            --card-bg: rgba(255, 255, 255, 0.7);
            --card-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --correct: #10b981;
            --incorrect: #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            padding: 1rem;
        }

        .container {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: var(--card-shadow);
            width: 100%;
            max-width: 600px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
            font-weight: 800;
        }

        p.subtitle {
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .screen {
            display: none;
            animation: fadeIn 0.4s ease-in-out forwards;
        }
        
        .screen.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
            width: 100%;
            max-width: 300px;
            margin: 0.5rem auto;
            display: block;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .input-group {
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .input-group label {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .input-group select {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            font-size: 1.1rem;
            outline: none;
            font-family: 'Outfit', sans-serif;
            background: white;
            cursor: pointer;
        }

        .history-section {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .history-list {
            list-style: none;
            margin-top: 1rem;
            max-height: 150px;
            overflow-y: auto;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Gameplay */
        .flag-container {
            width: 100%;
            max-width: 400px;
            height: 250px;
            margin: 0 auto 2rem auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            position: relative;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .flag-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            position: absolute;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .option-btn {
            background: white;
            border: 2px solid #e5e7eb;
            color: var(--text-main);
            padding: 1rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .option-btn:hover:not(:disabled) {
            border-color: var(--primary);
            background: #f8faff;
            transform: translateY(-2px);
        }

        .option-btn.correct {
            background: var(--correct);
            border-color: var(--correct);
            color: white;
        }

        .option-btn.incorrect {
            background: var(--incorrect);
            border-color: var(--incorrect);
            color: white;
        }

        .game-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .score-display {
            font-size: 4rem;
            color: var(--primary);
            font-weight: 800;
            margin: 2rem 0;
        }
        
        #feedback {
            font-size: 1.5rem;
            font-weight: 800;
            margin-top: 1.5rem;
            min-height: 2.2rem;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        #feedback.show {
            opacity: 1;
        }
        #feedback.success {
            color: var(--correct);
        }
        #feedback.error {
            color: var(--incorrect);
        }

        @media (max-width: 480px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
            .container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- START SCREEN -->
        <div id="start-screen" class="screen active">
            <h1>Guess the Flag 🌍</h1>
            <p class="subtitle">Test your geography knowledge!</p>
            
            <div class="input-group">
                <label for="difficulty">Mode:</label>
                <select id="difficulty">
                    <option value="easy" selected>Easy (Famous Flags)</option>
                    <option value="hard">Hard (70% Obscure)</option>
                </select>
            </div>

            <div class="input-group">
                <label for="rounds">Rounds:</label>
                <select id="rounds">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>

            <button class="btn" id="start-btn">Start Game</button>

            <div class="history-section">
                <h3>Previous Scores</h3>
                <ul class="history-list" id="history-list">
                    <!-- Populated by JS -->
                </ul>
            </div>
        </div>

        <!-- GAMEPLAY SCREEN -->
        <div id="game-screen" class="screen">
            <div class="game-header">
                <span id="round-counter">Round 1/10</span>
                <span id="score-counter">Score: 0</span>
            </div>

            <div class="flag-container">
                <div class="loader" id="flag-loader"></div>
                <img id="flag-image" class="flag-img" src="" alt="Guess this flag" style="display: none;">
            </div>

            <div class="options-grid" id="options-container">
                <!-- Buttons populated by JS -->
            </div>
            
            <div id="feedback"></div>
        </div>

        <!-- RESULT SCREEN -->
        <div id="result-screen" class="screen">
            <h1>Game Over! 🎉</h1>
            <p class="subtitle">Here is how you did:</p>
            
            <div class="score-display">
                <span id="final-score">0</span> / <span id="total-rounds">10</span>
            </div>

            <button class="btn" id="restart-btn">Play Again</button>
            <button class="btn" id="home-btn" style="background: white; color: var(--text-main); border: 2px solid #e5e7eb; box-shadow: none;">Back to Home</button>
        </div>
    </div>

    <script>
        let countriesData = {};
        let countryCodes = [];
        let gameCodes = [];
        let currentRound = 1;
        let maxRounds = 10;
        let score = 0;
        let currentCorrectCode = '';
        
        const famousCountries = [
            "us", "gb", "fr", "de", "it", "es", "in", "cn", "jp", "br", 
            "ca", "au", "ru", "za", "mx", "ar", "kr", "nl", "se", "ch", 
            "nz", "tr", "sa", "eg", "ng", "ke", "pk", "id", "th", "vn", 
            "my", "ph", "co", "pe", "cl", "ve", "gr", "pt", "pl", "ua", 
            "at", "be", "dk", "no", "fi", "ie", "il", "ae", "sg", "bd",
            "lk", "np", "dz", "ma", "iq", "ir", "sy", "kw", "qa", "bh",
            "om", "ye", "jo", "lb", "cu", "jm", "ht", "do", "pr", "cr"
        ];
        
        // DOM Elements
        const screens = {
            start: document.getElementById('start-screen'),
            game: document.getElementById('game-screen'),
            result: document.getElementById('result-screen')
        };
        
        const ui = {
            roundsSelect: document.getElementById('rounds'),
            startBtn: document.getElementById('start-btn'),
            restartBtn: document.getElementById('restart-btn'),
            homeBtn: document.getElementById('home-btn'),
            historyList: document.getElementById('history-list'),
            
            roundCounter: document.getElementById('round-counter'),
            scoreCounter: document.getElementById('score-counter'),
            flagImage: document.getElementById('flag-image'),
            flagLoader: document.getElementById('flag-loader'),
            optionsContainer: document.getElementById('options-container'),
            feedback: document.getElementById('feedback'),
            
            finalScore: document.getElementById('final-score'),
            totalRounds: document.getElementById('total-rounds')
        };

        // Initialize App
        async function init() {
            try {
                const response = await fetch('/countries.json');
                countriesData = await response.json();
                countryCodes = Object.keys(countriesData);
                loadHistory();
                
                ui.startBtn.addEventListener('click', startGame);
                ui.restartBtn.addEventListener('click', startGame);
                ui.homeBtn.addEventListener('click', showStartScreen);
            } catch (error) {
                console.error("Failed to load countries data", error);
                alert("Failed to load game data. Please refresh.");
            }
        }

        // Navigation
        function showScreen(screenName) {
            Object.values(screens).forEach(s => s.classList.remove('active'));
            screens[screenName].classList.add('active');
        }

        function showStartScreen() {
            loadHistory();
            showScreen('start');
        }

        // Game Logic
        function startGame() {
            maxRounds = parseInt(ui.roundsSelect.value);
            const mode = document.getElementById('difficulty').value;
            currentRound = 1;
            score = 0;
            
            let pool = [];
            const availableFamous = famousCountries.filter(c => countryCodes.includes(c));
            
            if (mode === 'easy') {
                const shuffled = [...availableFamous].sort(() => 0.5 - Math.random());
                pool = shuffled;
            } else {
                const availableNonFamous = countryCodes.filter(c => !famousCountries.includes(c));
                
                const shuffledFamous = [...availableFamous].sort(() => 0.5 - Math.random());
                const shuffledNonFamous = [...availableNonFamous].sort(() => 0.5 - Math.random());
                
                const famousCount = Math.round(maxRounds * 0.3); // 30% famous
                const nonFamousCount = maxRounds - famousCount;  // 70% non-famous
                
                pool = [
                    ...shuffledFamous.slice(0, famousCount),
                    ...shuffledNonFamous.slice(0, nonFamousCount)
                ].sort(() => 0.5 - Math.random());
            }
            
            gameCodes = pool.slice(0, maxRounds);
            
            showScreen('game');
            nextRound();
        }

        function nextRound() {
            if (currentRound > maxRounds) {
                endGame();
                return;
            }
            
            ui.roundCounter.textContent = `Round ${currentRound}/${maxRounds}`;
            ui.scoreCounter.textContent = `Score: ${score}`;
            ui.feedback.classList.remove('show');
            
            generateQuestion();
        }

        function generateQuestion() {
            // Get the predetermined correct flag for this round
            currentCorrectCode = gameCodes[currentRound - 1];
            
            // Pick 3 incorrect options from the remaining countries
            const otherCodes = countryCodes.filter(c => c !== currentCorrectCode);
            const shuffledOthers = [...otherCodes].sort(() => 0.5 - Math.random());
            const incorrectCodes = shuffledOthers.slice(0, 3);
            
            const options = [currentCorrectCode, ...incorrectCodes].sort(() => 0.5 - Math.random());
            
            loadFlagImage(currentCorrectCode);
            renderOptions(options);
        }

        function loadFlagImage(code) {
            ui.flagImage.style.display = 'none';
            ui.flagLoader.style.display = 'block';
            
            const imgUrl = `https://flagcdn.com/w320/${code}.png`;
            
            ui.flagImage.onload = () => {
                ui.flagLoader.style.display = 'none';
                ui.flagImage.style.display = 'block';
            };
            
            ui.flagImage.onerror = () => {
                // Retry or load another if fails
                console.error('Failed to load flag');
                generateQuestion(); // Simple fallback: just skip and generate a new one
            };
            
            ui.flagImage.src = imgUrl;
        }

        function renderOptions(options) {
            ui.optionsContainer.innerHTML = '';
            
            options.forEach(code => {
                const btn = document.createElement('button');
                btn.className = 'option-btn';
                btn.textContent = countriesData[code];
                btn.onclick = () => handleGuess(btn, code);
                ui.optionsContainer.appendChild(btn);
            });
        }

        function handleGuess(clickedBtn, guessedCode) {
            // Disable all buttons
            const buttons = ui.optionsContainer.querySelectorAll('.option-btn');
            buttons.forEach(btn => btn.disabled = true);
            
            const isCorrect = guessedCode === currentCorrectCode;
            
            if (isCorrect) {
                clickedBtn.classList.add('correct');
                score++;
                ui.feedback.textContent = "Correct! ✅";
                ui.feedback.className = "success show";
            } else {
                clickedBtn.classList.add('incorrect');
                ui.feedback.textContent = `Incorrect ❌ It was ${countriesData[currentCorrectCode]}`;
                ui.feedback.className = "error show";
                
                // Highlight correct
                buttons.forEach(btn => {
                    if (btn.textContent === countriesData[currentCorrectCode]) {
                        btn.classList.add('correct');
                    }
                });
            }
            
            ui.scoreCounter.textContent = `Score: ${score}`;
            
            setTimeout(() => {
                currentRound++;
                nextRound();
            }, 1500);
        }

        function endGame() {
            showScreen('result');
            ui.finalScore.textContent = score;
            ui.totalRounds.textContent = maxRounds;
            saveScore();
        }

        // Local Storage History
        function saveScore() {
            const history = JSON.parse(localStorage.getItem('flagGameHistory')) || [];
            const date = new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            history.unshift({
                date: date,
                score: score,
                total: maxRounds
            });
            
            // Keep only last 10
            if (history.length > 10) history.pop();
            
            localStorage.setItem('flagGameHistory', JSON.stringify(history));
        }

        function loadHistory() {
            const history = JSON.parse(localStorage.getItem('flagGameHistory')) || [];
            ui.historyList.innerHTML = '';
            
            if (history.length === 0) {
                ui.historyList.innerHTML = '<li class="history-item" style="justify-content: center; color: var(--text-muted);">No games played yet.</li>';
                return;
            }
            
            history.forEach(item => {
                const li = document.createElement('li');
                li.className = 'history-item';
                
                const percentage = Math.round((item.score / item.total) * 100);
                
                li.innerHTML = `
                    <span>${item.date}</span>
                    <span style="color: ${percentage >= 50 ? 'var(--correct)' : 'var(--text-main)'}">${item.score}/${item.total} (${percentage}%)</span>
                `;
                ui.historyList.appendChild(li);
            });
        }

        // Run
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>
