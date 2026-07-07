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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .product-img:hover {
            transform: scale(1.2); 
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-boxes-stacked me-2"></i>IMS DASHBOARD</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-white-50 me-3"><i class="fa-regular fa-user me-1"></i> Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <a href="logout.php" class="btn btn-sm btn-danger fw-bold rounded-pill px-3"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row g-4">
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3"><i class="fa-solid fa-cart-plus text-primary me-2"></i>Add New Product</h5>
                    <hr class="text-muted">
                    
                    <form action="add_product.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Product Name</label>
                            <input type="text" name="p_name" class="form-control rounded-3" placeholder="e.g. iPhone 15" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Price (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">₹</span>
                                <input type="number" step="0.01" name="p_price" class="form-control rounded-end-3" placeholder="e.g. 79999" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Stock Quantity</label>
                            <input type="number" name="p_stock" class="form-control rounded-3" placeholder="e.g. 15" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Product Image</label>
                            <input type="file" name="p_image" class="form-control rounded-3" accept="image/*" required>
                        </div>
                        <button type="submit" name="add_product_btn" class="btn btn-primary w-100 rounded-3 fw-bold"><i class="fa-solid fa-plus me-1"></i> Add To Inventory</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3"><i class="fa-solid fa-list-check text-success me-2"></i>Live Shop Inventory</h5>
                    <hr class="text-muted">
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 8%;">ID</th>
                                    <th scope="col" style="width: 15%;">Image</th>
                                    <th scope="col" style="width: 35%;">Product Name</th>
                                    <th scope="col" style="width: 17%;">Price</th>
                                    <th scope="col" style="width: 15%;">Stock</th>
                                    <th scope="col" style="width: 10%; text-align: center;">Actions</th>
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
                                        echo "<td class='fw-bold text-secondary'>#" . $row['id'] . "</td>";
                                        
                                        $img_name = !empty($row['image']) ? $row['image'] : 'default.png';
                                        echo "<td><img src='uploads/" . $img_name . "' alt='Product' class='product-img border shadow-sm'></td>";
                                        
                                        echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($row['product_name']) . "</td>";
                                        echo "<td class='text-primary fw-bold'>₹" . number_format($row['price'], 2) . "</td>";
                                        
                                       
                                        $stock = $row['stock'];
                                        if($stock == 0) {
                                            echo "<td><span class='badge bg-danger rounded-pill'>Out of Stock</span></td>";
                                        } else if($stock <= 5) {
                                            echo "<td><span class='badge bg-warning text-dark rounded-pill'>" . $stock . " Low Stock</span></td>";
                                        } else {
                                            echo "<td><span class='badge bg-success rounded-pill'>" . $stock . " Available</span></td>";
                                        }
                                      
                                        echo "<td style='white-space: nowrap; text-align: center;'>";
                                        echo "<a href='edit.php?edit_id=" . $row['id'] . "' class='btn btn-sm btn-outline-warning me-1' title='Edit'><i class='fa-solid fa-pen'></i></a>";
                                        echo "<a href='delete.php?delete_id=" . $row['id'] . "' class='btn btn-sm btn-outline-danger' title='Delete' onclick='return confirm(\"Are you sure you want to delete this?\")'><i class='fa-solid fa-trash'></i></a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>No Products Found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

    </div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>