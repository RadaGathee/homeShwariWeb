<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worker_id = $_POST['worker_id'];
    $report_text = $_POST['report_text'];
    // Assuming you have a way to determine the employer, e.g., from session or worker-employer relationship
    $employer_id = null; // or fetch the correct employer ID from another source

    try {
        $stmt = $pdo->prepare("
            INSERT INTO reports (worker_id, employer_id, report_text)
            VALUES (:worker_id, :employer_id, :report_text)
        ");
        $stmt->execute([
            'worker_id' => $worker_id,
            'employer_id' => $employer_id,
            'report_text' => $report_text
        ]);

        // Display success message using JavaScript alert
        echo "<script>alert('Report submitted successfully.');</script>";
    } catch (PDOException $e) {
        // Display error message using JavaScript alert
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
    }
}
