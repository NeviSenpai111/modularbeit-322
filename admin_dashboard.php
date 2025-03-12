<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/src/styles.css">
</head>
<body>
<header>
    <div><a href="index.php">Home</a></div>
    <div><p>Admin Dashboard</p></div>
    <div><a href="logout.php">Logout</a></div>
</header>

<div class="container">
    <div class="container-input">
        <h2>Admin Dashboard</h2>
        <?php
        // Get the current admin username from the session
        $currentAdmin = $_SESSION['admin'];

        // Query to get the current admin's details
        $stmt = $conn->prepare("SELECT * FROM books.benutzer WHERE benutzername = ? AND admin = 1");
        $stmt->bind_param("s", $currentAdmin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Guten Tag " . htmlspecialchars($row["name"]) . " " . htmlspecialchars($row["vorname"]) . "<br>";
            }
        } else {
            echo "No results found.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </div>

    <div class="container-input">
        <h2>Add New Book</h2>
        <form method="post" action="add_book.php">
            <label>Katalog: <input type="text" name="katalog" required></label><br>
            <label>Nummer: <input type="text" name="nummer" required></label><br>
            <label>Title: <input type="text" name="Title" required></label><br>
            <label>Kategorie: <input type="text" name="kategorie" required></label><br>
            <label>Verkauft: <input type="text" name="verkauft" required></label><br>
            <label>Käufer: <input type="text" name="kaufer" required></label><br>
            <label>Author: <input type="text" name="autor" required></label><br>
            <label>Beschreibung: <input type="text" name="Beschreibung" required></label><br>
            <label>Verfasser: <input type="text" name="verfasser" required></label><br>
            <label>Zustand: <input type="text" name="zustand" required></label><br>
            <button type="submit">Add Book</button>
        </form>
    </div>
</div>
</body>
</html>

