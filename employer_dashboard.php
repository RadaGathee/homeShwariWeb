<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: index.php");
    exit();
}

// Include the database connection file
include 'connect.php';

try {
    $user_id = $_SESSION['user_id'];
	
	// Initialize variables
    $employer = [];
    $job_posts = []; 
	$recommendations = [];

    // Query to fetch employer details including profile_picture
$stmt = $pdo->prepare("
    SELECT u.name, u.email, pi.phone, pi.address, pi.profile_picture 
    FROM users u 
    LEFT JOIN profile_info pi ON u.user_id = pi.user_id 
    WHERE u.user_id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$employer = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch the number of jobs posted by the employer
    $stmt = $pdo->prepare("SELECT COUNT(*) as job_count FROM job_posts WHERE employer_id = :employer_id");
    $stmt->bindParam(':employer_id', $user_id);
    $stmt->execute();
    $job_count = $stmt->fetchColumn();
	
	// Fetch the job posts data
    $stmt = $pdo->prepare("
        SELECT job_post_id, job_description, location, salary, created_at, deadline 
        FROM job_posts 
        WHERE employer_id = :employer_id
    ");
    $stmt->bindParam(':employer_id', $user_id);
    $stmt->execute();
    $job_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt = $pdo->prepare("
        SELECT r.recommendation_id, r.job_post_id, r.job_description, r.employee_name, r.employee_email, r.employee_address, r.employee_qualifications, r.status
        FROM recommendations r
        LEFT JOIN job_posts jp ON r.job_post_id = jp.job_post_id
        WHERE jp.employer_id = :employer_id
    ");
    $stmt->bindParam(':employer_id', $user_id);
    $stmt->execute();
    $recommendations = $stmt->fetchAll(PDO::FETCH_ASSOC);
	

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
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">




    <link rel="stylesheet" href="services.css">
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="welcome.css">
    <link rel="stylesheet" href="snippets.css">
    <link rel="stylesheet" href="topbtn.css">
    <link rel="stylesheet" href="contactBtn.css">
    <link rel="stylesheet" href="theme.css">
    <script src="topbtn.js"></script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="index.php" class="active">Home</a>
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
	  
	  <h1>Welcome to the Employer Dashboard</h1>
	  <hr>
    <a href="logout.php">Logout</a>
	
	
	
	
	
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Picture -->
            <div class="card">
                <img src="<?php echo $employer['profile_picture'] ? $employer['profile_picture'] : 'default.png'; ?>" 
                     class="card-img-top img-fluid" alt="Profile Picture">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($employer['name']); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Employer Details -->
            <div class="card">
                <div class="card-body">
                    <h4>Welcome, <?php echo htmlspecialchars($employer['name'] ?? 'Unknown'); ?></h4>
                    <p>Email: <?php echo htmlspecialchars($employer['email'] ?? 'Not provided'); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($employer['phone'] ?? 'Not provided'); ?></p>
                    <p>Address: <?php echo htmlspecialchars($employer['address'] ?? 'Not provided'); ?></p>
                    <hr>
                    <h5>You have posted <?php echo $job_count ?? 0; ?> job(s).</h5>
					<!-- Button to trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
                        Edit Profile
                    </button>
						
                </div>
            </div>
        </div>
		
    </div>
	
	<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <!-- Job Posts Table -->
            <div class="card">
                <div class="card-body">
                    <h4>Job Posts</h4>
                    <table class="table table-bordered">
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
                            <?php if (!empty($job_posts)): ?>
                                <?php foreach ($job_posts as $job): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($job['job_post_id']); ?></td>
                                        <td><?php echo htmlspecialchars($job['job_description']); ?></td>
                                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                                        <td><?php echo htmlspecialchars($job['salary']); ?></td>
                                        <td><?php echo htmlspecialchars($job['created_at']); ?></td>
                                        <td><?php echo htmlspecialchars($job['deadline']); ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editJobModal" data-job-id="<?php echo $job['job_post_id']; ?>">Edit</button>
                                            <a href="delete_job.php?job_id=<?php echo $job['job_post_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No jobs posted.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJobModalLabel">Edit Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editJobForm" method="post" action="update_job.php">
                    <input type="hidden" name="job_post_id" id="job_post_id">
                    <div class="mb-3">
                        <label for="job_description" class="form-label">Description</label>
                        <textarea class="form-control" id="job_description" name="job_description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" step="0.01" class="form-control" id="salary" name="salary">
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
			<script>
document.addEventListener('DOMContentLoaded', function () {
    var editJobModal = document.getElementById('editJobModal');

    editJobModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var jobId = button.getAttribute('data-job-id'); // Extract info from data-* attributes

        var form = editJobModal.querySelector('#editJobForm');

        // Clear previous data
        form.reset();

        // Fetch job details using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_job_details.php?job_post_id=' + jobId, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var job = JSON.parse(xhr.responseText);
                if (job) {
                    form.querySelector('#job_post_id').value = job.job_post_id;
                    form.querySelector('#job_description').value = job.job_description;
                    form.querySelector('#location').value = job.location;
                    form.querySelector('#salary').value = job.salary;
                    form.querySelector('#deadline').value = job.deadline;
                } else {
                    console.error('Failed to load job details.');
                }
            } else {
                console.error('Error fetching job details.');
            }
        };
        xhr.send();
    });
});
</script>

        </div>
    </div>
