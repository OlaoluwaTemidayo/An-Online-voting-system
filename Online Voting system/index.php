<?php
// Define and assign values to totalVoters and totalCandidates variables
$totalVoters = 100; 
$totalCandidates = 10; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to this Voting System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 20px;
        }

        main {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 20px;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #ecf0f1;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 70%;
            background-image: url("photos/pexels-cottonbro-studio-4669141.jpg"); /* Adjust the image path */
            background-size: cover;
            background-position: center;
            height: 500px;
        }

        h1, p {
            color: #fff;
        }

        .sidebar {
            background-color: #3498db;
            padding: 20px;
            width: 20%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 15px;
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: #2980b9;
            color: #fff;
        }

        .stats-box {
            background-color: #34495e;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Add some space between stat boxes */
        }
        #startSpeechRecognition {
    background-color: #006400; /* Dark green background color */
    color: #ffffff; /* White text color */
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 18px;
    margin-top: 20px;

    /* Center the button */
    display: block;
    margin-left: auto;
    margin-right: auto;
}

#startSpeechRecognition:hover {
    background-color: #004d00; /* Darker green on hover */
}
#loginInstructionsButton {
    background-color: #006400; /* Dark green background color */
    color: #ffffff; /* White text color */
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 18px;
    margin-top: 20px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

#loginInstructionsButton:hover {
    background-color: #004d00; /* Darker green on hover */
}
    </style>
</head>

<body>

    <header>
        <h1>Welcome!</h1>
        <p>Thank you for using this online voting system.</p>
    </header>

    <main>
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="category.php">Categories</a></li>
                <li><a href="voting-instructions.php">Voting Instructions</a></li>
                <li><a href="faqs.php">FAQs</a></li>
                <!-- Add more sidebar links here if needed -->

                <!-- Move the stat boxes here -->
                <div class="stats-box">
                    <p>Total Voters: <?php echo $totalVoters; ?></p>
                </div>

                <div class="stats-box">
                    <p>Total Candidates: <?php echo $totalCandidates; ?></p>
                </div>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content">
            <!-- Your main content goes here -->
        </div>
    </main>
    <button id="startSpeechRecognition">Speech To Text</button>
<p id="speechOutput"></p>

<script>
if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
    var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'en-US';

    recognition.onresult = function(event) {
        var transcript = event.results[0][0].transcript;
        document.getElementById('speechOutput').textContent = 'You said: ' + transcript;

        // Check if the speech input matches any of the navbar link commands
        for (var i = 0; i < navbarLinks.length; i++) {
            var link = navbarLinks[i];
            if (transcript.toLowerCase().includes(link.command)) {
                window.location.href = link.url;
                break; // Exit the loop after stimulating the link
            }
        }
    };

    recognition.onerror = function(event) {
        console.error('Speech recognition error:', event.error);
    };

    document.getElementById('startSpeechRecognition').addEventListener('click', function() {
        recognition.start();
        document.getElementById('speechOutput').textContent = 'Listening...';
    });

    // Create the new button for login page instructions
    var loginInstructionsButton = document.createElement('button');
    loginInstructionsButton.textContent = 'Login Instructions';
    loginInstructionsButton.id = 'loginInstructionsButton'; // Add an id to the button
    loginInstructionsButton.addEventListener('click', function() {
        var message = 'This is the login page, please provide your Matric number and password';
        var speechSynthesis = window.speechSynthesis || window.webkitSpeechSynthesis;
        var utterance = new SpeechSynthesisUtterance(message);
        speechSynthesis.speak(utterance);
    });

    // Append the new button to the page
    document.body.appendChild(loginInstructionsButton);

    // Array to store the navbar link commands and their corresponding URLs
    var navbarLinks = [
        { command: 'home', url: 'https://example.com/home' },
        { command: 'about', url: 'https://example.com/about' },
        { command: 'contact', url: 'https://example.com/contact' },
        // Add more commands and URLs as needed
    ];
} else {
    document.getElementById('speechOutput').textContent = 'Speech recognition not supported in this browser.';
}
</script>
</body>

</html>
