<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/header.html';
include('connection.php');
    session_start();
    if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
        header("location: /minishop/start.php");
    }
// read all the row from database
$sql = "SELECT * FROM clients";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
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
                <div class="col-md-6">
                    <h2>List of Suppliers</h2>
                </div>
                <div class="col-md-6 d-flex justify-content-sm-end">
                    <a href="/minishop/create.php" role="button" class="btn btn-primary">New Client</a> <br> <br>
                </div>
            </div><br>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Adress</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>$row[id]</td>
                                <td>$row[name]</td>
                                <td>$row[email]</td>
                                <td>$row[phone]</td>
                                <td>$row[address]</td>
                                <td>$row[created_at]</td>
                                <td>
                                    <a class='btn btn-outline-warning btn-sm' href='/minishop/edit.php?id=$row[id]'>Edit</a>
                                    <a class='btn btn-danger btn-sm' href='/minishop/delete.php?id=$row[id]'>Delete</a>
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
    </div>
    <?php include 'layouts/scriptjs.html'; ?>
</body>

</html>