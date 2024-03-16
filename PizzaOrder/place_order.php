<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $json_data = file_get_contents("php://input");

    $order_data = json_decode($json_data, true);

    if ($order_data !== null) {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pizzaorder";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $cart_items = $order_data['cartItems'];
        $total_price = $order_data['total'];

        $pizza_ids = implode(',', array_column($cart_items, 'id'));

        $sql = "INSERT INTO orders (pizza_ids, total_price) VALUES ('$pizza_ids', $total_price)";
        if ($conn->query($sql) === TRUE) {
            $response = array('success' => true, 'message' => 'Ваш заказ оформен успешно!');            
            echo json_encode($response);
           
        } else {
            $response = array('error' => 'Ошибка при заказе!');
            echo json_encode($response);
        }

        $conn->close();

    } else {
        $response = array('error' => 'Invalid JSON data');
        echo json_encode($response);
    }

} else {
    $response = array('error' => 'Invalid request method');
    echo json_encode($response);
}

?>
