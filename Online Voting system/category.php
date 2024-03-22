<?php
include('connect.php');

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>
    <h1>Available Categories</h1>
    <style>
         body { font-family: Arial, sans-serif; background-color: #f0f8ff; color: #006400; margin: 20px; }
    h1 { color: #006400; }
    p { margin-bottom: 10px; }
    a { color: #006400; text-decoration: none; font-weight: bold; }
    a:hover { text-decoration: underline; }
    #speakButton { background-color: #006400; color: #ffffff; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; font-size: 18px; margin-top: 20px; }
    #speakButton:hover { background-color: #004d00; }
    #voiceSelectionButton { background-color: #006400; color: #ffffff; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; font-size: 18px; margin-top: 20px; }
    #voiceSelectionButton:hover { background-color: #004d00; }
    </style>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categoryId = $row["id"];
            $categoryName = $row["name"];

            $dashboardLink = '';

            if ($categoryName === 'President') {
                $dashboardLink = "dashboard_president.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Vice President I') {
                $dashboardLink = "dashboard_vice_president_I.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Vice President II') {
                $dashboardLink = "dashboard_vice_president_ii.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Secretary General') {
                $dashboardLink = "dashboard_secretary_general.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Assistant Secretary General') {
                $dashboardLink = "dashboard_assistant_secretary_general.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Financial Secretary') {
                $dashboardLink = "dashboard_financial_secretary.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Treasurer') {
                $dashboardLink = "dashboard_treasurer.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Auditor General') {
                $dashboardLink = "dashboard_auditor_general.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Welfare Director') {
                $dashboardLink = "dashboard_welfare_director.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Sport Director') {
                $dashboardLink = "dashboard_sport_director.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Social Director') {
                $dashboardLink = "dashboard_social_director.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Pro I') {
                $dashboardLink = "dashboard_pro_i.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Pro II') {
                $dashboardLink = "dashboard_pro_ii.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'DPRS') {
                $dashboardLink = "dashboard_dprs.php?category=" . urlencode($categoryName);
            } elseif ($categoryName === 'Sales Director') {
                $dashboardLink = "dashboard_sales_director.php?category=" . urlencode($categoryName);
            } else {
                
            }

            echo "<p><a href='$dashboardLink'>$categoryName</a></p>";
        }
    } else {
        echo "No categories found.";
    }

    $conn->close();
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

            var voiceSelectionButton = document.createElement('button');
voiceSelectionButton.textContent = 'Select Category by Voice';
voiceSelectionButton.id = 'voiceSelectionButton';
voiceSelectionButton.addEventListener('click', function() {
    recognition.start();
    console.log('Listening for category selection...');
});

document.body.appendChild(voiceSelectionButton);

        } else {
            console.log('Speech recognition not supported inyour browser.');
        }
        if ('speechSynthesis' in window) {
            var speakButton = document.getElementById('speakButton');
            var speechPhrase = new SpeechSynthesisUtterance('This is the category page');

            speakButton.addEventListener('click', function() {
                speechSynthesis.speak(speechPhrase);
            });
        } else {
            console.log('Speech synthesis not supported in your browser.');
        }
    </script>
</body>
</html>
