<!DOCTYPE html>
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
	  <p>Job Matching Algorithm</p>
      <hr>
      <div class="services-info">
        <li>Utilizing advanced algorithms and machine learning techniques to match employers' requirements with domestic workers' skillsets.</li>
      </div>
	  <div/>
	 
		
		<div class="container">
        <h2>Register</h2>
        <form action="register_action.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role_id" required>
                <?php
                require 'connect.php';
                $stmt = $pdo->query("SELECT * FROM roles");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['role_id']}'>{$row['role_name']}</option>";
                }
                ?>
            </select>
            
            <button type="submit">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
		<style>
		/* General input field styling */
.container input[type="text"],
.container input[type="email"],
.container input[type="password"],
.container select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box; /* Ensures padding is included in width */
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Focus state for input fields */
.container input[type="text"]:focus,
.container input[type="email"]:focus,
.container input[type="password"]:focus,
.container select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(38, 143, 255, 0.2);
    outline: none;
}

/* Button styling */
.container button {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

/* Button hover state */
.container button:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

<style/>
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
