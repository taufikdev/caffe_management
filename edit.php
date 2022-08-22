<?php
include('connection.php');
include('items/auth.php');
//---------------------------------------
$id = "";
$name = "";
$email = "";
$phone = "";
$address = "";

$error_massage = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['id'])) {
        header("location: /minishop/index.php");
        exit;
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM clients WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /minishop/index.php");
        exit;
    }
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
} else {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    do {
        if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($address)) {
            $error_massage = "All the fields are required!";
            break;
        }

        //add the client to database

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        // update values to database
        $sql = "UPDATE clients SET name = '$name', email = '$email' , phone = '$phone', address = '$address' WHERE id = $id ";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }


        // $name = "";
        // $email = "";
        // $phone = "";
        // $address = "";
        $success_message = "Client updated successfully";

        header("location: /minishop/index.php");
        exit;
    } while (false);
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include 'layouts/header.html'; ?>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">

            <?php include 'layouts/navbar.html'; ?>
            <br>
            <h2>Edit Client</h2><br>
            <?php
            if (!empty($error_massage)) {
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <div>$error_massage</div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            }
            ?>
            <br>
            <form action="#" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                    </div>
                </div>
                <?php
                if (!empty($success_message)) {
                    echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-3 d-grid'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <div>$success_message</div>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    </div>
                    </div>
                    ";
                }
                ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a href="/minishop/index.php" class="btn btn-outline-primary" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include 'layouts/scriptjs.html'; ?>
</body>
</html>