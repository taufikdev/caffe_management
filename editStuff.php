<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";

//create connection
$connection = new mysqli($servername, $username, $password, $database);
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
}
//---------------------------------------
$id = "";
$name = "";
$phone = "";
$image = "";
$type = "";

$error_massage = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['id'])) {
        header("location: /minishop/listOfStuff.php");
        exit;
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM stuff WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /minishop/listOfStuff.php");
        exit;
    }
    $name = $row['name'];
    $phone = $row['phone'];
    $image = $row['image'];
    $type = $row['type'];
} else {
    $id = $_POST['id'];
    $sql = "SELECT * FROM stuff WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /minishop/listOfStuff.php");
        exit;
    }
    $image = $row['image'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];

    do {

        //----------------------------upload file---------------------

        unlink('images/' . $image);
        $target_path = "images/";
        $target_path = $target_path . basename($_FILES['fileToUpload']['name']);
        $image = $_FILES['fileToUpload']['name'];
        // die($image);
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path)) {
            echo "File uploaded successfully!";
        } else {
            echo "Sorry, file not uploaded, please try again!";
        }
        sleep(2);
        if (empty($id) || empty($name) || empty($phone) || empty($type)) {
            $error_massage = "All the fields are required!";
            break;
        }

        // update values to database
        $sql = "UPDATE stuff SET name = '$name' , phone = '$phone', image = '$image', type = '$type' WHERE id = $id ";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }


        $name = "";
        $email = "";
        $phone = "";
        $address = "";
        $success_message = "Stuff updated successfully";

        header("location: /minishop/listOfStuff.php");
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
                <div class="card-body">
                    <br>
                    <h2>Edit Stuff</h2><br>
                    <?php
                    if (!empty($error_massage)) {
                        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <div>$error_massage</div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
                    }
                    ?>
                    <br>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="row mb-3">
                            <label for="" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="type" value="<?php echo $type; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
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
            <?php include 'layouts/scriptjs.html'; ?>
</body>

</html>