<?php
    session_start(); // Startet die Session

    // Überprüft, ob der Benutzer als Admin eingeloggt ist
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php"); 
        exit();
    }

    // Datenbankverbindung herstellen
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "books";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verbindung überprüfen
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Kunden-ID aus der URL abrufen
    $kundenId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Formulardaten abrufen
        $vorname = $_POST['vorname'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $geburtstag = $_POST['geburtstag'];
        $geschlecht = $_POST['geschlecht'];
        $kunde_seit = $_POST['kunde_seit'];

        // Kundeninformationen aktualisieren
        $stmt = $conn->prepare("UPDATE books.kunden SET vorname=?, name=?, email=?, geburtstag=?, geschlecht=?, kunde_seit=? WHERE kid=?");
        $stmt->bind_param("ssssssi", $vorname, $name, $email, $geburtstag, $geschlecht, $kunde_seit, $kundenId);
        $stmt->execute();
        $stmt->close();

        // Weiterleitung zur Kundenübersicht
        header("Location: kunden.php");
        exit();
    }

    // Kundeninformationen aus der Datenbank abrufen
    $stmt = $conn->prepare("SELECT * FROM books.kunden WHERE kid = ?");
    $stmt->bind_param("i", $kundenId);
    $stmt->execute();
    $result = $stmt->get_result();
    $kunden = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    ?>