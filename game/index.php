<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cybersecurity Brain Test – Extended</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #0f0f0f;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }
    .container {
        background: #1c1c1c;
        padding: 20px 40px;
        border-radius: 10px;
        box-shadow: 0 0 20px #00ffcc;
        max-width: 600px;
        width: 100%;
        text-align: center;
    }
    h2 {
        margin-bottom: 20px;
    }
    button.option-btn {
        display: block;
        width: 100%;
        margin: 10px 0;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background: #00ffcc;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    button.option-btn.correct { background: #4caf50; color: #fff; }
    button.option-btn.wrong { background: #f44336; color: #fff; }
    #nextBtn {
        margin-top: 15px;
        padding: 10px 20px;
        border-radius: 5px;
        background: #2196f3;
        color: #fff;
        border: none;
        cursor: pointer;
        display: none;
    }
    #timer {
        font-size: 18px;
        margin-bottom: 10px;
        color: #00ffcc;
    }
    #score {
        margin-top: 10px;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="container">
    <h2 id="question">Loading question...</h2>
    <div id="timer">Time left: 60s</div>
    <div id="options"></div>
    <button id="nextBtn">Next Question</button>
    <p id="progress"></p>
    <p id="score"></p>
</div>

<script>
const questions = [
    { question: "What is phishing?", options: ["A type of virus", "Tricking someone to reveal info", "Firewall", "Strong password"], answer: 1 },
    { question: "Strongest password?", options: ["123456", "password", "G!7k@9Zq", "abcdef"], answer: 2 },
    { question: "HTTPS means?", options: ["Slow website", "Insecure", "Secure", "Offline"], answer: 2 },
    { question: "2FA stands for?", options: ["Two passwords", "Extra security layer", "Unnecessary", "Antivirus software"], answer: 1 },
    { question: "What is ransomware?", options: ["Virus encrypting files", "Firewall", "Antivirus", "Phishing tool"], answer: 0 },
    { question: "Public Wi-Fi risk?", options: ["Safe", "Can be hacked", "Always encrypted", "No risk"], answer: 1 },
    { question: "SQL Injection is?", options: ["Network attack", "Database attack", "Malware type", "Phishing"], answer: 1 },
    { question: "Malware stands for?", options: ["Malicious Software", "Machine Learning", "Email", "Firewall"], answer: 0 },
    { question: "VPN purpose?", options: ["Hide IP", "Delete files", "Install virus", "Open ports"], answer: 0 },
    { question: "Social engineering is?", options: ["Hacking techniques", "Tricking people", "Malware", "Firewall"], answer: 1 },
    { question: "XSS stands for?", options: ["Cross-Site Scripting", "XML Server Security", "Extra Security System", "None"], answer: 0 },
    { question: "Zero-day exploit?", options: ["Known bug", "Unknown vulnerability", "Firewall tool", "Antivirus"], answer: 1 },
    { question: "Two-step verification?", options: ["2FA", "Two passwords", "VPN", "Phishing"], answer: 0 },
    { question: "Brute force attack?", options: ["Guessing passwords", "SQL injection", "Malware", "Phishing"], answer: 0 },
    { question: "Firewall purpose?", options: ["Block unwanted traffic", "Scan viruses", "Encrypt data", "Spy"], answer: 0 },
    { question: "DDoS attack?", options: ["Delete files", "Network flood", "Install malware", "Encrypt data"], answer: 1 },
    { question: "Trojan horse?", options: ["Virus hidden in software", "Firewall", "VPN", "Patch"], answer: 0 },
    { question: "Rootkit?", options: ["Hidden malware", "Firewall", "2FA tool", "VPN"], answer: 0 },
    { question: "Keylogger?", options: ["Record keystrokes", "Encrypt files", "Firewall", "Scan malware"], answer: 0 },
    { question: "HTTPS padlock indicates?", options: ["Encrypted connection", "Website slow", "Unsecure", "Virus present"], answer: 0 },
    { question: "Phishing email usually has?", options: ["Links to fake sites", "Strong passwords", "VPN link", "Firewall"], answer: 0 },
    { question: "Social media risk?", options: ["Malware sharing", "Privacy breach", "Secure info", "No risk"], answer: 1 },
    { question: "Strong encryption?", options: ["AES-256", "1234", "password", "MD5"], answer: 0 },
    { question: "Public key encryption uses?", options: ["Two keys", "One key", "No key", "Virus"], answer: 0 },
    { question: "Cybersecurity is?", options: ["Protecting systems", "Creating malware", "Hacking", "Virus scanning only"], answer: 0 },
    { question: "Pharming attack?", options: ["Redirect users to fake site", "Delete files", "Encrypt files", "Scan malware"], answer: 0 },
    { question: "Man-in-the-middle attack?", options: ["Intercept communication", "Install virus", "Scan network", "Firewall"], answer: 0 },
    { question: "Session hijacking?", options: ["Take over user session", "Malware attack", "Firewall bypass", "Encryption"], answer: 0 },
    { question: "Password manager purpose?", options: ["Store passwords securely", "Hack passwords", "VPN tool", "Firewall"], answer: 0 },
    { question: "Brute force defense?", options: ["Strong passwords", "Weak passwords", "No password", "Default passwords"], answer: 0 }
];

let current = 0;
let score = 0;
let timeLeft = 60;
let timerInterval;

const questionEl = document.getElementById("question");
const optionsEl = document.getElementById("options");
const nextBtn = document.getElementById("nextBtn");
const progressEl = document.getElementById("progress");
const scoreEl = document.getElementById("score");
const timerEl = document.getElementById("timer");

// Shuffle questions
questions.sort(() => Math.random() - 0.5);

function startTimer() {
    timeLeft = 60;
    timerEl.textContent = `Time left: ${timeLeft}s`;
    timerInterval = setInterval(() => {
        timeLeft--;
        timerEl.textContent = `Time left: ${timeLeft}s`;
        if(timeLeft <= 0) {
            clearInterval(timerInterval);
            disableOptions();
            nextBtn.style.display = "inline-block";
        }
    }, 1000);
}

function showQuestion() {
    nextBtn.style.display = "none";
    const q = questions[current];
    questionEl.textContent = q.question;
    optionsEl.innerHTML = "";
    q.options.forEach((opt, index) => {
        const btn = document.createElement("button");
        btn.textContent = opt;
        btn.classList.add("option-btn");
        btn.onclick = () => checkAnswer(index, btn);
        optionsEl.appendChild(btn);
    });
    progressEl.textContent = `Question ${current + 1} / ${questions.length}`;
    scoreEl.textContent = `Score: ${score}`;
    startTimer();
}

function checkAnswer(selected, btn) {
    clearInterval(timerInterval);
    const q = questions[current];
    disableOptions();
    if(selected === q.answer) {
        score++;
        btn.classList.add("correct");
    } else {
        btn.classList.add("wrong");
        // highlight correct
        optionsEl.children[q.answer].classList.add("correct");
    }
    scoreEl.textContent = `Score: ${score}`;
    nextBtn.style.display = "inline-block";
}

function disableOptions() {
    Array.from(optionsEl.children).forEach(btn => btn.disabled = true);
}

nextBtn.onclick = () => {
    current++;
    if(current < questions.length) {
        showQuestion();
    } else {
        questionEl.textContent = "Quiz Finished!";
        optionsEl.innerHTML = "";
        progressEl.textContent = "";
        timerEl.textContent = "";
        scoreEl.textContent = `Final Score: ${score} / ${questions.length}`;
        nextBtn.style.display = "none";
    }
}

showQuestion();
</script>
</body>
</html>
