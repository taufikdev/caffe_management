<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/header.html';
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
                        <div class="col-sm-4">
                            <div class="card" style="width: 18rem;">
                                <img src="images/tea.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card" style="width: auto;">
                                <img src="images/cafes.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            </div>
            </div>
</body>
<?php include 'layouts/scriptjs.html'; ?>

</html>