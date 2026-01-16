<?php
// Database connection details
$host = 'sql107.ezyro.com'; // or your database host
$dbname = 'ezyro_37204073_domestic'; // your database name
$user = 'ezyro_37204073'; // your database username
$pass = 'a175f662ee'; // your database password

// Create connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
