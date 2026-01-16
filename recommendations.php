<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendations</title>
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
    $servername = "localhost";
    $username = "root";
    $password = "Ant1mama";
    $dbname = "augworkerdb1";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch recommendations data
    $query = "SELECT * FROM recommendations";
    $result = $conn->query($query);

    // Check if there are any results
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Recommendation ID</th>
                    <th>Job Post ID</th>
                    <th>Job Description</th>
                    <th>Employee Name</th>
                    <th>Employee Email</th>
                    <th>Employee Address</th>
                    <th>Employee Qualifications</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

        // Loop through each row in the recommendations table
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $row['recommendation_id'] . '</td>
                <td>' . $row['job_post_id'] . '</td>
                <td>' . htmlspecialchars($row['job_description']) . '</td>
                <td>' . htmlspecialchars($row['employee_name']) . '</td>
                <td>' . htmlspecialchars($row['employee_email']) . '</td>
                <td>' . htmlspecialchars($row['employee_address']) . '</td>
                <td>' . htmlspecialchars($row['employee_qualifications']) . '</td>
                <td>' . ucfirst($row['status']) . '</td>
            </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-warning" role="alert">
            No recommendations found.
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
