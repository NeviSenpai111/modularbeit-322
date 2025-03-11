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

    $stmt = $conn->prepare("UPDATE books.buecher SET katalog=?, nummer=?, Title=?, kategorie=?, verkauft=?, kaufer=?, autor=?, Beschreibung=?, verfasser=?, zustand=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $katalog, $nummer, $title, $kategorie, $verkauft, $kaufer, $autor, $beschreibung, $verfasser, $zustand, $bookId);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM books.buecher WHERE id = ?");
$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Book</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/src/styles.css">
</head>
<body>
<div class="container">
    <h2>Edit Book</h2>
    <form method="post" action="edit_book.php?id=<?php echo $bookId; ?>">
        <label>Katalog: <input type="text" name="katalog" value="<?php echo htmlspecialchars($book['katalog']); ?>"></label><br>
        <label>Nummer: <input type="text" name="nummer" value="<?php echo htmlspecialchars($book['nummer']); ?>"></label><br>
        <label>Title: <input type="text" name="Title" value="<?php echo htmlspecialchars($book['Title']); ?>"></label><br>
        <label>Kategorie: <input type="text" name="kategorie" value="<?php echo htmlspecialchars($book['kategorie']); ?>"></label><br>
        <label>Verkauft: <input type="text" name="verkauft" value="<?php echo htmlspecialchars($book['verkauft']); ?>"></label><br>
        <label>Käufer: <input type="text" name="kaufer" value="<?php echo htmlspecialchars($book['kaufer']); ?>"></label><br>
        <label>Author: <input type="text" name="autor" value="<?php echo htmlspecialchars($book['autor']); ?>"></label><br>
        <label>Beschreibung: <input type="text" name="Beschreibung" value="<?php echo htmlspecialchars($book['Beschreibung']); ?>"></label><br>
        <label>Verfasser: <input type="text" name="verfasser" value="<?php echo htmlspecialchars($book['verfasser']); ?>"></label><br>
        <label>Zustand: <input type="text" name="zustand" value="<?php echo htmlspecialchars($book['zustand']); ?>"></label><br>
        <button type="submit">Save</button>
    </form>
</div>
</body>
</html>