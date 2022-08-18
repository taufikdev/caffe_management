<?php
include('connection.php');
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
}
//---------------------------------------
$name = "";
$phone = "";
$image = "";
$type = "";

$error_massage = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];

    do {

        //----------------------------upload file---------------------

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
        if (empty($name) || empty($phone) || empty($type)) {
            $error_massage = "All the fields are required!";
            break;
        }
        //----------------------------end upload----------------------
        // insert values to database
        $sql = "INSERT INTO stuff(name,phone,image,type) VALUES('$name','$phone','$image','$type')";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        $name = "";
        $phone = "";
        $image = "";
        $type = "";
        $success_message = "Client added successfully";

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
                    <h2>New Staff</h2><br>
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
                                <a href="/minishop/listOfStuff.php" class="btn btn-outline-primary" role="button">Cancel</a>
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