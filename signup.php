<?php
include 'connection.php';

$errors = [];
$success_msg = "";

if (isset($_POST['signup_btn'])) {
    // 1. Data Saaf (Sanitize) karna
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim($_POST['password']);

    // 2. Validation Rules
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

 
    if (empty($errors)) {
        $check_user = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($check_user);
        
        if ($result->num_rows > 0) {
            $errors[] = "Username already exists! Choose a different one.";
        }
    }

    if (empty($errors)) {
        // PASSWORD HASHING (Security Guard)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $success_msg = "🎉 Registration successful! <a href='login.php'>Click here to Login</a>";
        } else {
            $errors[] = "Database Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup - Inventory System</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .auth-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 380px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; font-size: 14px; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 14px; }
        .btn { width: 100%; padding: 10px; background: #4a90e2; border: none; color: white; font-weight: bold; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background 0.2s; }
        .btn:hover { background: #357abd; }
        .error-box { background: #fde8e8; color: #e74c3c; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; border-left: 4px solid #e74c3c; }
        .success-box { background: #e8f8f0; color: #2ecc71; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; border-left: 4px solid #2ecc71; text-align: center; }
        ul { margin: 0; padding-left: 20px; }
        p.switch-text { text-align: center; font-size: 14px; color: #777; margin-top: 15px; }
        p.switch-text a { color: #4a90e2; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="auth-container">
    <h2>Create Account</h2>

    <?php if (!empty($success_msg)): ?>
        <div class="success-box"><?php echo $success_msg; ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="signup.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label>Password (Min. 6 chars)</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>
        <button type="submit" name="signup_btn" class="btn">Register</button>
    </form>

    <p class="switch-text">Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>