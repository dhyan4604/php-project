<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // If password is entered, update it
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "UPDATE users SET name='$name', email='$email', role='$role', password='$password' WHERE id=$id";
    } else {
        $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="container">
    <h2>Edit User</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        
        <label>Role:</label>
        <select name="role">
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
        </select>

        <label>New Password (optional):</label>
        <input type="password" name="password" placeholder="Leave blank to keep the current password">
        
        <button type="submit" name="update">Update</button>
    </form>
</div>

</body>
</html>
