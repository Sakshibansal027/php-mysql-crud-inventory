<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Inventory</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
            display: flex;
            flex-direction: column;
            /* Isse form ke niche table aayegi */
            align-items: center;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 450px;
            margin-bottom: 40px;
         
        }

        h2,
        h3 {
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #4a90e2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #357abd;
        }

        
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 700px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* Borders ko aapas me chipkane ke liye */
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4a90e2;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .btn-edit {
            background-color: #f39c12;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            margin-right: 5px;
            transition: background 0.3s;
        }

        .btn-edit:hover {
            background-color: #d35400;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Add New Product 🛒</h2>
        <form action="add_product.php" method="POST">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="p_name" placeholder="e.g. iPhone 15" required>
            </div>
            <div class="form-group">
                <label>Price (₹)</label>
                <input type="number" step="0.01" name="p_price" placeholder="e.g. 79999" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="p_stock" placeholder="e.g. 15" required>
            </div>
            <button type="submit" name="add_product_btn">Add To Inventory</button>
        </form>
    </div>

    <div class="table-container">
        <h3>Live Shop Inventory 📋</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
              
                include 'connection.php';

                $sql = "SELECT * FROM inventory";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>₹" . $row['price'] . "</td>";
                        echo "<td>" . $row['stock'] . " items</td>";
                      
                        echo "<td>";
                        echo "<a href='edit.php?edit_id=" . $row['id'] . "' class='btn-edit'>Edit</a>";
                        echo "<a href='delete.php?delete_id=" . $row['id'] . "' class='btn-delete'>Delete</a>";
                        echo "</td>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;'>Abhi koi product nahi hai shop me.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<div style="text-align: right; margin-bottom: 20px; margin-top: 20px;">
    <a href="logout.php" style="background-color: #e74c3c; color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 10px;">Logout</a>
</div>
</body>

</html>