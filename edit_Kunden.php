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

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kunde bearbeiten</title>
    <link rel="stylesheet" href="src/styles.css">
</head>
<body>
<header>
<h1>Kunde bearbeiten</h1>
</header>
<div class="container">
    <form method="post">
        <div class="form-container">
            <label>Vorname:
                <input type="text" name="vorname" value="<?php echo htmlspecialchars($kunden['vorname']); ?>" required>
            </label>
            <label>Name:
                <input type="text" name="name" value="<?php echo htmlspecialchars($kunden['name']); ?>" required>
            </label>
            <label>Email:
                <input type="email" name="email" value="<?php echo htmlspecialchars($kunden['email']); ?>" required>
            </label>
            <label>Geburtstag:
                <input type="date" name="geburtstag" value="<?php echo htmlspecialchars($kunden['geburtstag']); ?>" required>
            </label>
            <label>Geschlecht:
                <input type="text" name="geschlecht" value="<?php echo htmlspecialchars($kunden['geschlecht']); ?>" required>
            </label>
            <label>Kunde seit:
                <input type="date" name="kunde_seit" value="<?php echo htmlspecialchars($kunden['kunde_seit']); ?>" required>
            </label>
            <button type="submit">Speichern</button>
        </div>
    </form>
</div>
</body>
</html>
