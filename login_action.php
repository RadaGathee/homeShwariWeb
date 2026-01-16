<?php
session_start();
require 'connect.php';

// Get email and password from the form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL statement
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && hash('sha256', $password) === $user['password_hash']) {
    // Start the session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role_id'] = $user['role_id'];

    // Redirect based on the user's role
    switch ($user['role_id']) {
        case 1: // Admin
            header("Location: admin.php");
            break;
        case 2: // Worker
            header("Location: worker_dashboard.php");
            break;
        case 3: // Employer
            header("Location: employer_dashboard.php");
            break;
        default:
            echo "Invalid role.";
            break;
    }
    exit();
} else {
    echo "Invalid email or password.";
}
?>
