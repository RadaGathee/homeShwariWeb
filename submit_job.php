<?php
session_start();

// Check if the user is logged in and has the role of an employer (role_id 3)
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: index.php"); // Redirect to the login page or home page
    exit();
}

// Include the database connection file
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $job_description = $_POST['job_description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];

    // Validate and sanitize inputs
    $job_description = htmlspecialchars($job_description);
    $location = htmlspecialchars($location);
    $salary = $salary ? floatval($salary) : null;
    $deadline = $deadline ? date('Y-m-d', strtotime($deadline)) : null;

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO job_posts (employer_id, job_description, location, salary, created_at, deadline) 
                               VALUES (:employer_id, :job_description, :location, :salary, NOW(), :deadline)");

        // Bind parameters
        $stmt->bindParam(':employer_id', $employer_id);
        $stmt->bindParam(':job_description', $job_description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':deadline', $deadline);

        // Get the employer ID from the session
        $employer_id = $_SESSION['user_id'];

        // Execute the statement
        $stmt->execute();

        // Redirect to a success page or display a success message
        echo "Job post saved successfully!";
        // header("Location: success.php"); // Optional: Redirect to a success page
		
		// Run the polling script after successful job submission
        include 'polling_script2.php';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
