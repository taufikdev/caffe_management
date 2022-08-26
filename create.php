<?php
include('connection.php');
include('items/auth.php');

$name = "";
$email = "";
$phone = "";
$address = "";

$error_massage = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $error_massage = "All the fields are required!";
            break;
        }

        //add the client to database

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        // insert values to database
        $sql = "INSERT INTO clients(name,email,phone,address) VALUES('$name','$email','$phone','$address')";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        $name = "";
        $email = "";
        $phone = "";
        $address = "";
        $success_message = "Client added successfully";

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
            <div class="card" style="border-radius: 1em;">
                <div class="card-header">

                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 style="color: lightslategray;">Add New <span style="font-weight: bold;color: yellowgreen;">Supplier :</span></h4>
                        </div>
                    </div>

                </div>
                <div class="card-body">
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
        </div>
    </div>
</body>
<?php include 'layouts/scriptjs.html'; ?>

</html>