<?php

session_start();
include 'connection.php';

$errors = [];

if (isset($_POST['login_btn'])) {
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $errors[] = "Both fields are required.";
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          
            $user_data = $result->fetch_assoc();
            
        
            if (password_verify($password, $user_data['password'])) {
                
               
                $_SESSION['username'] = $user_data['username'];
                
                header("Location: inventory.php");
                exit();

            } else {
                $errors[] = "Invalid password! Please try again.";
            }
        } else {
            $errors[] = "No account found with that username.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventory System</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .auth-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 380px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; font-size: 14px; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 14px; }
        .btn { width: 100%; padding: 10px; background: #2ecc71; border: none; color: white; font-weight: bold; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background 0.2s; }
        .btn:hover { background: #27ae60; }
        .error-box { background: #fde8e8; color: #e74c3c; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; border-left: 4px solid #e74c3c; }
        ul { margin: 0; padding-left: 20px; }
        p.switch-text { text-align: center; font-size: 14px; color: #777; margin-top: 15px; }
        p.switch-text a { color: #2ecc71; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="auth-container">
    <h2>User Login</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" name="login_btn" class="btn">Login</button>
    </form>

    <p class="switch-text">Don't have an account? <a href="signup.php">Signup here</a></p>
</div>

</body>
</html>