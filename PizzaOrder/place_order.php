<?php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the raw JSON data from the request body
    $json_data = file_get_contents("php://input");

    // Decode the JSON data
    $order_data = json_decode($json_data, true);

    // Check if the JSON decoding was successful
    if ($order_data !== null) {

        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pizzaorder";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Process the order data
        $cart_items = $order_data['cartItems'];
        $total_price = $order_data['total'];

        // Prepare pizza IDs as a comma-separated string
        $pizza_ids = implode(',', array_column($cart_items, 'id'));

        // Insert the order into the database
        $sql = "INSERT INTO orders (pizza_ids, total_price) VALUES ('$pizza_ids', $total_price)";
        if ($conn->query($sql) === TRUE) {
            // Order successfully inserted
            $response = array('success' => true, 'message' => 'Ваш заказ оформен успешно!');            
            echo json_encode($response);
           
        } else {
            // Error in inserting the order
            $response = array('error' => 'Ошибка при заказе!');
            echo json_encode($response);
        }

        // Close the database connection
        $conn->close();

    } else {
        // If JSON decoding fails, return an error response
        $response = array('error' => 'Invalid JSON data');
        echo json_encode($response);
    }

} else {
    // If the request method is not POST, return an error response
    $response = array('error' => 'Invalid request method');
    echo json_encode($response);
}

?>
