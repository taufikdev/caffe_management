<!DOCTYPE html>
<html lang="en">

<?php include 'layouts/header.html'; ?>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">
            <?php include 'layouts/navbar.html'; ?>

            <div id="carouselExampleIndicators" class="carousel slide" style="width: 50%;" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner " style="margin-left: 5em; ">
                    <div class="carousel-item active">
                        <img class="d-block w-25" src="images/avocado.png" alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Price 15.00DH</h5>
                            <input type="checkbox" name="avocado" id=""> &nbsp;&nbsp;&nbsp;&nbsp;
                            <span style="color: black;">Quantity:</span> <input type="number" name="qte" min="1" id="" style="width: 70px; height: 40px; font-size: large;">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-25" src="images/orange.png" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-25" src="images/blackcoffe.png" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>
    </div>
</body>
<?php include 'layouts/scriptjs.html'; ?>

</html>