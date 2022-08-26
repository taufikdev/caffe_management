<?php
include('connection.php');
include('items/auth.php');




$error_massage = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $item = $_POST['item'];
    $qte = $_POST['qte'];
    $price = $_POST['price'];

    do {
        if (empty($order_id) ) {
            $error_massage = "Select a server";
            break;
        }

        $sql = "INSERT INTO `order_line` (`Id`, `order_id`, `item`, `qte`, `price`) VALUES (NULL, '$order_id', '$item', '$qte','$price'); ";
        if ($connection->query($sql) === TRUE) {
            $last_id = $connection->insert_id;
            $data = array("line" => $last_id);
            header("Content-Type: application/json");
            echo json_encode($data);
        
        } else {
            echo json_encode(array("err" => $connection->error));
        }
        $success_message = "Order created successfully";
        $connection->close();
        header('location: /minishop/ordersList.php');
        exit();

    } while (true);
}
