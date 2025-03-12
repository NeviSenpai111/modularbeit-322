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
    $katalog = $_POST['katalog'];
    $nummer = $_POST['nummer'];
    $title = $_POST['Title'];
    $kategorie = $_POST['kategorie'];
    $verkauft = $_POST['verkauft'];
    $kaufer = $_POST['kaufer'];
    $autor = $_POST['autor'];
    $beschreibung = $_POST['Beschreibung'];
    $verfasser = $_POST['verfasser'];
    $zustand = $_POST['zustand'];

    $stmt = $conn->prepare("INSERT INTO books.buecher (katalog, nummer, Title, kategorie, verkauft, kaufer, autor, Beschreibung, verfasser, zustand) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $katalog, $nummer, $title, $kategorie, $verkauft, $kaufer, $autor, $beschreibung, $verfasser, $zustand);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}

$conn->close();