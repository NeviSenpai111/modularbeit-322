<?php
session_start(); // Session Starten
session_destroy(); // Session beenden
header("Location: login.php"); // Weiterleitung zur Login-Seite
exit();
