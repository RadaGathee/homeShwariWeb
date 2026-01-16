<?php
session_start();

// Ensure the user is logged in and has the right role
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: index.php");
    exit();
}

// Include the database connection file
include 'connect.php';

try {
    // Retrieve job post ID and status from the form submission
    if (isset($_POST['job_post_id']) && isset($_POST['status'])) {
        $job_post_id = $_POST['job_post_id'];
        $status = $_POST['status']; // 'accepted' or 'rejected'

        // Validate the status
        if (!in_array($status, ['accepted', 'rejected'])) {
            throw new Exception('Invalid status.');
        }

        // Prepare and execute the update query
        $stmt = $pdo->prepare("
            UPDATE job_posts
            SET status = :status
            WHERE job_post_id = :job_post_id
        ");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':job_post_id', $job_post_id);
        $stmt->execute();

        // Redirect to a success page or the same page with a success message
        header("Location: worker_dashboard.php?message=Job status updated successfully.");
    } else {
        throw new Exception('Missing job_post_id or status.');
    }

} catch (Exception $e) {
    // Redirect to an error page or display an error message
    header("Location: worker_dashboard.php?error=" . urlencode($e->getMessage()));
}
?>
