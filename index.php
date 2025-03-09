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

// Get search term from the form
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Get current page number from the form
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$totalSql = "SELECT COUNT(*) as total FROM books.buecher WHERE Title LIKE '%$searchTerm%'";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalBooks = $totalRow['total'];
$totalPages = ceil($totalBooks / $limit);

$range = 5;
$start = max(1, $page - floor($range / 2));
$end = min($totalPages, $start + $range - 1);
$start = max(1, $end - $range + 1);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Books</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/src/styles.css">
</head>
<body>
<header>
    <aside id="sidebar">
        <nav>
            <ul>
                <li><a href="index.html"><i class="fa-solid fa-house"></i>   Home</a></li>
                <li><a href="uebermich.html"><i class="fa-solid fa-user"></i>   Über mich</a></li>
                <li><a href="hobbies.html"><i class="fa-solid fa-brain"></i>   Hobbies</a></li>
                <li><a href="projekte.html"><i class="fa-solid fa-code"></i>   Projekte</a> </li>
                <li><a href="impressum.html"><i class="fa-solid fa-envelope"></i>   Impressum</a></li>
            </ul>
        </nav>
    </aside>
    <p>Bücher</p>
</header>
<div class="container">
    <div class="container-input">
        <form method="get" action="index.php">
            <label>
                <input type="text" placeholder="Search" name="search" class="input" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit" class="button" hidden="hidden">Search</button>
            </label>
        </form>
        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
        </svg>
    </div>
</div>
<div class="container">
    <?php
    $result = $conn->query("SELECT * FROM books.buecher WHERE Title LIKE '%$searchTerm%' LIMIT $limit OFFSET $offset");
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='box'>";
            echo "<p><strong>Katalog:</strong> " . $row["katalog"] . "</p>";
            echo "<p><strong>Nummer:</strong> " . $row["nummer"] . "</p>";
            echo "<p><strong>Title:</strong> " . $row["Title"] . "</p>";
            echo "<p><strong>Beschreibung:</strong> " . $row["Beschreibung"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>
</div>
<div class="container">
    <div class="pagination-box">
        <?php if ($page > 1): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>"<?php if ($i == $page) echo ' class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>