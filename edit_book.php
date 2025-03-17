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
    <style>
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin: 20px 0;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container label {
            display: flex;
            flex-direction: column;
            margin-bottom: 5px;
        }

        .form-container input, .form-container textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #333;
        }

        .form-container button {
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #333;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2>Edit Book</h2>
        <form method="post" action="edit_book.php?id=<?php echo $bookId; ?>">
            <label>Katalog: <input type="text" name="katalog" value="<?php echo htmlspecialchars($book['katalog']); ?>"></label>
            <label>Nummer: <input type="text" name="nummer" value="<?php echo htmlspecialchars($book['nummer']); ?>"></label>
            <label>Title: <input type="text" name="Title" value="<?php echo htmlspecialchars($book['Title']); ?>"></label>
            <label>Kategorie: <input type="text" name="kategorie" value="<?php echo htmlspecialchars($book['kategorie']); ?>"></label>
            <label>Verkauft: <input type="text" name="verkauft" value="<?php echo htmlspecialchars($book['verkauft']); ?>"></label>
            <label>Käufer: <input type="text" name="kaufer" value="<?php echo htmlspecialchars($book['kaufer']); ?>"></label>
            <label>Author: <input type="text" name="autor" value="<?php echo htmlspecialchars($book['autor']); ?>"></label>
            <label>Beschreibung: <textarea name="Beschreibung"><?php echo htmlspecialchars($book['Beschreibung']); ?></textarea></label>
            <label>Verfasser: <input type="text" name="verfasser" value="<?php echo htmlspecialchars($book['verfasser']); ?>"></label>
            <label>Zustand: <input type="text" name="zustand" value="<?php echo htmlspecialchars($book['zustand']); ?>"></label>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
<footer>
    <p>&copy; 2025 Bücher</p>
</footer>
</body>
</html>