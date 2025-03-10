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
    <style>
        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }




    </style>
</head>
<body>
<header>
    <div class="flex-container">
        <div><a class="login-box login-link" href="index.php">Home</a></div>
        <div><p>Admin Dashboard</p></div>
        <div><a class="login-link login-box" href="logout.php">Logout</a></div>
    </div>
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
</div>
</body>
</html>


