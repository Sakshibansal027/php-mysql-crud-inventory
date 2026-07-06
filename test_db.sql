CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(150) NOT NULL,
    price DECIMAL(10, 2) NOT NULL, -- Isme paise points me bhi aa sakte hain (e.g., 99.99)
    stock INT NOT NULL
);


show databases;

SELECT TABLE_SCHEMA 
FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_NAME = 'inventory';
select* from inventory;

delete from inventory where id=3;

select* from inventory;