document.addEventListener('DOMContentLoaded', function() {
    const pizzas = document.querySelectorAll('.pizza');
    const cartItems = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout-btn');

    pizzas.forEach(function(pizza) {
        pizza.addEventListener('click', function() {
            const pizzaId = pizza.dataset.id;
            const pizzaName = pizza.dataset.name;
            const pizzaPrice = parseFloat(pizza.dataset.price);

            addToCart(pizzaId, pizzaName, pizzaPrice);
        });
    });

    cartItems.addEventListener('click', function(event) {       
        if (event.target.classList.contains('remove-item')) {
            const cartItem = event.target.closest('li');
            const pizzaId = cartItem.dataset.id;
            removeFromCart(pizzaId);
        }
    });

    checkoutButton.addEventListener('click', function() {
        placeOrder();
    });

    function addToCart(id, name, price) {
        const existingCartItem = document.querySelector(`#cart-items li[data-id="${id}"]`);
        const cartTotalPrice = calculateTotalPrice();

        if (existingCartItem) {
            const quantityElement = existingCartItem.querySelector('.quantity');
            const quantity = parseInt(quantityElement.textContent);
            quantityElement.textContent = quantity + 1;
        } else {
            const cartItem = document.createElement('li');
            cartItem.dataset.id = id;
            cartItem.dataset.price = price;

            const pizzaNameElement = document.createElement('span');
            pizzaNameElement.classList.add('pizza-name');
            pizzaNameElement.textContent = name;

            const separatorElement = document.createElement('span');
            separatorElement.classList.add('separator');
            separatorElement.textContent = ' - ';

            cartItem.appendChild(pizzaNameElement);
            cartItem.innerHTML += `<span class="separator"> - </span><span class="quantity">1</span> x $${price.toFixed(2)} 
                <button class="remove-item">Удалить</button>`;

            cartItems.appendChild(cartItem);
        }

        totalPriceElement.textContent = `Итого: $${cartTotalPrice.toFixed(1)}`;

        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.style.backgroundColor = '#FF6347';
            button.style.color = '#fff';
            button.style.border = 'none';
            button.style.padding = '5px 10px';
            button.style.borderRadius = '4px';
            button.style.cursor = 'pointer';
            button.addEventListener('mouseover', () => {
                button.style.backgroundColor = '#FF4500';
            });
            button.addEventListener('mouseout', () => {
                button.style.backgroundColor = '#FF6347';
            });
        });
    }

    function removeFromCart(id) {
        const cartItem = document.querySelector(`#cart-items li[data-id="${id}"]`);
        if (cartItem) {
            const quantity = parseInt(cartItem.querySelector('.quantity').textContent);
            if (quantity > 1) {
                cartItem.querySelector('.quantity').textContent = quantity - 1;
            } else {
                cartItem.remove();
            }

            const cartTotalPrice = calculateTotalPrice();
            totalPriceElement.textContent = `Итого: $${cartTotalPrice.toFixed(1)}`;
        }
    }

    function calculateTotalPrice() {
        const cartItemsList = document.querySelectorAll('#cart-items li');
        let total = 0;

        cartItemsList.forEach(function(cartItem) {
            const quantity = parseInt(cartItem.querySelector('.quantity').textContent);
            const price = parseFloat(cartItem.dataset.price);
            total += quantity * price;
        });

        return total;
    }

    function placeOrder() {
        const cartItemsList = document.querySelectorAll('#cart-items li');
        const orderData = {
            cartItems: [],
            total: calculateTotalPrice()    
        };

        cartItemsList.forEach(function(cartItem) {
            const id = cartItem.dataset.id;
            const quantity = parseInt(cartItem.querySelector('.quantity').textContent);
            orderData.cartItems.push({ id, quantity });
        });

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'place_order.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    alert(response.message);
                    document.getElementById("cart-items").innerHTML = "";                                   
                } else if (response.error) {
                    alert(response.error);
                }
            } else {
                console.error('Ошибка при выполнении запроса на сервер');
            }
        };

        xhr.onerror = function() {
            console.error('Произошла ошибка при выполнении запроса');
        };

        xhr.send(JSON.stringify(orderData));
    }
});