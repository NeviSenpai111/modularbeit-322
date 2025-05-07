<?php
session_start();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $benutzername = $_POST['benutzername'];
    $email = $_POST['email'];
    $passwort = $_POST['password'];
    $admin = 1;

    // Passwort hashen
    $hashedPasswort = password_hash($passwort, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO books.benutzer (name, benutzername, email, passwort, admin) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $benutzername, $email, $hashedPasswort, $admin);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New Admin added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}

$conn->close();
?>
