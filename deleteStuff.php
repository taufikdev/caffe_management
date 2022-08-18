<?php 

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "myshop";

    $connection = new mysqli($servername,$username,$password,$database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "DELETE FROM stuff WHERE id = $id ";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }

}
header("location: /minishop/listOfStuff.php");
exit;
