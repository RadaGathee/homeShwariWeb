<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: index.php");
    exit();
}

include 'connect.php';

try {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profile_picture = $_POST['profile_picture'];
    $selected_skills = isset($_POST['skills']) ? $_POST['skills'] : [];

    // Begin a transaction
    $pdo->beginTransaction();

    // Update user details
    $stmt = $pdo->prepare("
        UPDATE users
        LEFT JOIN profile_info ON users.user_id = profile_info.user_id
        SET users.name = :name, users.email = :email, profile_info.phone = :phone, profile_info.address = :address, profile_info.profile_picture = :profile_picture
        WHERE users.user_id = :user_id
    ");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'profile_picture' => $profile_picture,
        'user_id' => $user_id
    ]);

    // Remove all existing skills for the user
    $stmt = $pdo->prepare("DELETE FROM user_skills WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Insert the selected skills
    if (!empty($selected_skills)) {
        $stmt = $pdo->prepare("INSERT INTO user_skills (user_id, skill_id) VALUES (:user_id, :skill_id)");
        foreach ($selected_skills as $skill_id) {
            $stmt->execute(['user_id' => $user_id, 'skill_id' => $skill_id]);
        }
    }

    // Commit the transaction
    $pdo->commit();

    // Redirect or give feedback
    header("Location: worker_dashboard.php");
    exit();

} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
