<?php
include("connection.php");
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM item WHERE id = $id ";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
}
header("location: /minishop/listOfItem.php");
exit;
