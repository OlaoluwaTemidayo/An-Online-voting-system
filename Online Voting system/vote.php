<?php
include('connect.php');

session_start();

// Check if the voter is logged in
if (!isset($_SESSION["voterId"])) {
    // Voter is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Retrieve the voter's ID from the session
$voterId = $_SESSION["voterId"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the candidate ID, category ID, and category from the form
    $candidateId = $_POST["candidateId"];
    $categoryId = $_POST["category_id"];
    $category = $_POST["category"];

    // Check if the voter has already voted in the specific category
    $checkSql = "SELECT * FROM votes WHERE voter_id = '$voterId' AND category_id = '$categoryId'";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        // Voter has already voted in this category, display a message
        echo "You have already voted in this category. Thank you for your participation.";
    } else {
        // Insert the vote into the votes table
        $insertSql = "INSERT INTO votes (voter_id, candidate_id, category_id) VALUES ('$voterId', '$candidateId', '$categoryId')";

        if (mysqli_query($conn, $insertSql)) {
            // Vote added successfully
            // Increment the vote count for the selected candidate in the specific category
            $updateSql = "UPDATE candidates SET votes = votes + 1 WHERE id = '$candidateId'";
            mysqli_query($conn, $updateSql);

            echo "Thank you for voting!";
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>