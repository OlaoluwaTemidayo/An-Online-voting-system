<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; 
            color: #006400; 
            margin: 20px;
            text-align: center;
        }

        h3 {
            color: #006400; 
            margin-bottom: 5px;
        }

        .candidate-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .candidate {
            border: 2px solid #006400; 
            border-radius: 10px;
            padding: 10px;
            margin: 10px;
            width: 300px;
            text-align: center;
            background-color: #fff; 
            box-shadow: 0 0 10px rgba(0, 100, 0, 0.3); 
        }

        img {
            border-radius: 50%;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        .vote-button {
            background-color: #006400; /* Dark green background color */
            color: #ffffff; /* White text color */
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .vote-button:hover {
            background-color: #004d00; 
        }

        #speakButton {
            background-color: #006400;
            color: #ffffff; 
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            margin-top: 20px;
        }

        #speakButton:hover {
            background-color: #004d00; 
        }
    </style>
<?php
include('connect.php');

// Check if the category parameter is set in the URL and matches the "Sport Director" category
if (isset($_GET['category']) && $_GET['category'] === 'Sport Director') {
    // Retrieve the list of candidates who applied for Sport Director from the candidates table
    $sql = "SELECT * FROM candidates WHERE category = 'Sport Director'";
    $result = mysqli_query($conn, $sql);

    // Check if any candidates are found
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='candidate-container'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $candidateId = $row["id"];
            $candidateName = $row["name"];
            $candidateOffice = $row["category"];
            $candidatePhoto = $row["photo"];
            $candidateBio = $row["bio"];

            // Display candidate information
            echo "<div class='candidate'>";
            echo "<img src='$candidatePhoto' alt='$candidateName' width='80' height='80'>";
            echo "<div>";
            echo "<h3>$candidateName</h3>";
            echo "<p>Office: $candidateOffice</p>";
            echo "<p>Bio: $candidateBio</p>";

            // Display a voting button
            echo "<form method='POST' action='vote.php'>";
            echo "<input type='hidden' name='candidateId' value='$candidateId'>";
            echo "<input type='hidden' name='category_id' value='10'>"; // Assuming category_id 10 corresponds to 'Sport Director'
            echo "<input type='hidden' name='category' value='$candidateOffice'>";
            echo "<input class='vote-button' type='submit' value='Vote' onclick='return confirmVote()'>";
            echo "</form>";

            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "No candidates found.";
    }
} else {
    echo "Invalid category.";
}

// Close the database connection
mysqli_close($conn);
?>

<button id="speakButton">Text to Speech</button>

<script>
    if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
        var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'en-US';

        recognition.onresult = function(event) {
            var transcript = event.results[0][0].transcript.trim().toLowerCase();
            var categoryLinks = document.getElementsByTagName('a');

            for (var i = 0; i < categoryLinks.length; i++) {
                var categoryName = categoryLinks[i].textContent.toLowerCase();

                if (transcript.includes(categoryName)) {
                    window.location.href = categoryLinks[i].getAttribute('href');
                    break;
                }
            }
        };

        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
        };

    } else {
        console.log('Speech recognition not supported in your browser.');
    }

    if ('speechSynthesis' in window) {
        var speakButton = document.getElementById('speakButton');
        var speechPhrase = new SpeechSynthesisUtterance('This is the tsport director dashboard page, please select your candidate');

        speakButton.addEventListener('click', function() {
            speechSynthesis.speak(speechPhrase);
        });
    } else {
        console.log('Speech synthesis not supported in your browser.');
    }
</script>