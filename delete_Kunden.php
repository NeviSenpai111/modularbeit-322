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

$kundenId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($kundenId > 0) {
    $stmt = $conn->prepare("DELETE FROM books.kunden WHERE kid = ?");
    $stmt->bind_param("i", $kundenId);
    $stmt->execute();
    $stmt->close();
    echo "Kunden deleted successfully.";
} else {
    echo "Invalid Kunden ID.";
}

$conn->close();
?>