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

        // Login-Logik
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $benutzername = $_POST['benutzername'];
            $passwort = $_POST['passwort'];

            // Benutzer anhand des Benutzernamens abrufen
            $stmt = $conn->prepare("SELECT * FROM books.benutzer WHERE benutzername = ? AND admin = 1");
            $stmt->bind_param("s", $benutzername);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Passwort überprüfen
                if (password_verify($passwort, $user['passwort'])) {
                    // Login erfolgreich
                    $_SESSION['admin'] = $benutzername;
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    $error = "Ungültiger Benutzername oder Passwort.";
                }
            } else {
                $error = "Ungültiger Benutzername oder Passwort.";
            }

            $stmt->close();
        }

        $conn->close();
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Admin Login</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="src/styles.css">
        </head>
        <body>
        <header>
            <a href="index.php" class="button button-home">Home</a>
            <p>Admin Login</p>
        </header>
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
        <footer>
            <p>&copy; 2025 Bücher</p>
        </footer>
        </body>
        </html>