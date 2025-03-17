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

$kundenId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vorname = $_POST['vorname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $geburtstag = $_POST['geburtstag'];
    $geschlecht = $_POST['geschlecht'];
    $kunde_seit = $_POST['kunde_seit'];

    $stmt = $conn->prepare("UPDATE books.kunden SET vorname=?, name=?, email=?, geburtstag=?, geschlecht=?, kunde_seit=? WHERE kid=?");
    $stmt->bind_param("ssssssi", $vorname, $name, $email, $geburtstag, $geschlecht, $kunde_seit, $kundenId);
    $stmt->execute();
    $stmt->close();
    header("Location: kunden.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM books.kunden WHERE kid = ?");
$stmt->bind_param("i", $kundenId);
$stmt->execute();
$result = $stmt->get_result();
$kunden = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Kunden</title>
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

        .form-container input {
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
        <h2>Edit Kunden</h2>
        <form method="post" action="edit_kunden.php?id=<?php echo $kundenId; ?>">
            <label>Vorname: <input type="text" name="vorname" value="<?php echo htmlspecialchars($kunden['vorname']); ?>"></label>
            <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($kunden['name']); ?>"></label>
            <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($kunden['email']); ?>"></label>
            <label>Geburtstag: <input type="date" name="geburtstag" value="<?php echo htmlspecialchars($kunden['geburtstag']); ?>"></label>
            <label>Geschlecht: <input type="text" name="geschlecht" value="<?php echo htmlspecialchars($kunden['geschlecht']); ?>"></label>
            <label>Kunde Seit: <input type="date" name="kunde_seit" value="<?php echo htmlspecialchars($kunden['kunde_seit']); ?>"></label>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
<footer>
    <p>&copy; 2025 Bücher</p>
</footer>
</body>
</html>
