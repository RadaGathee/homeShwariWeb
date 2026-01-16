<?php
include 'connect.php';

try {
    if (isset($_GET['job_id'])) {
        $job_id = $_GET['job_id'];

        $stmt = $pdo->prepare("DELETE FROM job_posts WHERE job_post_id = :job_id");
        $stmt->bindParam(':job_id', $job_id);
        $stmt->execute();

        header("Location: employer_dashboard.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
