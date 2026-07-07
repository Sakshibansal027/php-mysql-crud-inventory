<?php
session_start();
// Security Check
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); 
}

include 'connection.php';

$errors = [];

if (isset($_GET['edit_id'])) {
    $product_id = $_GET['edit_id']; 
    $sql = "SELECT * FROM inventory WHERE id = $product_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $old_name = $row['product_name'];
        $old_price = $row['price'];
        $old_stock = $row['stock'];
    } else {
        header("Location: inventory.php");
        exit();
    }
}

if (isset($_POST['update_product_btn'])) {
    $product_id = $_GET['edit_id']; 
    $product_name = trim(htmlspecialchars($_POST['p_name']));
    $price = trim($_POST['p_price']);
    $stock = trim($_POST['p_stock']);
    $old_image = $_POST['old_image']; 
    
    $final_image_name = $old_image; 

    $image_name = $_FILES['p_image']['name'];
    $image_tmp = $_FILES['p_image']['tmp_name'];
    $image_error = $_FILES['p_image']['error'];
    $image_size = $_FILES['p_image']['size'];

    // Validations
    if (empty($product_name)) { $errors[] = "Name cannot be empty."; }
    if (!is_numeric($price) || $price <= 0) { $errors[] = "Invalid price."; }
    if (filter_var($stock, FILTER_VALIDATE_INT) === false || $stock < 0) { $errors[] = "Invalid stock."; }

    if ($image_error === 0) { 
        $file_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png"];
        
        if (in_array($file_ext, $allowed_extensions)) {
            if ($image_size <= 2097152) {
                
                $final_image_name = uniqid('IMG_', true) . "." . $file_ext;
                $upload_path = "uploads/" . $final_image_name;
                
                if (move_uploaded_file($image_tmp, $upload_path)) {
                    if ($old_image !== 'default.png' && file_exists("uploads/" . $old_image)) {
                        unlink("uploads/" . $old_image); 
                    }
                } else {
                    $errors[] = "Failed to upload new image physically.";
                }
            } else {
                $errors[] = "New image size must be less than 2MB.";
            }
        } else {
            $errors[] = "Only JPG, JPEG, and PNG are allowed.";
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE inventory SET product_name = '$product_name', price = '$price', stock = '$stock', image = '$final_image_name' WHERE id = '$product_id'";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: inventory.php");
            exit();
        } else {
            $errors[] = "Database Update Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger shadow-sm rounded-3 mb-3" role="alert">
                    <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Fix the following errors:</strong>
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error) { echo "<li>" . htmlspecialchars($error) . "</li>"; } ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-dark text-center mb-4">
                        <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Product Details
                    </h4>
                    <hr class="text-muted">
                    
                    <form action="edit.php?edit_id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($row['image']); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Product Name</label>
                            <input type="text" name="p_name" class="form-control rounded-3" value="<?php echo htmlspecialchars($old_name); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Price (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">₹</span>
                                <input type="number" step="0.01" name="p_price" class="form-control rounded-end-3" value="<?php echo $old_price; ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Stock Quantity</label>
                            <input type="number" name="p_stock" class="form-control rounded-3" value="<?php echo $old_stock; ?>" required>
                        </div>
                         
                        <div class="mb-4 card p-3 bg-light border-0 rounded-3 text-center">
                            <label class="form-label fw-semibold text-secondary d-block text-start">Current Product Image</label>
                            <div class="mb-3">
                                <img src="uploads/<?php echo !empty($row['image']) ? $row['image'] : 'default.png'; ?>" width="90" height="90" class="rounded-3 shadow-sm border border-2 border-white style='object-fit: cover;'">
                            </div>
                            
                            <label class="form-label fw-semibold text-secondary text-start d-block">Choose New Image (Optional)</label>
                            <input type="file" name="p_image" class="form-control rounded-3" accept="image/*">
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <a href="inventory.php" class="btn btn-light w-100 rounded-3 fw-bold border text-secondary"><i class="fa-solid fa-xmark me-1"></i> Cancel</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" name="update_product_btn" class="btn btn-warning text-white w-100 rounded-3 fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Save Changes</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>