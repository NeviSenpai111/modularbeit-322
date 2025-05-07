<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="src/styles.css">
</head>
<body>
<header>
    <div><a href="index.php" class="button button-home">Home</a></div>
    <a href="kunden.php" class="button button-home">Manage Kunden</a>
    <a href="change_password.php" class="button button-home">Passwort ändern</a>
    <div><a href="logout.php" class="button button-logout">Logout</a></div>
</header>

<div class="container">
    <div class="form-container">
        <h2>Add New Book</h2>
        <form method="post" action="add_book.php">
            <label>Katalog: <input type="text" name="katalog" required></label>
            <label>Nummer: <input type="text" name="nummer" required></label>
            <label>Title: <input type="text" name="Title" required></label>
            <label>Kategorie: <input type="text" name="kategorie" required></label>
            <label>Verkauft: <input type="text" name="verkauft" required></label>
            <label>Käufer: <input type="text" name="kaufer" required></label>
            <label>Author: <input type="text" name="autor" required></label>
            <label>Beschreibung: <input type="text" name="Beschreibung" required></label>
            <label>Verfasser: <input type="text" name="verfasser" required></label>
            <label>Zustand: <input type="text" name="zustand" required></label>
            <button type="submit" class="button button-add">Add Book</button>
        </form>
    </div>
    <div class="form-container">
        <h2>Add New Kunde</h2>
        <form method="post" action="add_kunde.php">
            <label>Vorname: <input type="text" name="vorname" required></label>
            <label>Name: <input type="text" name="name" required></label>
            <label>Email: <input type="email" name="email" required></label>
            <label>Geburtstag: <input type="date" name="geburtstag" required></label>
            <label>Geschlecht: <input type="text" name="geschlecht" required></label>
            <label>Kunde Seit: <input type="date" name="kunde_seit" required></label>
            <button type="submit" class="button button-add">Add Kunde</button>
        </form>
        </div>
        <div class="form-container">
            <h2>Add new Admin</h2>
                <form method="post" action="add_admin.php">
                    <label>Name: <input type="text" name="name" required></label>
                    <label>Benutzername: <input type="text" name="benutzername" required></label>
                    <label>Email: <input type="email" name="email" required></label>
                    <label>Passwort: <input type="password" name="password" required></label>
                    <button type="submit" class="button button-add">Add Admin</button>
                </form>
        </div>
</div>

<footer>
    <p>&copy; 2025 Bücher</p>
</footer>

</body>
</html>
