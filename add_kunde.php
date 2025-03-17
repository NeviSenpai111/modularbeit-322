<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vorname = $_POST['vorname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $geburtstag = $_POST['geburtstag'];
    $geschlecht = $_POST['geschlecht'];
    $kunde_seit = $_POST['kunde_seit'];

    $stmt = $conn->prepare("INSERT INTO books.kunden (vorname, name, email, geburtstag, geschlecht, kunde_seit) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $vorname, $name, $email, $geburtstag, $geschlecht, $kunde_seit);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}

$conn->close();
?>