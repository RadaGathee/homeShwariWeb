<?php
include 'connect.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $job_post_id = $_POST['job_post_id'];
        $job_description = $_POST['job_description'];
        $location = $_POST['location'];
        $salary = $_POST['salary'];
        $deadline = $_POST['deadline'];

        $stmt = $pdo->prepare("
            UPDATE job_posts
            SET job_description = :job_description,
                location = :location,
                salary = :salary,
                deadline = :deadline
            WHERE job_post_id = :job_post_id
        ");
        $stmt->execute([
            'job_description' => $job_description,
            'location' => $location,
            'salary' => $salary,
            'deadline' => $deadline,
            'job_post_id' => $job_post_id
        ]);

        header("Location: employer_dashboard.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
