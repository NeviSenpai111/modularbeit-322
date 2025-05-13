<?php
    session_start(); // Startet die Session,

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

    // Überprüft, ob eine Buch-ID über die URL übergeben wurde
    $bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($bookId > 0) {
        // Prepared Statement
        $stmt = $conn->prepare("DELETE FROM books.buecher WHERE id = ?");
        $stmt->bind_param("i", $bookId); // Bindet die Buch-ID als Parameter


        $stmt->execute();


        $stmt->close();

        // Gibt eine Erfolgsmeldung aus
        echo "Book deleted successfully.";
    } else {
        // Gibt eine Fehlermeldung aus, wenn die Buch-ID ungültig ist
        echo "Invalid book ID.";
    }

    // Schließt die Verbindung zur Datenbank
    $conn->close();
    ?>