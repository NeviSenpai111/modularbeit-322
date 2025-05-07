<?php
// Session starten
session_start();
// Datenbank Verbindung
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books";

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Buch ID aus der URL abrufen
$bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($bookId > 0) {
    // Buchdetails abrufen und mit Kategorien und Zuständen verknüpfen
    $stmt = $conn->prepare("SELECT b.*, k.kategorie AS kategorie_name, z.beschreibung AS zustand_name FROM books.buecher b LEFT JOIN books.kategorien k ON b.kategorie = k.id LEFT JOIN books.zustaende z ON b.zustand = z.zustand WHERE b.id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Invalid book ID.");
}

// Verbindung schließen
$conn->close();

// Buchdetails anzeigen mit Buttons für Admin
if ($book): ?>
    <div class="box-details">
        <img src="bilder/book.png" alt="Image of <?php echo htmlspecialchars($book['Title']); ?>">
        <p><strong>Katalog:</strong> <?php echo htmlspecialchars($book['katalog']); ?></p>
        <p><strong>Nummer:</strong> <?php echo htmlspecialchars($book['nummer']); ?></p>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($book['Title']); ?></p>
        <p><strong>Kategorie:</strong> <?php echo htmlspecialchars($book['kategorie_name']); ?></p>
        <p><strong>Verkauft:</strong> <?php echo htmlspecialchars($book['verkauft']); ?></p>
        <p><strong>Käufer:</strong> <?php echo htmlspecialchars($book['kaufer']); ?></p>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['autor']); ?></p>
        <p><strong>Beschreibung:</strong> <?php echo htmlspecialchars($book['Beschreibung']); ?></p>
        <p><strong>Verfasser:</strong> <?php echo htmlspecialchars($book['verfasser']); ?></p>
        <p><strong>Zustand:</strong> <?php echo htmlspecialchars($book['zustand_name']); ?></p>
        <?php if (isset($_SESSION['admin'])): ?>
            <button class="button button-edit" onclick="edit_Book(<?php echo $book['id']; ?>)">Edit</button>
            <button class="button button-delete" onclick="delete_Book(<?php echo $book['id']; ?>)">Delete</button>
        <?php endif; ?>
    </div>
<?php else: ?>
    <p>Book not found.</p>
<?php endif; ?>
