CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pizza_ids VARCHAR(255) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL
);