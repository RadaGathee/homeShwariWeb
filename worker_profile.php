<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

$user_id = $_SESSION['user_id']; // Ensure this is set when the user logs in

// Fetch user information and role
$user_sql = "
    SELECT users.name, users.email, roles.role_name, profile_info.phone, profile_info.address 
    FROM users 
    JOIN roles ON users.role_id = roles.role_id 
    LEFT JOIN profile_info ON users.user_id = profile_info.user_id
    WHERE users.user_id = :user_id";
$stmt = $pdo->prepare($user_sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user skills
$skills_sql = "
    SELECT skills.skill_name, skills.skill_description 
    FROM user_skills 
    JOIN skills ON user_skills.skill_id = skills.skill_id 
    WHERE user_skills.user_id = :user_id";
$stmt = $pdo->prepare($skills_sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <script src="home.js"></script>
    <title>Home Shwari</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
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
		
		
	  <h1>Welcome to the Worker Dashboard</h1>
	  
    <a href="logout.php">Logout</a>
	
	  <div class="about-content">
	  <p>Job Matching Algorithm</p>
      <hr>
      <div class="services-info">
        <li>Utilizing advanced algorithms and machine learning techniques to match employers' requirements with domestic workers' skillsets.</li>
      </div>
	  <div/>
	  
	
	  
	  
    <div class="container mt-5">
        <div class="row">
            <!-- Profile Picture and Info -->
             <!-- Profile Picture and Info -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="https://static.wixstatic.com/media/d05c7d_084c38079e8a43d1b86f3d205c05ff87~mv2.jpeg/v1/crop/x_1783,y_0,w_4386,h_5304/fill/w_538,h_650,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/afro-woman-cleaning-new-home-76GUFAQ-min.jpeg" class="rounded-circle img-fluid" alt="Profile Picture">
                        <h3 class="card-title mt-3"><?php echo htmlspecialchars($user['name']); ?></h3>
                        <p class="text-muted"><?php echo ucfirst(htmlspecialchars($user['role_name'])); ?></p>
                    </div>
                </div>
            </div>
			
            <!-- Profile Information and Skills -->
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4>Profile Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Full Name:</strong> <?php echo $user['name']; ?></p>
                                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
                                <p><strong>Address:</strong> <?php echo $user['address']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Skills Section -->
                <div class="card">
                    <div class="card-body">
                        <h4>Skills</h4>
                        <hr>
                        <ul class="list-group">
                            <?php foreach ($skills as $skill): ?>
                                <li class="list-group-item">
                                    <strong><?php echo htmlspecialchars($skill['skill_name']); ?>:</strong> <?php echo htmlspecialchars($skill['skill_description']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Edit Button -->
                <div class="text-right mt-3">
                    <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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

