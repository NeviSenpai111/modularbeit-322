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

    // Buch-ID aus der URL abrufen
    $bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

        // Prepared Statement
        $stmt = $conn->prepare("UPDATE books.buecher SET katalog=?, nummer=?, Title=?, kategorie=?, verkauft=?, kaufer=?, autor=?, Beschreibung=?, verfasser=?, zustand=? WHERE id=?");
        $stmt->bind_param("ssssssssssi", $katalog, $nummer, $title, $kategorie, $verkauft, $kaufer, $autor, $beschreibung, $verfasser, $zustand, $bookId);


        $stmt->execute();


        $stmt->close();

        // Weiterleitung zur Startseite nach erfolgreicher Bearbeitung
        header("Location: index.php");
        exit();
    }

    // Buchdetails aus der Datenbank abrufen
    $stmt = $conn->prepare("SELECT * FROM books.buecher WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc(); // Holt die Buchdetails als assoziatives Array
    $stmt->close();

    // Schließt die Verbindung zur Datenbank
    $conn->close();
    ?>