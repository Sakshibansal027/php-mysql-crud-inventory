<?php
include 'connection.php';

if (isset($_POST['add_product_btn'])) {
    
    $name = $_POST['p_name'];
    $price = $_POST['p_price'];
    $stock = $_POST['p_stock'];
        // SQL Query: inventory table me columns ke hisab se data insert karo
    $sql = "INSERT INTO inventory (product_name, price, stock) VALUES ('$name', '$price', '$stock')";
    
    echo "<style>
            body { font-family: sans-serif; background-color: #f4f6f9; padding: 50px; text-align: center; }
            .alert { background: white; padding: 30px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
            h3 { color: #2ecc71; }
            a { color: #4a90e2; text-decoration: none; font-weight: bold; }
          </style>";
    
    echo "<div class='alert'>";
    if ($conn->query($sql) === TRUE) {
        echo "<h3>🎉 Product Successfully Added to Shop!</h3>";
        echo "<p><strong>Product:</strong> $name | <strong>Price:</strong> ₹$price | <strong>Stock:</strong> $stock items</p>";
    } else {
        echo "<h3 style='color: #e74c3c;'>❌ Error : </h3> " . $conn->error;
    }
    echo "<br><a href='inventory.php'>⬅️ Go Back to Inventory</a>";
    echo "</div>";
}
?>