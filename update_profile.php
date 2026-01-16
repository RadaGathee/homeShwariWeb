<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: index.php");
    exit();
}

// Include the database connection file
include 'connect.php';

try {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Get form data
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profile_picture = $_POST['profile_picture'];

    // Update the profile info in the database
    $stmt = $pdo->prepare("
        UPDATE profile_info
        SET phone = :phone,
            address = :address,
            profile_picture = :profile_picture
        WHERE user_id = :user_id
    ");
    $stmt->execute([
        'phone' => $phone,
        'address' => $address,
        'profile_picture' => $profile_picture,
        'user_id' => $user_id
    ]);

    // Redirect back to the dashboard
    header("Location: employer_dashboard.php");
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>