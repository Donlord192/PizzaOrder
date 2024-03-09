<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /pizzaorder/index.php");
    exit();
}

if (!isset($_SESSION['username'])) {
    header("Location: /pizzaorder/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pizzaorder";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);

    if ($stmt->fetch()) {
        $stmt->close();

        $delete_user_sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($delete_user_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        session_destroy();
        header("Location: ../index.php");
        exit();
    } else {
        echo "Ошибка: Пользователь не найден.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #user-content {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        label {
            margin-bottom: 8px;
        }

        button {
            padding: 10px;
            background-color: #ff6600;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #e65c00;
        }

        a.logout-button {
            display: inline-block;
            padding: 10px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }

        a.logout-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<div id="user-content">
    <h2>Добро пожаловать, <?php echo $_SESSION['username']; ?>!</h2>

    <form action="user.php" method="post">
        <button type="submit" name="delete_account" onclick="return confirm('Вы уверены, что хотите удалить свой аккаунт?')">Удалить аккаунт</button>
    </form>

    <?php
    if (isset($_SESSION['username'])) {
        echo '<a href="/pizzaorder/index.php">Выйти из аккаунта</a>';
        session_destroy();
    }
    ?>
</div>

</body>
</html>