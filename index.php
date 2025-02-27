<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from a table
$sql = "SELECT * FROM books.buecher";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<div class='container'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='box'>";
        echo "<p><strong>Katalog:</strong> " . $row["katalog"] . "</p>";
        echo "<p><strong>Nummer:</strong> " . $row["nummer"] . "</p>";
        echo "<p><strong>Title:</strong> " . $row["Title"] . "</p>";
        echo "<p><strong>Beschreibung:</strong> " . $row["Beschreibung"] . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="src/styles.css">
    <title>Title</title>
</head>
<body>
</body>
</html>