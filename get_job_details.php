<?php
include 'connect.php';

try {
    if (isset($_GET['job_post_id'])) {
        $job_post_id = $_GET['job_post_id'];

        $stmt = $pdo->prepare("
            SELECT job_post_id, job_description, location, salary, deadline 
            FROM job_posts 
            WHERE job_post_id = :job_post_id
        ");
        $stmt->bindParam(':job_post_id', $job_post_id);
        $stmt->execute();
        $job = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($job);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
