<?php
session_start(); // Startet die Session

// Überprüft, ob der Benutzer als Admin eingeloggt ist
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Datenbankverbindungsparameter
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüft, ob die Verbindung erfolgreich ist
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Gibt einen Fehler aus und beendet das Skript
}

// Überprüft, ob das Formular über eine POST-Anfrage gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Werte aus dem Formular abrufen
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

    // SQL-Prepared-Statement
    $stmt = $conn->prepare("INSERT INTO books.buecher (katalog, nummer, Title, kategorie, verkauft, kaufer, autor, Beschreibung, verfasser, zustand) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $katalog, $nummer, $title, $kategorie, $verkauft, $kaufer, $autor, $beschreibung, $verfasser, $zustand);

    $stmt->execute();

    // Schließt das Statement
    $stmt->close();

    // Weiterleitung zurück zum Admin-Dashboard
    header("Location: admin_dashboard.php");
    exit();
}

// Schließt die Datenbankverbindung
$conn->close();
?>