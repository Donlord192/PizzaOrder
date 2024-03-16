<?php
$conn = new mysqli("localhost", "root", "", "pizzaorder");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="pizza-container">';
    while($row = $result->fetch_assoc()) {
        echo '<div class="pizza" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '">';
        echo '<a href="' . $row['image'] . '" target="_blank"><img src="' . $row['image'] . '" alt="' . $row['name'] . '"></a>';
        echo '<div class="pizza-info">';
        echo '<h4>' . $row['name'] . '</h4>';
        echo '<p>$' . $row['price'] . '</p>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "0 results";
}

$conn->close();
?>