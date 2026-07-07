<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'connection.php';

$errors = [];

if (isset($_POST['add_product_btn'])) {

    // 1. Data Sanitization
    $p_name  = trim(htmlspecialchars($_POST['p_name']));
    $p_price = trim($_POST['p_price']);
    $p_stock = trim($_POST['p_stock']);


    $image_name = $_FILES['p_image']['name'];
    $image_tmp = $_FILES['p_image']['tmp_name'];
    $image_size = $_FILES['p_image']['size'];
    $image_error = $_FILES['p_image']['error'];

    $final_image_name = "default.png";

    // 2. Validation Rules 
    if (empty($p_name)) {
        $errors[] = "Product Name is required and cannot be empty.";
    }

    if (!is_numeric($p_price) || $p_price <= 0) {
        $errors[] = "Price must be a valid number greater than zero.";
    }

    if ((!filter_var($p_stock, FILTER_VALIDATE_INT) && $p_stock !== '0') || $p_stock < 0) {
        $errors[] = "Stock quantity must be a non-negative whole number (integer).";
    }

    if ($image_error === 0) {
        $file_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png"];
        
        if (in_array($file_ext, $allowed_extensions)) {
            
            if ($image_size <= 2097152) {
                
                $final_image_name = uniqid('IMG_', true) . "." . $file_ext;
                
                $upload_path = "uploads/" . $final_image_name;
                
                if (!move_uploaded_file($image_tmp, $upload_path)) {
                    $errors[] = "Failed to upload image physically.";
                }
                
            } else {
                $errors[] = "Image size must be less than 2MB.";
            }
        } else {
            $errors[] = "Only JPG, JPEG, and PNG images are allowed.";
        }
    } else if ($image_error !== 4) {

        $errors[] = "Error occurred while uploading the image.";
    }



    if (empty($errors)) {

        $sql = "INSERT INTO inventory (product_name, price, stock, image) VALUES ('$p_name', '$p_price', '$p_stock','$final_image_name')";

        echo "<style>
                body { font-family: sans-serif; background-color: #f4f6f9; padding: 50px; text-align: center; }
                .alert { background: white; padding: 30px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.05); width: 100%; max-width: 450px; }
                h3.success { color: #2ecc71; }
                h3.error { color: #e74c3c; }
                a { color: #4a90e2; text-decoration: none; font-weight: bold; display: inline-block; margin-top: 15px; }
                ul { text-align: left; color: #e74c3c; }
              </style>";

        echo "<div class='alert'>";

        if ($conn->query($sql) === TRUE) {
            echo "<h3 class='success'> Product Successfully Added to Shop!</h3>";
            echo "<p><strong>Product:</strong> $p_name | <strong>Price:</strong> ₹$p_price | <strong>Stock:</strong> $p_stock items</p>";
        } else {
            echo "<h3 class='error'> Database Error:</h3> " . $conn->error;
        }

        echo "<br><a href='inventory.php'>⬅️ Go Back to Inventory</a>";
        echo "</div>";
    } else {
        echo "<style>
                body { font-family: sans-serif; background-color: #f4f6f9; padding: 50px; text-align: center; }
                .alert { background: white; padding: 30px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.05); width: 100%; max-width: 450px; border-top: 5px solid #e74c3c; }
                h3 { color: #e74c3c; margin-top: 0; }
                ul { text-align: left; padding-left: 20px; line-height: 1.6; color: #e74c3c; }
                a { color: #4a90e2; text-decoration: none; font-weight: bold; display: inline-block; margin-top: 15px; }
              </style>";

        echo "<div class='alert'>";
        echo "<h3> Oops! Validation Failed:</h3>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul>";
        echo "<br><a href='inventory.php'>⬅️ Go Back</a>";
        echo "</div>";
    }
}