</div>


<div class="container mt-5">
    <h2>Job Recommendations</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Job Description</th>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Employee Address</th>
                <th>Employee Qualifications</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($recommendations)): ?>
                <tr>
                    <td colspan="7" class="text-center">No recommendations available at this time.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($recommendations as $recommendation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($recommendation['recommendation_id']); ?></td>
                        <td><?php echo htmlspecialchars($recommendation['job_description']); ?></td>
                        <td><?php echo htmlspecialchars($recommendation['employee_name']); ?></td>
                        <td><?php echo htmlspecialchars($recommendation['employee_email']); ?></td>
                        <td><?php echo htmlspecialchars($recommendation['employee_address']); ?></td>
                        <td><?php echo htmlspecialchars($recommendation['employee_qualifications']); ?></td>
                        <td>
                            <?php if ($recommendation['status'] === NULL): ?>
                                <button type="button" class="btn btn-primary action-button" data-recommendation-id="<?php echo htmlspecialchars($recommendation['recommendation_id']); ?>" data-toggle="modal" data-target="#actionModal">Action</button>
                            <?php else: ?>
                                <span class="badge badge-<?php echo $recommendation['status'] === 'accepted' ? 'success' : 'danger'; ?>">
                                    <?php echo ucfirst(htmlspecialchars($recommendation['status'])); ?>
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- Modal for Accept/Reject Actions -->
<div class="modal fade" id="recommendationModal" tabindex="-1" role="dialog" aria-labelledby="recommendationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recommendationModalLabel">Update Recommendation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="recommendationForm">
                    <input type="hidden" id="recommendation_id" name="recommendation_id">
                    <div class="form-group">
                        <label for="recommendation_action">Action</label>
                        <select class="form-control" id="recommendation_action" name="action">
                            <option value="accept">Accept</option>
                            <option value="reject">Reject</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
			<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to show the modal
    function showModal(recommendationId) {
        // Set the recommendation ID in the hidden input field
        document.getElementById('recommendation_id').value = recommendationId;

        // Show the modal
        $('#recommendationModal').modal('show');
    }

    // Attach click event listeners to the action buttons
    document.querySelectorAll('.action-button').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var recommendationId = this.dataset.recommendationId;
            showModal(recommendationId);
        });
    });

    // Handle form submission via AJAX
    document.getElementById('recommendationForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('handle_recommendation.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close the modal
                $('#recommendationModal').modal('hide');
                
                // Optionally, refresh the recommendations table or show a success message
                location.reload(); // or update table dynamically
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>

        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form to edit profile details -->
                <form action="update_profile.php" method="POST">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($employer['phone'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($employer['address'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture URL</label>
                        <input type="text" class="form-control" id="profile_picture" name="profile_picture" value="<?php echo htmlspecialchars($employer['profile_picture'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


	 
		

	   <div class="container mt-5">
        <h2 class="mb-4">Create a New Job Post</h2>
        <form action="submit_job.php" method="POST">
            <div class="mb-3">
                <label for="job_description" class="form-label">Job Description</label>
                <textarea class="form-control" id="job_description" name="job_description" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Enter job location">
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" step="1000.00" class="form-control" id="salary" name="salary" placeholder="Enter salary offered">
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Application Deadline.</label>
                <input type="date" class="form-control" id="deadline" name="deadline">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	  
	  
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

