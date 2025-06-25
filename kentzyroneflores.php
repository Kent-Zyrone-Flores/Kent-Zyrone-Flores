<?php
$conn = new mysqli("localhost", "root", "", "visitor_tracker");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$ip = file_get_contents('https://api.ipify.org');
$response = @file_get_contents("https://ipinfo.io/{$ip}/json?token=3e69e72250847f");

if ($response !== false) {
  $details = json_decode($response);

  $city = $details->city ?? 'Unknown';
  $region = $details->region ?? 'Unknown';
  $country = $details->country ?? 'Unknown';
  $isp = $details->org ?? 'Unknown';

  $sql = "INSERT INTO visitors (ip, city, region, country, isp) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $ip, $city, $region, $country, $isp);
  $stmt->execute();
  $stmt->close();
} else {
  error_log("Failed to fetch IP location data from ipinfo.io.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kent Zyrone Flores</title>
  <link rel="icon" href="image/logo.png" type="image/png" sizes="32x32">
</head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="portfolio.css"/>
</head>
<body>
  <canvas id="background"></canvas>
  <nav> 
  <div class="logo">
    <img src="image/logo.png" alt="Zyrone Logo" class="logo-img" />
  </div>
 <div class="nav-links" id="navLinks">
    <a href="#home">Home</a>
     <!--<a href="#about">About</a>
    <a href="#capstone">Capstone</a>
    <a href="#contact">Contact</a>
-->
  </div>
  
</nav>
  <div class="content">
    <section id="home" class="home section fade-in">
      <div class="profile-wrapper">
  <div class="glow-aura"></div>
  <img src="image/profile.png" alt="Kent Zyrone Flores" class="profile-pic" />
</div>

      <div>
        <div>
        <h1><span id="typed-name"></span><span class="cursor">|</span></h1>
        </div>
        <center>
        <p>IT Student | Incoming 4th Year Student <br> Student at <a href="https://tcc.edu.ph/" target="_blank">Tagoloan Community College</a></p>
        <br>
        </center>
        <center><h6>Follow me:</h6></center>
        <div class="social-links">
          <a href="https://github.com/Kent-Zyrone-Flores" target="_blank"><img src="image/github.png" alt="GitHub Logo" style="width: 24px; height: 24px; vertical-align: middle;" /></a>
          <a href="https://www.facebook.com/k.zyroneflores" target="_blank"><img src="image/facebook.png" alt="Facebook Logo" style="width: 24px; height: 24px; vertical-align: middle;" /></a>
          <a href="https://x.com/Zyrn33" target="_blank">
            <img src="image/X.png" alt="X Logo" style="width: 24px; height: 24px; vertical-align: middle;" />
          </a>
          <a href="https://www.instagram.com/zyroneflores" target="_blank"><img src="image/instagram.png" alt="Instagram Logo" style="width: 24px; height: 24px; vertical-align: middle;" /></a>
          <a href="https://discord.com/users/zyrone8829" target="_blank"><img src="image/discord.png" alt="Discord Logo" style="width: 24px; height: 24px; vertical-align: middle;" /></a>
        </div>
      </div>
    </section>
    <!--
    <section id="about" class="about section fade-in">
        <div class="about-box">
          <h2>About Me</h2>
          <p><strong>School:</strong> Tagoloan Community College</p>
          <p><strong>Learned Langauage and Frameworks</strong></p>
          <ul class="skills-list">
            <li>Laravel</li>
            <li>React JS</li>
            <li>PHP</li>
            <li>JavaScript</li>
            <li>CSS</li>
            <li>HTML</li>
          </ul>
        </div>
    </section>

    <section id="capstone" class="capstone section fade-in">
      <h2>Capstone Project:</h2>
      <p><strong>Role:</strong> System Analyst</p>
      <p><strong>Capstone Title:</strong> "Development of Student Tracking Violation System"</p>
  </section>
    <section id="contact" class="contact section fade-in">
      <h2>Contact</h2>
      <p>Email: k.zyroneflores@gmail.com</p>
      <p>Phone: 09093246917</p>
    </section>
  </div>-->
  <footer class="footer">
  <p>&copy; 2025 Kent Zyrone Flores. All rights reserved.</p>
</footer>

</body>
<script src="js/portfolio.js"></script>
</html>

