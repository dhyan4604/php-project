<?php
include 'db.php';

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'user'; 

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        header("Location: signup.php?success=1"); // Redirect with success flag
        exit();
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        .message-container {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Create Account</h2>
        <div class="social-icons">
            <button class="social-btn">f</button>
            <button class="social-btn">G</button>
            <button class="social-btn">in</button>
            <button class="social-btn">P</button>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="message-container">
                <p>Signup successful! <a href='login.php'>Login here</a></p>
            </div>
        <?php endif; ?>

        <form action="signup.php" method="POST">
            <input type="text" name="name" required placeholder="Full Name">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Sign In</a></p>
    </div>
    <div class="text-container">
        <h2>Welcome Back!</h2>
        <p>To keep connected with us, please login with your personal info.</p>
        <a href="login.php" class="btn outline">Login</a>
    </div>
</div>
<script src="script.js"></script>

</body>
</html>
