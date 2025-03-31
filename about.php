<?php
session_start();
include 'nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="index.css"> 
    <link rel="stylesheet" href="about.css"> 
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <section class="about-header">
        <h1>About Us</h1>
        <p>Empowering businesses and individuals with innovative solutions.</p>
    </section>

    <section class="about-content">
        <div class="about-text">
            <h2>Who We Are</h2>
            <p>We are a dedicated team committed to providing high-quality products and services. Our goal is to innovate and elevate the experience for our customers.</p>

            <h2>Our Vision</h2>
            <p>To be a leader in our industry by setting new standards of excellence through innovation and passion.</p>
        </div>
        <div class="about-image">
            <img src="https://www.lighthouseinfoserv.com/wp-content/uploads/2018/05/documents-bg.jpg" alt="About Us">
        </div>
    </section>

    <section class="team-section">
        <h2>Meet Our Team</h2>
        <div class="team-container">
            <div class="team-member">
                <img src="assets/team1.jpg" alt="John Doe">
                <h3>John Doe</h3>
                <p>CEO & Founder</p>
            </div>
            <div class="team-member">
                <img src="assets/team2.jpg" alt="Jane Smith">
                <h3>Jane Smith</h3>
                <p>Lead Developer</p>
            </div>
            <div class="team-member">
                <img src="assets/team3.jpg" alt="Mike Johnson">
                <h3>Mike Johnson</h3>
                <p>Project Manager</p>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>

</body>
</html>
