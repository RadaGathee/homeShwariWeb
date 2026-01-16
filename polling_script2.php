<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Recommendations</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Job Recommendations</h1>

    <?php
	
    // Database connection
    $servername = "sql107.ezyro.com";
    $username = "ezyro_37204073";
    $password = "a175f662ee";
    $dbname = "ezyro_37204073_domestic";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch job posts with their descriptions
    $jobQuery = "
        SELECT jp.job_post_id, jp.job_description, jp.employer_id
        FROM job_posts jp
    ";
    $jobResult = $conn->query($jobQuery);

    if ($jobResult->num_rows > 0) {
        while ($jobRow = $jobResult->fetch_assoc()) {
            $jobPostId = $jobRow['job_post_id'];
            $jobDescription = $jobRow['job_description'];
            $employerId = $jobRow['employer_id'];

            // Fetch user skills and their descriptions
            $skillsQuery = "
                SELECT us.user_id, s.skill_name, s.skill_description
                FROM user_skills us
                JOIN skills s ON us.skill_id = s.skill_id
                WHERE us.user_id IN (
                    SELECT user_id FROM users WHERE user_id != $employerId
                )
            ";
            $skillsResult = $conn->query($skillsQuery);

            if ($skillsResult->num_rows > 0) {
                while ($skillRow = $skillsResult->fetch_assoc()) {
                    $userId = $skillRow['user_id'];
                    $skillName = $skillRow['skill_name'];
                    $skillDescription = $skillRow['skill_description'];

                    // Check if the job description contains any skill description
                    $containsSkill = stripos($jobDescription, $skillDescription) !== false;
                    
                    // Determine status
                    $status = $containsSkill ? 'accepted' : 'rejected';

                    // Fetch user details
                    $userQuery = "
                        SELECT u.name, u.email, pf.address
                        FROM users u
                        JOIN profile_info pf ON u.user_id = pf.user_id
                        WHERE u.user_id = $userId
                    ";
                    $userResult = $conn->query($userQuery);
                    $userRow = $userResult->fetch_assoc();
                    $employeeName = $userRow['name'];
                    $employeeEmail = $userRow['email'];
                    $employeeAddress = $userRow['address'];

                    // Insert or update recommendation
                    $upsertQuery = "
                        INSERT INTO recommendations (job_post_id, job_description, employee_name, employee_email, employee_address, employee_qualifications, status)
                        VALUES ('$jobPostId', '$jobDescription', '$employeeName', '$employeeEmail', '$employeeAddress', '$skillName', '$status')
                        ON DUPLICATE KEY UPDATE status='$status'
                    ";
                    if ($conn->query($upsertQuery) !== TRUE) {
                        echo '<div class="alert alert-danger" role="alert">
                            Error updating recommendation: ' . $conn->error . '
                        </div>';
                    }
                }
            }
        }

        echo '<div class="alert alert-success" role="alert">
            Recommendations updated successfully.
        </div>';
    } else {
        echo '<div class="alert alert-warning" role="alert">
            No job posts found.
        </div>';
    }

    // Close connection
    $conn->close();
    ?>

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
