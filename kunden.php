<?php
session_start();

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

// Get search term and criteria from the form
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchCriteria = isset($_GET['criteria']) ? $_GET['criteria'] : 'name';

// Get current page number from the form
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 30;
$offset = ($page - 1) * $limit;

$totalSql = "SELECT COUNT(*) as total FROM books.kunden WHERE $searchCriteria LIKE '%$searchTerm%'";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalKunden = $totalRow['total'];
$totalPages = ceil($totalKunden / $limit);

$range = 5;
$start = max(1, $page - floor($range / 2));
$end = min($totalPages, $start + $range - 1);
$start = max(1, $end - $range + 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kunden</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/src/styles.css">
</head>
<body>
<div class="header-container">
    <img src="bilder/Quill_of_Alzuhod.png" class="logo" alt="">
    <header>
        <p>Kunden</p>
        <?php if (isset($_SESSION['admin'])): ?>
            <a href="admin_dashboard.php" class="login-box login-link">Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></a>
        <?php else: ?>
            <a class="login-box login-link" href="login.php">Login</a>
        <?php endif; ?>
    </header>
</div>
<div class="container">
    <div class="container-input">
        <form method="get" action="kunden.php">
            <label>
                <input type="text" placeholder="Search" name="search" class="input" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <select name="criteria" class="input">
                    <option value="name" <?php if ($searchCriteria == 'name') echo 'selected'; ?>>Name</option>
                    <option value="email" <?php if ($searchCriteria == 'email') echo 'selected'; ?>>Email</option>
                </select>
                <button type="submit" class="button" hidden="hidden">Search</button>
            </label>
        </form>
        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
        </svg>
    </div>
</div>
<div class="container" id="kunden-list">
    <?php
    $result = $conn->query("SELECT * FROM books.kunden WHERE $searchCriteria LIKE '%$searchTerm%' LIMIT $limit OFFSET $offset");
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='box' data-id='" . $row["kid"] . "'>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($row["vorname"]) . "</p>";
            echo "<p><strong>Nachname:</strong> " . htmlspecialchars($row["name"]) . "</p>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    // Close connection
    ?>
</div>
<div class="container">
    <div class="pagination-box">
        <?php if ($page > 1): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&criteria=<?php echo urlencode($searchCriteria); ?>&page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&criteria=<?php echo urlencode($searchCriteria); ?>&page=<?php echo $i; ?>"<?php if ($i == $page) echo ' class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?search=<?php echo urlencode($searchTerm); ?>&criteria=<?php echo urlencode($searchCriteria); ?>&page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kundenList = document.getElementById('kunden-list');
        kundenList.addEventListener('click', function(event) {
            const box = event.target.closest('.box');
            if (box) {
                const kundenId = box.getAttribute('data-id');
                console.log(`Fetching details for Kunden ID: ${kundenId}`);
                fetch(`Kunden_details.php?id=${kundenId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        console.log('Kunden details fetched successfully');
                        const kundenDetails = document.createElement('div');
                        kundenDetails.classList.add('book-details');
                        kundenDetails.innerHTML = data;
                        document.body.appendChild(kundenDetails);
                        document.querySelectorAll('.box').forEach(b => b.classList.add('blurred'));
                        kundenDetails.addEventListener('click', function() {
                            kundenDetails.remove();
                            document.querySelectorAll('.box').forEach(b => b.classList.remove('blurred'));
                        });
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }
        });
    });

    function edit_Kunden(kundenId) {
        window.location.href = `edit_kunden.php?id=${kundenId}`;
    }

    function delete_Kunden(kundenId) {
        if (confirm('Are you sure you want to delete this Kunden?')) {
            fetch(`delete_kunden.php?id=${kundenId}`, { method: 'POST' })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    window.location.href = 'kunden.php';
                });
        }
    }
</script>
<footer>
    <p>&copy; 2025 Bücher</p>
</footer>
</body>
</html>