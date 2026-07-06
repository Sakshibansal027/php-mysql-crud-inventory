# 🛒 Mini Product Inventory System (CRUD)

A lightweight and complete CRUD web application built using **PHP, MySQL, HTML, and CSS**.

## ✨ Features
- **Create:** Add new products with Name, Price, and Stock.
- **Read:** Display live products in a beautiful styled table.
- **Update:** Edit product details inline with pre-filled forms.
- **Delete:** Remove products instantly from the database.
 ### Form Validation & Security Logic Explained

1. **Data Sanitization:**
   - Used `trim()` to remove any accidental or intentional leading/trailing whitespaces from inputs.
   - Applied `htmlspecialchars()` on the product name field to prevent XSS (Cross-Site Scripting) attacks by converting special characters (like `<` or `>`) into safe HTML entities.

2. **Server-Side Validation Rules:**
   - **Product Name:** Checked via `empty()` to ensure the user does not submit blank data.
   - **Price:** Validated using `is_numeric()` to ensure only digits are entered, and restricted values to be strictly greater than zero.
   - **Stock:** Validated using `filter_var()` with `FILTER_VALIDATE_INT` to guarantee that inventory counts are whole numbers (integers) and cannot be negative values.

3. **Conditional Execution Flow:**
   - An empty `$errors` array acts as a green signal. The `INSERT` SQL query executes only when all validation checks pass.
   - If any rule is violated, the database operation is blocked, and the script dynamically renders a clean UI error summary listing all validation failures using a `foreach` loop.

## 🛠️ How to Setup
1. Clone this repository.
2. Import `test_db.sql` into your MySQL server.
3. Rename `connection.example.php` to `connection.php` and add your MySQL password.
4. Run using PHP builtin server: `php -S localhost:8000`
