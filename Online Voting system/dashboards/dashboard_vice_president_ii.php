<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background color */
            color: #006400; /* Dark green text color */
            margin: 20px;
        }

        h3 {
            color: #006400; /* Dark green header text color */
            margin-bottom: 5px;
        }

        .candidate-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .candidate {
            border: 2px solid #006400; /* Dark green border */
            padding: 10px;
            margin: 10px;
            width: 300px;
            text-align: center;
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
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .vote-button:hover {
            background-color: #004d00; /* Darker green on hover */
        }
    </style>
<?php
include('connect.php');

// Check if the category parameter is set in the URL and matches the "Vice President II" category
if (isset($_GET['category']) && $_GET['category'] === 'Vice President II') {
    // Retrieve the list of candidates who applied for Vice President II from the candidates table
    $sql = "SELECT * FROM candidates WHERE category = 'Vice President II'";
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
            echo "<input type='hidden' name='category_id' value='3'>"; // Assuming category_id 3 corresponds to 'Secretary'
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

<script>
    function confirmVote() {
        return confirm("Are you sure you want to vote for this candidate?");
    }
</script>