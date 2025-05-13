<?php
session_start();

// Datenbankverbindung
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$kundenId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($kundenId > 0) {
    // Kunden Details abrufen
    $stmt = $conn->prepare("SELECT * FROM books.kunden WHERE kid = ?");
    $stmt->bind_param("i", $kundenId);
    $stmt->execute();
    $result = $stmt->get_result();
    $kunden = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Invalid Kunden ID.");
}

// Verbindung schließen
$conn->close();

if ($kunden): ?>
    <div class="box-details">
        <img src="bilder/kunde.png" alt="BILD">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($kunden['vorname']); ?></p>
        <p><strong>Nachname:</strong> <?php echo htmlspecialchars($kunden['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($kunden['email']); ?></p>
        <p><strong>Geburtstag:</strong> <?php echo htmlspecialchars($kunden['geburtstag']); ?></p>
        <p><strong>Geschlecht:</strong> <?php echo htmlspecialchars($kunden['geschlecht']); ?></p>
        <p><strong>Kunde Seit</strong> <?php echo htmlspecialchars($kunden['kunde_seit']); ?> </p>
        <p><strong>Email</strong> <?php echo htmlspecialchars($kunden['email']); ?> </p>
        <?php if (isset($_SESSION['admin'])): ?>
            <button class="button button-edit" onclick="edit_Kunden(<?php echo $kunden['kid']; ?>)">Edit</button>
            <button class="button button-delete" onclick="delete_Kunden(<?php echo $kunden['kid']; ?>)">Delete</button>
        <?php endif; ?>
    </div>
<?php else: ?>
    <p>Kunden not found.</p>
<?php endif; ?>