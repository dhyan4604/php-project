<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VogueVista</title>
    <style>
/* Footer Styling */
footer {
    background: #111;
    color: #fff;
    padding: 50px 20px;
    text-align: center;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-container div {
    flex: 1;
    padding: 15px;
    min-width: 220px;
}

.footer-logo h2 {
    font-size: 26px;
    color: #d63384;
}

.footer-logo p {
    font-size: 14px;
    margin-top: 8px;
    opacity: 0.8;
}

.footer-links h3,
.footer-contact h3,
.footer-social h3 {
    font-size: 18px;
    margin-bottom: 15px;
    color: #d63384;
}

.footer-links ul {
    list-style: none;
    padding: 0;
}

.footer-links ul li {
    margin-bottom: 8px;
}

.footer-links ul li a {
    text-decoration: none;
    color: #fff;
    font-size: 14px;
    opacity: 0.8;
}

.footer-links ul li a:hover {
    opacity: 1;
    color: #d63384;
}

.footer-contact p {
    font-size: 14px;
    opacity: 0.8;
    margin-bottom: 6px;
}

.footer-social .social-icons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.footer-social .social-icons a {
    text-decoration: none;
    font-size: 18px;
    color: white;
    transition: 0.3s;
}

.footer-social .social-icons a:hover {
    color: #d63384;
    transform: scale(1.1);
}

.footer-bottom {
    margin-top: 20px;
    font-size: 14px;
    opacity: 0.6;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 10px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
<footer>
    <div class="footer-container">
        <div class="footer-logo">
            <h2>VogueVista</h2>
            <p>Style that speaks. Shop the latest trends with us.</p>
        </div>
        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h3>Contact Us</h3>
            <p>Email: support@voguevista.com</p>
            <p>Phone: +123 456 7890</p>
            <p>Address: 123 Fashion St, New York, NY</p>
        </div>
        <div class="footer-social">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="https://www.facebook.com/share/1CkejhfF3U/?mibextid=wwXIfr"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/dhyan_4604?igsh=Yzk0cm9pdnAxaWE4&utm_source=qr"><i class="fab fa-instagram"></i></a>
                <a href="https://github.com/dhyan4604"><i class="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/dhyan-desai-15699a28b/"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>
    <p class="footer-bottom">&copy; 2025 VogueVista. All rights reserved.</p>
</footer>

</body>
</html>