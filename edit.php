<?php
include 'connection.php';


if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM inventory WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $old_name = $row['product_name'];
        $old_price = $row['price'];
        $old_stock = $row['stock'];
    }
}


if (isset($_POST['update_product_btn'])) {
    $p_id = $_POST['p_id'];
    $new_name = $_POST['p_name'];
    $new_price = $_POST['p_price'];
    $new_stock = $_POST['p_stock'];
    
    $update_sql = "UPDATE inventory SET product_name='$new_name', price='$new_price', stock='$new_stock' WHERE id=$p_id";
    
    if ($conn->query($update_sql) === TRUE) {
        
        header("Location: inventory.php");
        exit();
    } else {
        echo "Update karne me error aaya: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; padding: 40px; display: flex; justify-content: center; }
        .form-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 450px; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: 500; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; background-color: #2ecc71; color: white; padding: 12px; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #27ae60; }
        .cancel-link { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Product Details ✏️</h2>
    
    <form action="edit.php" method="POST">
        
        <input type="hidden" name="p_id" value="<?php echo $id; ?>">

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="p_name" value="<?php echo $old_name; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Price (₹)</label>
            <input type="number" step="0.01" name="p_price" value="<?php echo $old_price; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="p_stock" value="<?php echo $old_stock; ?>" required>
        </div>
        
        <button type="submit" name="update_product_btn">Save Changes</button>
        <a href="inventory.php" class="cancel-link">Cancel</a>
    </form>
</div>

</body>
</html>