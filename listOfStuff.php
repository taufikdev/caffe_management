<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/header.html';
include('items/auth.php');
?>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">
            <?php include 'layouts/navbar.html'; ?>
            <div class="card" style="border-radius: 1em;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>List of Staff</h2>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end"> <a href="/minishop/createStuff.php" role="button" class="btn btn-primary">New Staff</a> <br> <br>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('connection.php');
                            // read all the row from database
                            $sql = "SELECT * FROM stuff";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }

                            //read data of each row

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>$row[id]</td>
                                <td>$row[name]</td>
                                <td>$row[phone]</td>
                                <td><img src='images/$row[image]' width='70px' height='70px' alt='' style='border-radius:50%;'></td> 
                                <td>$row[type]</td>
                                <td>
                                    <a class='btn btn-outline-warning btn-sm' href='/minishop/editStuff.php?id=$row[id]'>Edit</a>
                                    <a class='btn btn-danger btn-sm' href='/minishop/deleteStuff.php?id=$row[id]'>Delete</a>
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