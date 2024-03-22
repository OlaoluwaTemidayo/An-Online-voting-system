<?php
// Include the connect.php file
include 'connect.php';

// Execute the SQL query
$sql = "SELECT c.name AS candidate_name, COUNT(v.id) AS vote_count
        FROM candidates c
        LEFT JOIN votes v ON c.id = v.candidate_id
        GROUP BY c.id
        ORDER BY vote_count DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Results</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h2 {
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        td:first-child {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>Vote Results</h2>

    <table>
        <tr>
            <th>Candidate</th>
            <th>Vote Count</th>
        </tr>
        <?php
        // Fetch and display the vote results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["candidate_name"] . "</td>";
                echo "<td>" . $row["vote_count"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No votes recorded yet.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
