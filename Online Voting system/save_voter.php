<?php
include('connect.php');

// Retrieve the category ID
$categoryId = $_POST["category_id"]; // Assuming you are passing the categoryId from the previous page

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $name = $_POST["name"];
    $level = $_POST["level"];
    $matric_number = $_POST["matric_number"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the voter data into the voters table
    $sql = "INSERT INTO voters (name, level, matric_number, password) VALUES ('$name', '$level', '$matric_number', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {
        // Voter registered successfully

        // Redirect to the login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>