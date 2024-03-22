<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $name = $_POST["name"];
    $level = $_POST["level"];
    $matric_number = $_POST["matric_number"];
    $category = $_POST["category"]; // Update the variable name to match the input field name
    $bio = $_POST["bio"];

    // Process the uploaded photo
    $photo = $_FILES["photo"]["name"];
    $photo_tmp = $_FILES["photo"]["tmp_name"];
    $photo_path = "photos/" . $photo;
    move_uploaded_file($photo_tmp, $photo_path);

    // Insert the candidate data into the candidates table
    $sql = "INSERT INTO candidates (name, level, matric_number, category, bio, photo) VALUES ('$name', '$level', '$matric_number', '$category', '$bio', '$photo_path')";

    if (mysqli_query($conn, $sql)) {
        // Display a registration success message
        echo "<p>Candidate registered successfully! Thank you for registering as a candidate.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>