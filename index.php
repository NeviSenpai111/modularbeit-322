<?php
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

// Suchbegriff und Sortierkriterien aus dem Formular abrufen
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchCriteria = isset($_GET['criteria']) ? $_GET['criteria'] : 'Title';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'Title ASC';

// Seitenparameter für die Paginierung
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Validierung der Eingaben
$totalSql = "SELECT COUNT(*) as total FROM books.buecher WHERE $searchCriteria LIKE '%$searchTerm%'";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalBooks = $totalRow['total'];
$totalPages = ceil($totalBooks / $limit);

// Paginierung
$range = 5;
$start = max(1, $page - floor($range / 2));
$end = min($totalPages, $start + $range - 1);
$start = max(1, $end - $range + 1);
?>

<!-- Header und CSS -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Books</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="src/styles.css">
</head>
<!--Body vom HTML-->
<body>
<div class="header-container">
    <img src="bilder/Quill_of_Alzuhod.png" class="logo" alt="">
    <header>
        <p>Bücher</p>
        <?php if (isset($_SESSION['admin'])): ?>
            <a href="admin_dashboard.php" class="login-box login-link button-home">Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></a>
        <?php else: ?>
            <a class="login-box login-link button-home" href="login.php">Login</a>
        <?php endif; ?>
    </header>
</div>
<!-- Suche und Filter -->
<div class="container">
    <div class="container-input">
        <form method="get" action="index.php">
            <label>
                <input type="text" placeholder="Search" name="search" class="input" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <select name="criteria" class="input" onchange="this.form.submit()">
                    <option value="Title" <?php if ($searchCriteria == 'Title') echo 'selected'; ?>>Title</option>
                    <option value="autor" <?php if ($searchCriteria == 'autor') echo 'selected'; ?>>Author</option>
                    <option value="kategorie" <?php if ($searchCriteria == 'kategorie') echo 'selected'; ?>>Kategorie</option>
                </select>
                <select name="sort" class="input" onchange="this.form.submit()">
                    <option value="Title ASC" <?php if ($sortOrder == 'Title ASC') echo 'selected'; ?>>Title (A-Z)</option>
                    <option value="Title DESC" <?php if ($sortOrder == 'Title DESC') echo 'selected'; ?>>Title (Z-A)</option>
                    <option value="autor ASC" <?php if ($sortOrder == 'autor ASC') echo 'selected'; ?>>Author (A-Z)</option>
                    <option value="autor DESC" <?php if ($sortOrder == 'autor DESC') echo 'selected'; ?>>Author (Z-A)</option>
                </select>
                <button type="submit" class="button" hidden="hidden">Search</button>
            </label>
        </form>
        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
        </svg>
    </div>
</div>
<!-- Buchliste -->
<div class="container" id="book-list">
    <?php
    $result = $conn->query("SELECT b.*, k.kategorie AS kategorie_name, z.beschreibung AS zustand_name FROM books.buecher b LEFT JOIN books.kategorien k ON b.kategorie = k.id LEFT JOIN books.zustaende z ON b.zustand = z.zustand WHERE $searchCriteria LIKE '%$searchTerm%' ORDER BY $sortOrder LIMIT $limit OFFSET $offset");
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='box' data-id='" . $row["id"] . "'>";
            echo "<p><strong>Katalog:</strong> " . htmlspecialchars($row["katalog"]) . "</p>";
            echo "<p><strong>Nummer:</strong> " . htmlspecialchars($row["nummer"]) . "</p>";
            echo "<p><strong>Title:</strong> " . htmlspecialchars($row["Title"]) . "</p>";
            echo "<p><strong>Beschreibung:</strong> " . htmlspecialchars($row["Beschreibung"]) . "</p>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>
    <!-- Pagination -->
</div>
<div class="container">
    <div class="pagination-box">
        <?php if ($page > 1): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&criteria=<?php echo urlencode($searchCriteria); ?>&sort=<?php echo urlencode($sortOrder); ?>&page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&criteria=<?php echo urlencode($searchCriteria); ?>&sort=<?php echo urlencode($sortOrder); ?>&page=<?php echo $i; ?>"<?php if ($i == $page) echo ' class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&criteria=<?php echo urlencode($searchCriteria); ?>&sort=<?php echo urlencode($sortOrder); ?>&page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
<!-- Java Script für Buchdetails -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookList = document.getElementById('book-list');
        bookList.addEventListener('click', function(event) {
            const box = event.target.closest('.box');
            if (box) {
                const bookId = box.getAttribute('data-id');
                fetch(`book_details.php?id=${bookId}`)
                    .then(response => response.text())
                    .then(data => {
                        const bookDetails = document.createElement('div');
                        bookDetails.classList.add('book-details');
                        bookDetails.innerHTML = data;
                        document.body.appendChild(bookDetails);
                        document.querySelectorAll('.box').forEach(b => b.classList.add('blurred'));
                        bookDetails.addEventListener('click', function() {
                            bookDetails.remove();
                            document.querySelectorAll('.box').forEach(b => b.classList.remove('blurred'));
                        });
                    });
            }
        });
    });
// Edit and Delete Buttons und Funktionen
    function edit_Book(bookId) {
        window.location.href = `edit_book.php?id=${bookId}`;
    }

    function delete_Book(bookId) {
        if (confirm('Are you sure you want to delete this book?')) {
            fetch(`delete_book.php?id=${bookId}`, { method: 'POST' })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    window.location.href = 'index.php';
                });
        }
    }

</script>
<footer>
    <p>&copy; 2025 Bücher</p>
</footer>
</body>
</html>