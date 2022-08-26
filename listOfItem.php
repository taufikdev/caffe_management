<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/header.html';
include('items/listOfItemsController.php');
include('items/auth.php');

?>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">
            <?php include 'layouts/navbar.html'; ?>
            <div class="card" style="border-radius: 1em;">
                <div class="card-header">

                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 style="color: lightslategray;">List of <span style="font-weight: bold;color: yellowgreen;">Items</span></h4>
                        </div>
                        <div><a href="/minishop/createItem.php" role="button" class="btn btn-primary">New Item</a></div>
                    </div>

                </div>
                <div class="card-body" style="overflow-y: scroll; height:450px;scrollbar-width: none;">
                    <table class="table table-striped table-hover" style="border-radius: 1em;">
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
                        <tbody class="scrollable">
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
<style>
    .table>tbody>tr>td {
        vertical-align: middle;
    }
</style>

</html>