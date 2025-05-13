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

// Erstellt eine Verbindung zur Datenbank
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Überprüft, ob eine Kunden-ID über die URL übergeben wurde
$kundenId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($kundenId > 0) {
    // Prepared Statement
    $stmt = $conn->prepare("DELETE FROM books.kunden WHERE kid = ?");
    $stmt->bind_param("i", $kundenId);


    $stmt->execute();

    // Schließt die vorbereitete Anweisung
    $stmt->close();

    // Gibt eine Erfolgsmeldung aus
    echo "Kunden deleted successfully.";
} else {
    // Gibt eine Fehlermeldung aus, wenn die Kunden-ID ungültig ist
    echo "Invalid Kunden ID.";
}

// Schließt die Verbindung zur Datenbank
$conn->close();
?>