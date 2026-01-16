<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: index.php");
    exit();
}


include 'connect.php';

try {
    $user_id = $_SESSION['user_id'];

    // Initialize variables
    $employer = [];
    $skills = [];
    $job_count = [];
    $recommendations_count = [];

    // Fetch employer details
    $stmt = $pdo->prepare("
        SELECT u.name, u.email, pi.phone, pi.address, pi.profile_picture 
        FROM users u 
        LEFT JOIN profile_info pi ON u.user_id = pi.user_id 
        WHERE u.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $user_id]);
    $employer = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch the number of jobs posted
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as job_count 
        FROM job_posts 
        WHERE employer_id = :employer_id
    ");
    $stmt->bindParam(':employer_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $job_count = $stmt->fetchColumn();

    // Fetch the number of recommendations
    $stmt = $pdo->prepare("SELECT COUNT(*) as recommendations_count FROM recommendations WHERE job_post_id IN (SELECT job_post_id FROM job_posts WHERE employer_id = :employer_id)");
    $stmt->bindParam(':employer_id', $user_id);
    $stmt->execute();
    $recommendations_count = $stmt->fetchColumn();

    // Fetch all skills for the select box
	$stmt = $pdo->query("SELECT skill_id, skill_name FROM skills");
	$all_skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	// Fetch skills from the database
	$stmt = $pdo->prepare("
		SELECT s.skill_name, s.skill_description 
		FROM skills s 
		JOIN user_skills us ON s.skill_id = us.skill_id
		WHERE us.user_id = :user_id
	");
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();
	$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Fetch user's current skills
	$stmt = $pdo->prepare("
		SELECT skill_id
		FROM user_skills
		WHERE user_id = :user_id
	");
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();
	$user_skills = $stmt->fetchAll(PDO::FETCH_COLUMN);
	
	// Fetch job posts based on recommendations
    $stmt = $pdo->prepare("
        SELECT jp.job_post_id, jp.job_description, jp.location, jp.salary, jp.created_at, jp.deadline
        FROM job_posts jp
        INNER JOIN recommendations r ON jp.job_post_id = r.job_post_id
        WHERE r.employee_email = :employer_email
    ");
    
	
	$stmt = $pdo->prepare("SELECT user_id, name FROM users WHERE role_id = :role_id");
    $stmt->execute(['role_id' => 1]); // Assuming role_id = 1 is for employers
    $employers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <script src="home.js"></script>
    <title>Home Shwari</title>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Shadows+Into+Light&display=swap" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poiret+One&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Shadows+Into+Light&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&family=Smooch+Sans:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">




    <link rel="stylesheet" href="services.css">
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="welcome.css">
    <link rel="stylesheet" href="snippets.css">
    <link rel="stylesheet" href="topbtn.css">
    <link rel="stylesheet" href="contactBtn.css">
    <link rel="stylesheet" href="theme.css">
	<link rel="stylesheet" href="dashboard.css">

    <script src="topbtn.js"></script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="#home" class="active">Home</a>
  <a href="#services">Services</a>
  <a href="#about">About</a>
  <a href="#contact">Contact</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>


	<div id="about">
	  <article class="resize-font">
		<div class="about-section">
		  <h1>About Us</h1>
		  <p>Home Shwari is dedicated to providing a seamless platform for domestic workers and employers.</p>
		</div>
		
		
	  <div class="about-content">
      <div class="services-info">
      </div>
	  <div/>
	  
	  <h1>Welcome to the Worker Dashboard</h1>
	  <hr>
    <a href="logout.php">Logout</a>





<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Picture and Basic Info -->
            <div class="card">
                <img src="<?php echo isset($employer['profile_picture']) && !empty($employer['profile_picture']) ? htmlspecialchars($employer['profile_picture']) : 'default.png'; ?>" 
                     class="card-img-top img-fluid" alt="Profile Picture">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($employer['name'] ?? 'Unknown'); ?></h5>
                    <p>Email: <?php echo htmlspecialchars($employer['email'] ?? 'Not provided'); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($employer['phone'] ?? 'Not provided'); ?></p>
                    <p>Address: <?php echo htmlspecialchars($employer['address'] ?? 'Not provided'); ?></p>
                </div>
            </div>
        </div>
		<style>
    .card-custom-width {
        width: 120%; /* Adjust this value as needed */
    }
	ol {
    margin: 0;
    padding-left: 20px; /* Adjust as needed */
}
</style>
        <!-- Additional Info -->
		<div class="col-md-8 custom-width">
			<div class="card mb-3 card-custom-width">
				<div class="card-body">
					<h4>Additional Information</h4>
					<p><strong>Number of Jobs Posted:</strong> <?php echo htmlspecialchars($job_count); ?></p>
					<p><strong>Number of Recommendations:</strong> <?php echo htmlspecialchars($recommendations_count); ?></p>
					<hr>
					<h5>Skills</h5>
					<ol>
						<?php if (!empty($skills)): ?>
							<?php foreach ($skills as $skill): ?>
								<li>
									<strong><?php echo htmlspecialchars($skill['skill_name']); ?></strong>: 
									<?php echo htmlspecialchars($skill['skill_description']); ?>
								</li>
							<?php endforeach; ?>
						<?php else: ?>
							<li>No skills listed.</li>
						<?php endif; ?>
					</ol>
					<!-- Button to trigger modal -->
					<button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#editModal">
						Edit Details
					</button>
				</div>
			</div>
		</div>

    </div>
</div

<!-- Edit Details Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form to edit details -->
                <form id="editDetailsForm" method="POST" action="update_details.php">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" value="<?php echo htmlspecialchars($employer['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" value="<?php echo htmlspecialchars($employer['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="phone" value="<?php echo htmlspecialchars($employer['phone']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="address" value="<?php echo htmlspecialchars($employer['address']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="editProfilePicture">Profile Picture URL</label>
                        <input type="text" class="form-control" id="editProfilePicture" name="profile_picture" value="<?php echo htmlspecialchars($employer['profile_picture']); ?>">
                    </div>

                    <div class="form-group">
                        <label>Skills</label>
                        <?php foreach ($all_skills as $skill): ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="skill-<?php echo $skill['skill_id']; ?>" 
                                       name="skills[]" value="<?php echo $skill['skill_id']; ?>"
                                       <?php echo in_array($skill['skill_id'], $user_skills) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="skill-<?php echo $skill['skill_id']; ?>">
                                    <?php echo htmlspecialchars($skill['skill_name']); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .container-fluid .card {
        width: 100%;
        margin: 0;
    }
    .container-fluid .table {
        width: 100%;
    }
</style>
<!-- Job Posts Table -->
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12"> <!-- Full width column -->
            <div class="card">
                <div class="card-header">
                    <h5>Job Posts</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($job_posts)): ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Created At</th>
                                    <th>Deadline</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($job_posts as $job): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($job['job_post_id']); ?></td>
                                        <td><?php echo htmlspecialchars($job['job_description']); ?></td>
                                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                                        <td><?php echo htmlspecialchars($job['salary']); ?></td>
                                        <td><?php echo htmlspecialchars($job['created_at']); ?></td>
                                        <td><?php echo htmlspecialchars($job['deadline']); ?></td>
                                        <td>
                                            <!-- Accept and Reject buttons -->
                                            <form method="POST" action="update_job_status.php">
                                                <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['job_post_id']); ?>">
                                                <button type="submit" name="action" value="accept" class="btn btn-success btn-sm">Accept</button>
                                                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No job posts available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.10/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Submit a Report</h3>
            <form method="POST" action="submit_report.php">
                <!-- Hidden Worker ID -->
                <input type="hidden" name="worker_id" value="<?php echo $_SESSION['user_id']; ?>">

                <!-- Report Text -->
                <div class="form-group">
                    <label for="report_text">Report Text</label>
                    <textarea class="form-control" id="report_text" name="report_text" rows="6" required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block">Submit Report</button>
            </form>
        </div>
    </div>
</div>
	  
	  
	  </article>
	</div>
	  </article>
	</div>



<div id="contact">
  <footer class="footer">
    <div class="footer-content">
        <div style="overflow:auto">
            <div class="right">
              <h2>Overview</h2>
              <li><a href="#home">Home</a></li>
              <li><a href="#services">Services</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </div>
          
            <div class="main">
              <h2>Contact via:</h2>
              <li><a href="http://wa.me/+254714008100" target="_blank" rel="noopener noreferrer" class="fa fa-whatsapp" title="Contact via WhatsApp"></a>
                <a href="http://wa.me/+254714008100" target="_blank" rel="noopener noreferrer" title="Contact via WhatsApp">WhatsApp</a></li>
              <li><a href="mailto:firstnamebasis1st@gmail.com" class="fa fa-google" title="Contact via Email"></a>
                <a href="mailto:firstnamebasis1st@gmail.com" title="Contact via Email">firstnamebasis1st@gmail.com</a></li>
              <li>---</li>
            </div>
            <div class="right">
              <h2>Services</h2>
              <li><a href="#worker-registration">Domestic Worker Registration</a></li>
              <li><a href="#employer-registration">Employer Registration</a></li>
              <li><a href="#service-details">Service Details</a></li>
            </div>
            <div class="far-right">
                <h2>Goals</h2>
                <p>Connecting domestic workers with employers to foster professional and reliable home services.</p>
                <a href="http://wa.me/+254714008100" target="_blank" rel="noopener noreferrer" class="fa fa-whatsapp" title="Contact via WhatsApp"></a>
                <a href="mailto:firstnamebasis1st@gmail.com" class="fa fa-google" title="Contact via Email"></a>
                <a href="#" class="fa fa-instagram"></a>
            </div>
          </div>
    </div>

    <div>
        <hr style="width: 90vw;">
        <p class="name">Copyright &copy; 2024. By Home Shwari</p>
    </div>
  </footer>
</div>



</body>
</html>

