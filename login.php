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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM books.benutzer WHERE benutzername = ? AND passwort = ? AND admin = 1");
    $stmt->bind_param("ss", $benutzername, $passwort);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Valid credentials
        $_SESSION['admin'] = $benutzername;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Invalid credentials
        $error = "Invalid username or password or you are not an admin";
    }

    // Close the statement
    $stmt->close();
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/src/styles.css">
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="benutzername">Username:</label>
        <input type="text" id="benutzername" name="benutzername" required>
        <label for="passwort">Password:</label>
        <input type="password" id="passwort" name="passwort" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>