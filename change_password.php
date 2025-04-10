<?php
        session_start();

        // Überprüfen, ob der Benutzer eingeloggt ist
        if (!isset($_SESSION['admin'])) {
            header("Location: login.php");
            exit();
        }

        // Datenbankverbindung
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "books";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Passwort ändern Logik
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $benutzername = $_SESSION['admin'];
            $altesPasswort = $_POST['altes_passwort'];
            $neuesPasswort = $_POST['neues_passwort'];

            // Benutzer anhand des Benutzernamens abrufen
            $stmt = $conn->prepare("SELECT * FROM books.benutzer WHERE benutzername = ?");
            $stmt->bind_param("s", $benutzername);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Altes Passwort überprüfen
                if (password_verify($altesPasswort, $user['passwort'])) {
                    // Neues Passwort hashen und aktualisieren
                    $hashedPassword = password_hash($neuesPasswort, PASSWORD_DEFAULT);
                    $updateStmt = $conn->prepare("UPDATE books.benutzer SET passwort = ? WHERE benutzername = ?");
                    $updateStmt->bind_param("ss", $hashedPassword, $benutzername);

                    if ($updateStmt->execute()) {
                        $success = "Passwort erfolgreich geändert.";
                    } else {
                        $error = "Fehler beim Aktualisieren des Passworts.";
                    }

                    $updateStmt->close();
                } else {
                    $error = "Das alte Passwort ist falsch.";
                }
            } else {
                $error = "Benutzer nicht gefunden.";
            }

            $stmt->close();
        }

        $conn->close();
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Passwort ändern</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="src/styles.css">
        </head>
        <body>
        <header>
            <a href="index.php" class="button button-home">Home</a>
            <p>Passwort ändern</p>
        </header>
        <div class="login-container">
            <h2>Passwort ändern</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="post" action="change_password.php">
                <label for="altes_passwort">Altes Passwort:</label>
                <input type="password" id="altes_passwort" name="altes_passwort" required>
                <label for="neues_passwort">Neues Passwort:</label>
                <input type="password" id="neues_passwort" name="neues_passwort" required>
                <button type="submit">Passwort ändern</button>
            </form>
        </div>
        <?php if (isset($success)): ?>
            <script>
                alert("<?php echo $success; ?>");
            </script>
        <?php endif; ?>
        <footer>
            <p>&copy; 2025 Bücher</p>
        </footer>
        </body>
        </html>