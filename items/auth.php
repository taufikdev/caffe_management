<?php
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
}
if ($_SESSION['role'] === 'server'){
    header("location: /minishop/ordersList.php");
}


?>