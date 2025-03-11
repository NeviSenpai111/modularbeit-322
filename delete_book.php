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

$bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($bookId > 0) {
    $stmt = $conn->prepare("DELETE FROM books.buecher WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $stmt->close();
    echo "Book deleted successfully.";
} else {
    echo "Invalid book ID.";
}

$conn->close();
?>
