<?php
session_start();
if ($_GET['logout']==1) {
    session_destroy();
    header("Location: /pizzaorder/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Pizza</title>
    <link rel="icon" href="/pizzaorder/images/pizzaicon.jpg" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Pizza</h1>
    </header>
    <main>
        <section id="menu">
            <?php include 'pizza.php'; ?>
        </section>
        <?php
        if (isset($_SESSION['username'])) {
    echo '<a href="/pizzaorder/pages/user.php" class="login-button">' . $_SESSION['username'] . '</a>';
        } else {
    echo '<a href="/pizzaorder/pages/login.php" class="login-button">Вход</a>';
    }
     ?>
        <section id="cart">
            <h2>Корзина:</h2>
            <button id="checkout-btn">Заказать</button>
            <ul id="cart-items"></ul>
            <div id="order-comment" style="display: none;">
                <label for="comment">Комментарий к заказу:</label>
                <textarea id="comment" placeholder="Введите комментарий"></textarea>
                <button id="add-comment-btn">Добавить комментарий</button>
            </div>
            <p id="total-price">Итого: $0.00</p>
        </section>
    </main>

    <div id="pizza-details-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="pizza-details-content">
                <img id="pizza-details-image" alt="Pizza Image">
                <div id="pizza-details-info">
                    <h2 id="pizza-details-name"></h2>
                    <p id="pizza-details-toppings"></p>
                    <p id="pizza-details-price"></p>
                    <button id="add-to-cart">Добавить в корзину</button>
                </div>
            </div>
        </div>
    </div>    
    <script src="script.js"></script>
</body>
</html>