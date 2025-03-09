<?php
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

// Get book ID from URL
$bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($bookId > 0) {
    // Fetch book details
    $stmt = $conn->prepare("SELECT * FROM buecher WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Invalid book ID.");
}

// Close connection
$conn->close();

if ($book): ?>
    <div class="box-details">
        <img src="<?php echo htmlspecialchars($book['foto']); ?>" alt="Book Image">
        <p><strong>Katalog:</strong> <?php echo htmlspecialchars($book['katalog']); ?></p>
        <p><strong>Nummer:</strong> <?php echo htmlspecialchars($book['nummer']); ?></p>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($book['Title']); ?></p>
        <p><strong>Kategorie</strong> <?php echo htmlspecialchars($book['kategorie'])?> </p>
        <p><strong>Verkauft:</strong> <?php echo htmlspecialchars($book['verkauft']); ?></p>
        <p><strong>Käufer:</strong> <?php echo htmlspecialchars($book['kaufer']); ?></p>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['autor']); ?></p>
        <p><strong>Beschreibung:</strong> <?php echo htmlspecialchars($book['Beschreibung']); ?></p>
        <p><strong>Verfasser:</strong> <?php echo htmlspecialchars($book['verfasser']); ?></p>
        <p><strong>Zustand:</strong> <?php echo htmlspecialchars($book['zustand']); ?></p>
    </div>
<?php else: ?>
    <p>Book not found.</p>
<?php endif; ?>