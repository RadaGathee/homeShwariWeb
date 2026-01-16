<?php
// handle_recommendation.php

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

include 'connect.php';

try {
    if (isset($_POST['recommendation_id']) && isset($_POST['action'])) {
        $recommendation_id = $_POST['recommendation_id'];
        $action = $_POST['action'];

        if ($action === 'accept') {
            $stmt = $pdo->prepare("UPDATE recommendations SET status = 'accepted' WHERE recommendation_id = :recommendation_id");
            $stmt->bindParam(':recommendation_id', $recommendation_id);
        } elseif ($action === 'reject') {
            $stmt = $pdo->prepare("DELETE FROM recommendations WHERE recommendation_id = :recommendation_id");
            $stmt->bindParam(':recommendation_id', $recommendation_id);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            exit();
        }

        $stmt->execute();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
