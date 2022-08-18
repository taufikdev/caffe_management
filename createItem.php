<?php
include('connection.php');
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
}
//---------------------------------------
$name = "";
$price = "";
$image = "";

$error_massage = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    // $image = $_POST['image'];

    do {

        //----------------------------upload file---------------------

        $target_path = "images/";
        $target_path = $target_path . basename($_FILES['fileToUpload']['name']);
        $image = $_FILES['fileToUpload']['name'];
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path)) {
            echo "File uploaded successfully!";
        } else {
            echo "Sorry, file not uploaded, please try again!";
        }
        sleep(2);
        if (empty($name) || empty($price) || empty($image)) {
            $error_massage = "All the fields are required!";
            break;
        }
        //----------------------------end upload----------------------
        // insert values to database
        $sql = "INSERT INTO item(name,price,image,status) VALUES('$name','$price','$image',1)";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        $name = "";
        $price = "";
        $image = "";
        $success_message = "Client added successfully";

        header("location: /minishop/listOfItem.php");
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
                    <h2>New Item</h2><br>
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
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="price">
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