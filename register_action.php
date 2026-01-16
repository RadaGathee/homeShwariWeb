<?php
require 'connect.php';

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role_id = $_POST['role_id'];

// Hash the password
$hashed_password = hash('sha256', $password);

// Prepare and execute the SQL statement
$sql = "INSERT INTO users (role_id, name, email, password_hash) VALUES (:role_id, :name, :email, :password_hash)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':role_id', $role_id);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password_hash', $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful. <a href='login.php'>Login here</a>";
} else {
    echo "Registration failed.";
}
?>
