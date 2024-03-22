<?php
include('connect.php');

// Check if the category parameter is set in the URL and matches the "Pro II" category
if (isset($_GET['category']) && $_GET['category'] === 'Pro II') {
    // Retrieve the list of candidates who applied for Pro II from the candidates table
    $sql = "SELECT * FROM candidates WHERE category = 'Pro II'";
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
            echo "<input type='hidden' name='category_id' value='13'>"; // Assuming category_id 13 corresponds to 'Pro II'
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