<?php 
include('.//connection.php');
$staff = $_SESSION['staff_id'];
$sql = "SELECT * FROM stuff where id='$staff'";
$result_server = $connection->query($sql);

if (!$result_server) {
    die("Invalid query: " . $connection->error);
}

?>