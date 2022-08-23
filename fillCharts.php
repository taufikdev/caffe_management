<?php
include('connection.php');
include('items/auth.php');

$sql = "SELECT * FROM `order_line`";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

$data = array("data" => $result->fetch_assoc());
header("Content-Type: application/json");
echo json_encode($data);
exit();
$connection->close();


?>