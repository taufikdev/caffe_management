<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/header.html';
include('items/listOfItemsController.php');
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
}
?>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">
            <?php include 'layouts/navbar.html'; ?>
            <div class="card" style="border-radius: 1em;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>List of Items</h2>
                        </div>
                        <div class="col-md-8 d-flex justify-content-end"> <a href="/minishop/createItem.php" role="button" class="btn btn-primary">New Item</a> <br> <br>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                $status = $row['status'] == 1 ? "valable" : "epuise";
                                echo "<tr>
                                    <td>$row[id]</td>
                                    <td>$row[name]</td>
                                    <td>$row[price].00DH</td>
                                    <td><img src='images/$row[image]' width='70px' alt='' style='border-radius:.5em;'></td> 
                                    <td>$status</td>
                                    <td>
                                        <a class='btn btn-outline-warning btn-sm' href='/minishop/editItem.php?id=$row[id]'>Edit</a>
                                        <a class='btn btn-danger btn-sm' href='/minishop/deleteItem.php?id=$row[id]'>Delete</a>
                                    </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
                </div>
                </div>
            </div>
</body>
<?php include 'layouts/scriptjs.html'; ?>

</html>