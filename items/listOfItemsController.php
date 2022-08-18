<?php 
include('.//connection.php');
$sql = "SELECT * FROM item";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}


?>