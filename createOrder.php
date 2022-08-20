<?php include 'layouts/header.html';
include('items/listOfItemsController.php');
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
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
            <div class="row">
                <div class="col-sm-9">
                    <div class="card" style="border-radius: 1em;">
                        <div class="card-body">
                            <div id="carouselExampleIndicators" class="carousel slide" style="width: 80%;" data-ride="carousel">
                                <div class="carousel-inner " style="margin-left: 5em; ">
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        $status = $row['status'] == 1 ? "valable" : "epuise";
                                    ?>
                                        <div class="carousel-item<?php echo $row['id'] == 1 ? ' active' : ''; ?>">
                                            <img class="d-block w-25" src="images/<?php echo $row['image']; ?>" alt="First slide">
                                            <div class="carousel-caption d-none d-md-block">
                                                <input type="text" hidden name="item_id" value="<?php echo $row['id']; ?>" id="item_id">
                                                <h4><span id="item_name" style="color: lightslategray; font-weight: bold;"><?php echo $row['name']; ?></span> <span style="color: whitesmoke;" class="badge bg-danger"><?php echo $row['price']; ?>.00DH</span> <span hidden id="item_price"><?php echo $row['price']; ?></span></h4>
                                                <input type="checkbox" name="<?php echo $row['name']; ?>" id=""> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="color: lightslategrey;">Quantity:</span> <input type="number" name="qte_<?php echo $row['name']; ?>" value="1" id="num_<?php echo $row['name']; ?>" style="width: 70px; height: 40px; font-size: large;">
                                            </div>
                                        </div>
                                    <?php } ?>
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
                </div>
                <div class="col-sm-3">
                    <div class="card" style="border-radius: 1em;">
                        <div class="card-body">
                            <h6 style="color: lightslategray;"> Reciept</h6>
                            <hr>
                            <div class="selected_items">
                                <ul id="item_list">

                                </ul>
                            </div>
                            <hr>
                            <h6 style="color: lightslategray; text-align: end;"> Total : <span id="total" style="color: whitesmoke;" class="badge bg-danger"> 45.00 Dh</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include 'layouts/scriptjs.html'; ?>
<script>
    $(document).ready(function() {
        $("#total").text("00.00DH");
        var total = 0;
        $("input[type=checkbox]").change(function() {

            if ($(this).is(":checked")) {
                var item_id = $(this).parent().find("#item_id").val();
                var item_qte = $(this).parent().find("input[type='number']").val();
                var item_name = $(this).parent().find('#item_name').text();
                var item_price = $(this).parent().find('#item_price').text();
                if ($("#item_list li").length == 0) {

                    $("#item_list").append("<li><span hidden class='item_id_to_insert'>" + item_id + "</span>" + item_name + " <span style='color: whitesmoke;' class='badge bg-success'> X " + item_qte + "</span><span hidden class='item_price_to_insert'>" + item_price + "</span><span hidden class='item_qte_to_insert'>" + item_qte + "</span></li>");

                } else {
                    $("#item_list li").each((id, elem) => {
                        var item_id = $(this).parent().find("#item_id").val();
                        var item_qte = $(this).parent().find("input[type='number']").val();
                        var item_name = $(this).parent().find('#item_name').text();
                        var item_price = $(this).parent().find('#item_price').text();
                        if (elem.innerText.includes(item_name)) {
                            elem.innerHTML = "";
                            elem.innerHTML = "<span hidden class='item_id_to_insert'>" + item_id + "</span>" + item_name + " <span style='color: whitesmoke;' class='badge bg-success'> X " + item_qte + "</span><span hidden class='item_price_to_insert'>" + item_price + "</span><span hidden class='item_qte_to_insert'>" + item_qte + "</span>";

                        }
                    });
                    $("#item_list").append("<li><span hidden class='item_id_to_insert'>" + item_id + "</span>" + item_name + " <span style='color: whitesmoke;' class='badge bg-success'> X " + item_qte + "</span><span hidden class='item_price_to_insert'>" + item_price + "</span><span hidden class='item_qte_to_insert'>" + item_qte + "</span></li>");
                }

                // if (item_id == '' || item_id == '' ) {
                //     alert("Please select an item.");
                //     return false;
                // }

                // $.ajax({
                //     type: "POST",
                //     url: "submission.php",
                //     data: {
                //         item_id: item_id,
                //         item_qte: item_qte
                //     },
                //     cache: false,
                //     success: function(data) {
                //         alert(data);
                //     },
                //     error: function(xhr, status, error) {
                //         console.error(xhr);
                //     }
                // });

            } else {
                $("#item_list li").each((id, elem) => {
                    var item_id = $(this).parent().find("#item_id").val();
                    var item_qte = $(this).parent().find("input[type='number']").val();
                    var item_name = $(this).parent().find('#item_name').text();
                    if (elem.innerText.includes(item_name)) {
                        elem.parentNode.removeChild(elem);
                    }
                });
            }
            $("#total").text("");
            total = 0;
            $("#item_list li").each((id, elem) => {
                var qte = parseInt($(elem).find(".item_qte_to_insert").text());
                var price = parseInt($(elem).find(".item_price_to_insert").text());
                total += qte * price;
            });

            $("#total").text(total + ".00DH");
        });


        $("input[type=number]").change(function() {
            if ($(this).parent().find("input[type=checkbox]").is(":checked")) {
                var item_id = $(this).parent().find("#item_id").val();
                var item_qte = $(this).parent().find("input[type='number']").val();
                var item_name = $(this).parent().find('#item_name').text();
                var item_price = $(this).parent().find('#item_price').text();

                if ($("#item_list li").length == 0) {
                    $("#item_list").append("<li><span hidden class='item_id_to_insert'>" + item_id + "</span><span>" + item_name + " </span><span style='color: whitesmoke;' class='badge bg-success'> X " + item_qte + "</span><span hidden class='item_price_to_insert'>" + item_price + "</span><span hidden class='item_qte_to_insert'>" + item_qte + "</span></li>");
                } else {
                    $("#item_list li").each((id, elem) => {

                        var item_id = $(this).parent().find("#item_id").val();
                        var item_qte = $(this).parent().find("input[type='number']").val();
                        var item_name = $(this).parent().find('#item_name').text();
                        var item_price = $(this).parent().find('#item_price').text();
                        if (elem.innerText.includes(item_name)) {
                            elem.innerHTML = "<span hidden class='item_id_to_insert'>" + item_id + "</span><span>" + item_name + "</span> <span style='color: whitesmoke;' class='badge bg-success'> X " + item_qte + "</span><span hidden class='item_price_to_insert'>" + item_price + "</span><span hidden class='item_qte_to_insert'>" + item_qte + "</span>";
                        }
                    });

                }
            }
            total = 0;
            $("#total").text("");
            $("#item_list li").each((id, elem) => {
                var qte = parseInt($(elem).find(".item_qte_to_insert").text());
                var price = parseInt($(elem).find(".item_price_to_insert").text());
                total += qte * price;
            });

            $("#total").text(total + ".00DH");

        });

         
    });
</script>

</html>