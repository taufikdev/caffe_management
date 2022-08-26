<?php
include('items/listOfItemsController.php');
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("location: /minishop/start.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo basename($_SERVER['PHP_SELF']) ?> </title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">
            <?php include 'layouts/navbar.html'; ?>
            <div class="card" style="border-radius: 1em;">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 style="color: lightslategray;">Create Order On : <span style="font-weight: bold;color: yellowgreen;"><?php echo date('j F, Y'); ?></span></h4>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card p-4" style="overflow-y: scroll; height:450px;scrollbar-width: none; border-radius: 1em;">

                                <div class="row gy-4">
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        $status = $row['status'] == 1 ? "valable" : "epuise";
                                    ?>
                                        <div class="card p-4 m-2 shadow-sm" style="width: 220px; border-radius: 1em;">
                                            <div>
                                                <img class="d-block" src="images/<?php echo $row['image']; ?>" style="height: 70px;width: 70px; margin-bottom: .5em;" alt="First slide">
                                            </div>

                                            <div>
                                                <input type="text" hidden name="item_id" value="<?php echo $row['id']; ?>" id="item_id">
                                                <h6><span id="item_name" style="color: lightslategray; font-weight: bold;"><?php echo $row['name']; ?></span> <span style="color: whitesmoke;" class="badge bg-danger"><?php echo $row['price']; ?>.00DH</span> <span hidden id="item_price"><?php echo $row['price']; ?></span></h6>
                                                <span style="color: lightslategrey;">Quantity:</span> <input type="number" name="qte_<?php echo $row['name']; ?>" value="1" id="num_<?php echo $row['name']; ?>" style="width: 70px; height: 27px; font-size: large;">
                                                <input type="checkbox" name="<?php echo $row['name']; ?>" id="" style="width: 27px;height: 27px; margin-top: -8em;margin-left: 1em;position: absolute;">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card" style="border-radius: 1em;">
                                <div class="card-body">
                                    <h6 style="color: lightslategray;"> Reciept</h6>
                                    <hr>
                                    <div class="selected_items">
                                        <ul id="item_list">

                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="vertical-center">
                                        <h6 style="color: lightslategray; text-align: end;"> <button id="place_order" class="btn btn-primary">Confirm</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total : <span id="total" style="color: whitesmoke;" class="badge bg-danger"> 00.00 Dh</span></h6>
                                    </div>
                                </div>
                            </div>
                            <br> <br>
                            <div class="alert alert-success alert-dismissible fade show" id="order_done">
                                <span>
                                    <p>Order created successfully!</p>
                                </span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- -------------------------------toast---------------------------------- -->
        </div>
    </div>
    <br><br>

    <!-- <div class="toast bg-success fade mt-4 text-white" id="myToast">
        <div class="toast-header bg-success align-items-end text-white">
            <strong class="me-auto"><i class="bi-gift-fill"></i> Thank you!</strong>
            <small>1s ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast">X</button>
        </div>
        <div class="toast-body">
            Order created successfully!
        </div>
    </div> -->


    <!-- -------------------------------toast---------------------------------- -->
    </div>
    </div>
</body>
<!-- <script src="js/jquery.min.js"></script> -->
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

<script>
    $(document).ready(function() {
        $('#order_done').hide();
        $('#place_order').prop('disabled', true);
        $("#total").text("00.00DH");
        var total = 0;
        var last_created_order_id = 0;
        $("input[type=checkbox]").change(function() {

            if ($(this).is(":checked")) {
                $(this).parent().parent().css("transition - timing - function", "ease - in")
                $(this).parent().parent().css("transition", "0.2s")
                $(this).parent().parent().css("transform", "scale(1.05)")

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

            } else {
                $(this).parent().parent().css("transition - timing - function", "ease - out")
                $(this).parent().parent().css("transition", "0.2s")
                $(this).parent().parent().css("transform", "scale(1)")

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

            if ($("#item_list li").length > 0) {
                $('#place_order').prop('disabled', false);
            } else {
                $('#place_order').prop('disabled', true);
            }
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

        $("#place_order").click(function() {
            $.ajax({
                type: "POST",
                url: "submission.php",
                data: {
                    server_id: <?php echo $_SESSION['staff_id']; ?>
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data.id);

                    last_created_order_id = data.id;
                    $("#item_list li").each((id, elem) => {
                        var id = parseInt($(elem).find(".item_id_to_insert").text());
                        var qte = parseInt($(elem).find(".item_qte_to_insert").text());
                        var price = parseInt($(elem).find(".item_price_to_insert").text());
                        $.ajax({
                            type: "POST",
                            url: "createOrderLine.php",
                            data: {
                                order_id: last_created_order_id,
                                item: id,
                                qte: qte,
                                price: price
                            },
                            dataType: 'json',
                            success: function(data) {},
                            error: function(xhr, status, error) {
                                // alert(error + "---------[errr]");
                            }
                        });
                    });
                    $('#order_done').show();
                    $('#order_done').fadeIn();
                    $('#place_order').prop('disabled', true);
                    $("#item_list").empty();
                    $("#total").text("00.00DH");
                    $('input:checkbox').removeAttr('checked');
                    $("input[type=number]").val("1");

                },
                error: function(xhr, status, error) {
                    alert(error + "{errr}");
                }
            });

        });
    });
</script>

</html>