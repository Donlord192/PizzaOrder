CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

INSERT INTO menu (name, price, image) VALUES
('Гавайская', 10.99, '/pizzaorder/images/hawaiian.jpg'),
('Маргарита', 9.99, '/pizzaorder/images/margarita.jpg'),
('Паперони', 11.99, '/pizzaorder/images/pepperoni.jpg'),
('Вегетарианская', 10.49, '/pizzaorder/images/vegetarian.jpg');