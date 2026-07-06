# 🛒 Mini Product Inventory System (CRUD + Auth)

A secure, lightweight, and complete Full-Stack web application built using PHP, MySQL, HTML, and CSS. This project features a full product inventory management system hidden behind a secure user authentication wall with robust server-side validation.

---

## ✨ Features

### 🔐 User Authentication & Security
* Secure Signup & Login: User registration and authorization powered by PHP Sessions.
* Route Protection: Unauthorized users are strictly blocked from accessing the inventory dashboard or performing any actions via direct URL.
* Password Hashing: Passwords are fully encrypted using PHP's native password_hash() (Bcrypt) before being stored in the database.
* XSS Protection: Input sanitization using htmlspecialchars() to neutralize malicious HTML/JavaScript injection attacks.

### 📦 Inventory Management (CRUD)
* Create: Add new products with automatically sanitized Names, Prices, and Stock levels.
* Read: Display live inventory items in a clean, beautifully styled responsive table.
* Update: Edit product details inline with dynamically pre-filled forms.
* Delete: Safely remove products instantly from the MySQL database.

---

## 🛡️ Architecture & Security Logic Explained

### 1. The Gatekeeper (Route Protection)
Every protected file (like inventory.php) begins with a session check. If $_SESSION['username'] is not set, the execution is instantly terminated via exit() and the user is redirected to the login screen.
* Logout (logout.php): Safely destroys the session using session_unset() and session_destroy(), clearing the server's tracking state completely.

### 2. Server-Side Validation Rules
Instead of directly trusting user inputs, an array named $errors = [] acts as a collector:
* Product Name: Checked via empty() after stripping whitespace with trim().
* Price: Validated via is_numeric() to ensure only digits are processed, strictly enforcing values greater than zero.
* Stock: Checked via filter_var() using FILTER_VALIDATE_INT to guarantee quantities are non-negative whole integers.

---

## 🛠️ How to Setup & Run

Follow these steps to set up the project on your local machine:

### 1. Clone the Repository
Run these commands in your terminal:
git clone https://github.com/Sakshibansal027/php-mysql-crud-inventory.git
cd php-mysql-crud-inventory

### 2. Database Setup
1. Open phpMyAdmin (http://localhost/phpmyadmin).
2. Create a new database named test_db.
3. Import the test_db.sql file provided in this repository to automatically create the required inventory and users tables.

### 3. Connection Configuration
1. Rename connection.example.php to connection.php.
2. Open connection.php and fill in your local MySQL credentials:
$servername = "localhost";
$username = "root";
$password = "YOUR_MYSQL_PASSWORD";
$dbname = "test_db";

### 4. Run Using PHP Built-in Server
Open your VS Code terminal and execute the following command to spin up a lightweight local server:
php -S localhost:3000

Now, open your browser and head to http://localhost:3000/signup.php to create your first account and log into your secure inventory dashboard!
