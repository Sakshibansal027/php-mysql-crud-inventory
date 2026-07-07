# 🛒 Mini Product Inventory System (CRUD + Auth + Image Upload)

A secure, lightweight, and complete **Full-Stack web application** built using **PHP, MySQL, Bootstrap 5, and FontAwesome**. This project features a full product inventory management system hidden behind a secure user authentication wall with robust server-side validation, advanced image uploading logic, and a modern responsive dashboard layout.

---

## ✨ Features

### 🔐 User Authentication & Security

* **Secure Signup & Login:** User registration and authorization powered by PHP Sessions.
* **Route Protection:** Unauthorized users are blocked from accessing protected routes like the inventory dashboard.
* **XSS Protection:** Input sanitization using `htmlspecialchars()` to prevent malicious script injection.

---

### 📦 Inventory Management (CRUD)

* **Create:** Add new products with validated Name, Price, and Stock.
* **Read:** View products in a responsive dashboard table with hover effects.
* **Update:** Edit products with pre-filled forms and existing image previews.
* **Delete:** Remove products with JavaScript confirmation prompts.

---

### 📷 Advanced Image Uploading Logic

* **Unique Image Naming:** Uses `uniqid('IMG_', true)` to prevent filename conflicts.
* **File Validation:** Accepts only `jpg`, `jpeg`, `png` files under 2MB.
* **Auto Cleanup:** Deletes old images using `unlink()` when updated.
* **Default Image Handling:** Ensures `default.png` is never deleted accidentally.

---

### 🎨 UI/UX (Bootstrap 5)

* Fully responsive layout (Form + Table split view)
* Dynamic stock badges:

  * 🔴 Out of Stock
  * 🟡 Low Stock
  * 🟢 Available
* FontAwesome icons for better visuals

---

## 🛡️ Architecture & Security Logic

### 1. Route Protection (Gatekeeper)

* Every protected page checks:

  ```php
  if (!isset($_SESSION['username'])) {
      header("Location: login.php");
      exit();
  }
  ```
* **Logout (`logout.php`)** clears session using:

  ```php
  session_unset();
  session_destroy();
  ```

---

### 2. File Upload Logic (`$_FILES` Handling)

* **Case A (New Image Uploaded):**

  * Validate file
  * Rename with `uniqid`
  * Move to `/uploads`
  * Delete old image

* **Case B (No Image Selected):**

  * Uses hidden input:

    ```html
    <input type="hidden" name="old_image">
    ```
  * Keeps existing image unchanged

---

### 3. Server-Side Validation

```php
$errors = [];
```

* **Product Name:** `trim()` + `empty()`
* **Price:** `is_numeric()` and > 0
* **Stock:** `filter_var(..., FILTER_VALIDATE_INT)`

---

## 🛠️ Setup & Installation

### 1. Clone Repository

```bash
git clone https://github.com/Sakshibansal027/php-mysql-crud-inventory.git
cd php-mysql-crud-inventory
```

---

### 2. Database Setup

* Open: http://localhost/phpmyadmin
* Create database: `test_db`
* Import: `test_db.sql`

> ⚠️ Make sure `inventory` table has an `image` column (VARCHAR(255))

---

### 3. Configure Database Connection

Rename:

```
connection.example.php → connection.php
```

Update credentials:

```php
$servername = "localhost";
$username = "root";
$password = "YOUR_MYSQL_PASSWORD";
$dbname = "test_db";
```

---

### 4. Create Uploads Folder

* Create folder: `/uploads`
* Add: `default.png`
* Ensure write permissions are enabled

---

### 5. Run Project

```bash
php -S localhost:3000
```

Open in browser:

```
http://localhost:3000/login.php
```

---

## 🚀 Final Result

You now have a fully functional:

* Secure login system 🔐
* CRUD inventory dashboard 📦
* Image upload system 📷
* Clean responsive UI 🎨

---

## 📌 Tech Stack

* PHP
* MySQL
* Bootstrap 5
* FontAwesome

---

## 💡 Author

**Sakshi Bansal**
