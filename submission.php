<?php
include('connection.php');
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
}

$order_id = "";
$server_id = "";


$error_massage = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $server_id = $_POST['server_id'];
    // $server_id = 2;
    // die($server_id);

    do {
        if (empty($server_id) ) {
            $error_massage = "Select a server";
            break;
        }


        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `order` (`id`, `server`, `date`) VALUES (NULL, '$server_id', '$date'); ";
        if ($connection->query($sql) === TRUE) {
            $last_id = $connection->insert_id;

            
            $data = array("id" => $last_id);

            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        } else {
            echo json_encode(array("err" => $connection->error));
        }

        $connection->close();

        // $order_id = "";
        // $server_id = "";
        // $success_message = "Client added successfully";

        // header("location: /minishop/createOrder.php");
        // exit;
    } while (true);
}



?>