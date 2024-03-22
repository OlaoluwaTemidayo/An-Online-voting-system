<?php
include('connect.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $matric_number = $_POST["matric_number"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM voters WHERE matric_number = '$matric_number'"; 
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row["password"];
        if (password_verify($password, $storedPassword)) {
            

            // Store voter information in session variables
            $_SESSION["voterId"] = $row["id"];
            $_SESSION["voterName"] = $row["name"];
            

          
            header("Location: index.php");
            exit();
        } else {
           
            $error = "Invalid matric number or password. Please try again.";
        }
    } else {
        
        $error = "Invalid matric number or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; 
        }

        header {
            background-color: #4CAF50; /* Green background for header */
            color: white;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: white; /* White color for h2 */
        }

        img {
            max-width: 100px; /* Adjust the maximum width of your logo */
            height: auto;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green submit button */
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        p {
            color: red;
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
        <img src="photos/kasulogo.png" alt="Logo">
        <h2>Login</h2>
    </header>

    <form id="loginForm" method="POST" action="">
        <?php if(isset($error)) { ?>
        <p><?php echo $error; ?></p>
        <?php } ?>
        <label for="matric_number">Matric Number:</label>
        <input type="text" id="matric_number" name="matric_number" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    
    <button id="startSpeechRecognition">Speech To Text</button>
    <p id="speechOutput"></p>

    <script>
    if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
        var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'en-US';

        recognition.onresult = function(event) {
            var transcript = event.results[0][0].transcript;
            document.getElementById('speechOutput').textContent = 'You said: ' + transcript;

            // Check for specific commands
            if (transcript.toLowerCase().includes('login')) {
                activateLogin();
            } else if (transcript.toLowerCase().includes('matric number')) {
                fillMatricNumber(transcript);
            } else if (transcript.toLowerCase().includes('password')) {
                fillPassword(transcript);
            } else if (transcript.toLowerCase().includes('submit')) {
                // Trigger form submission when the user says "submit"
                document.getElementById('loginForm').submit();
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


        function activateLogin() {
            // Simulate a click on the login button
            document.getElementById('loginForm').submit();
        }

        function fillMatricNumber(speechInput) {
            // Extract the matric number from the speech input (you may need more sophisticated parsing)
            var matricNumber = speechInput.split('matric number')[1].trim();
            document.getElementById('matric_number').value = matricNumber;
        }

        function fillPassword(speechInput) {
            // Extract the password from the speech input (you may need more sophisticated parsing)
            var password = speechInput.split('password')[1].trim();
            document.getElementById('password').value = password;
        }
    } else {
        document.getElementById('speechOutput').textContent = 'Speech recognition not supported in this browser.';
    }
</script>
</body>
</html>