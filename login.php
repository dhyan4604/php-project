<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Store user session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role']; 
            $_SESSION['email'] = $user['email'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin/admin_home.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "<p class='error'>Invalid password!</p>";
        }
    } else {
        echo "<p class='error'>No user found!</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
   
</head>
<body>

    <div class="container">
    <div class="form-container">
        <h2>Sign In</h2>
     
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Sign In</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
    <div class="text-container">
        <h2>Hello, Friend!</h2>
        <p>Register with your personal details to use all site features.</p>
        <a href="signup.php" class="btn outline">Sign Up</a>
    </div>
</div>
<script src="script.js"></script>

</body>
</html>
