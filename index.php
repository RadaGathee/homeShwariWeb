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
	<link rel="stylesheet" href="container.css">
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

<div id="home">
  <article class="resize-font">
    <div class="welcome-section">
      <h1>Welcome to Home Shwari!</h1>
      <p>Your premier domestic worker service provider.</p>
    </div>
  </article>
</div>

<button onclick="topFunction()" id="myBtn" title="Go to top"><u>Top</u></button>

<article>
  <div class="snippets-content">
    <p>Welcome to Home Shwari, where we connect domestic workers with employers in need of reliable services.</p>
    <hr>
    <div class="services-info">
      <li> <q>Enhancing Your Domestic Worker Experience</q></li>
    </div>
  </div>
</article>

<div id="services">
  <article class="resize-font">
    <div class="services-section">
      <h1>Services</h1>
      <p style="color: rgb(196, 229, 229);">- Offering a range of services to cater to your domestic needs. -</p>
    </div>

    <div class="services-content">
      <div id="worker-registration">
        <p>Domestic Worker Registration</p>
        <hr>
        <div class="services-info">
          <li><b>Description:</b> Register as a domestic worker to connect with employers looking for your skills.</li>
          <p>Fill out the registration form to create a profile and get listed on our platform.</p>
        </div>
      </div>

      <div id="employer-registration">
        <p>Employer Registration</p>
        <hr>
        <div class="services-info">
          <li><b>Description:</b> Register as an employer to find and hire domestic workers that match your needs.</li>
          <p>Create an employer profile to post job listings and connect with potential workers.</p>
        </div>
      </div>

      <div id="service-details">
        <p>Service Details</p>
        <hr>
        <div class="services-info">
          <li><b>Description:</b> Detailed information about the services provided to both workers and employers.</li>
          <p>Learn more about how our platform facilitates the connection between domestic workers and employers.</p>
        </div>
      </div>
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
	 
	  <div class="about-content">
      <p>Optimization</p>
      <hr>
      <div class="services-info">
        <li>Optimizing task assignments by considering factors such as skill compatibility, availability, and preferences. </li>
      </div>
        
		<p>Customization</p>
      <hr>
      <div class="services-info">
        <li>Allowing employers to specify their preferences and priorities, ensuring personalized matches.</li>
      </div>
        
		<p>Reporting Mechanism</p>
      <hr>
      <div class="services-info">
        <li>Providing a secure and confidential channel for domestic workers to report instances of abuse, harassment, or mistreatment.</li>
      </div>
        
		<p>Incident Documentation</p>
      <hr>
      <div class="services-info">
        <li>Capturing detailed information about reported incidents, including date, time, location, and nature of the abuse. </li>
      </div>
        
		<p>Alerts and Notifications</p>
      <hr>
      <div class="services-info">
        <li>Alerting relevant authorities or support services immediately upon receiving a report, ensuring timely intervention.</li>
      </div>
        
		<p>Follow-Up Procedures</p>
      <hr>
      <div class="services-info">
        <li>Implementing procedures for investigating reported incidents, providing support to victims, and taking appropriate actions against perpetrators. </li>
      </div>
	  
	  <h2>Login</h2>
    <form action="login_action.php" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
        
		
		<style>
		/* Style for input fields */
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Style for submit button */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
		/* Ensure footer is cleared */
        footer {
            clear: both;
		
		<style/>
		<p>Life<p/>



		
    </div>
	  <div/>
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
