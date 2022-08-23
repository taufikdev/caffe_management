<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/header.html';
include('connection.php');
session_start();
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' || $_SESSION['role'] !== 'server')) {
    header("location: /minishop/start.php");
}

$sql = "SELECT * FROM `order` ORDER BY date DESC;";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

function get_server($id, $connection)
{

    $sql_server = "SELECT * FROM stuff WHERE id = " . $id . ";";
    $result2 = $connection->query($sql_server);
    return $result2->fetch_assoc()['name'];
}
function get_server_image($id, $connection)
{

    $sql_server = "SELECT * FROM stuff WHERE id = " . $id . ";";
    $result2 = $connection->query($sql_server);
    return $result2->fetch_assoc()['image'];
}

function get_items($order_id, $connection)
{

    $sql_items = "SELECT * FROM order_line JOIN item on order_line.item=item.id WHERE order_id = " . $order_id . ";";
    return $connection->query($sql_items);
}
$total = 0;

?>
<style>
    body {

        background: #eee;
    }

    .timeline {
        position: relative;
        padding: 10px;
        margin: 0 auto;
        overflow: hidden;
        color: #ffffff;
    }

    .timeline:after {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        margin-left: -1px;
        border-right: 2px dashed #c4d2e2;
        height: 100%;
        display: block;
    }

    .timeline-row {
        padding-left: 50%;
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-row .timeline-time {
        position: absolute;
        right: 50%;
        top: 31px;
        text-align: right;
        margin-right: 20px;
        color: #000000;
        font-size: 1.5rem;
    }

    .timeline-row .timeline-time small {
        display: block;
        font-size: .8rem;
        color: #8796af;
    }

    .timeline-row .timeline-content {
        position: relative;
        padding: 20px 30px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
    }

    .timeline-row .timeline-content:after {
        content: "";
        position: absolute;
        top: 20px;
        height: 3px;
        width: 40px;
    }

    .timeline-row .timeline-content:before {
        content: "";
        position: absolute;
        top: 20px;
        right: -50px;
        width: 20px;
        height: 20px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
        z-index: 100;
        background: #ffffff;
        border: 2px dashed #c4d2e2;
    }

    .timeline-row .timeline-content h4 {
        margin: 0 0 20px 0;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        line-height: 150%;
    }

    .timeline-row .timeline-content p {
        margin-bottom: 30px;
        line-height: 150%;
    }

    .timeline-row .timeline-content i {
        font-size: 2rem;
        color: #ffffff;
        line-height: 100%;
        padding: 10px;
        border: 2px solid #ffffff;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
        margin-bottom: 10px;
        display: inline-block;
    }

    .timeline-row .timeline-content .thumbs {
        margin-bottom: 20px;
    }

    .timeline-row .timeline-content .thumbs img {
        margin-bottom: 10px;
    }

    .timeline-row:nth-child(even) .timeline-content {
        background-color: #ff5000;
        /* Fallback Color */
        background-image: -webkit-gradient(linear, left top, left bottom, from(#fc6d4c), to(#ff5000));
        /* Saf4+, Chrome */
        background-image: -webkit-linear-gradient(top, #fc6d4c, #ff5000);
        /* Chrome 10+, Saf5.1+, iOS 5+ */
        background-image: -moz-linear-gradient(top, #fc6d4c, #ff5000);
        /* FF3.6 */
        background-image: -ms-linear-gradient(top, #fc6d4c, #ff5000);
        /* IE10 */
        background-image: -o-linear-gradient(top, #fc6d4c, #ff5000);
        /* Opera 11.10+ */
        background-image: linear-gradient(top, #fc6d4c, #ff5000);
        margin-left: 40px;
        text-align: left;
    }

    .timeline-row:nth-child(even) .timeline-content:after {
        left: -39px;
        border-right: 18px solid #ff5000;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
    }

    .timeline-row:nth-child(even) .timeline-content:before {
        left: -50px;
        right: initial;
    }

    .timeline-row:nth-child(odd) {
        padding-left: 0;
        padding-right: 50%;
    }

    .timeline-row:nth-child(odd) .timeline-time {
        right: auto;
        left: 50%;
        text-align: left;
        margin-right: 0;
        margin-left: 20px;
    }

    .timeline-row:nth-child(odd) .timeline-content {
        background-color: #5a99ee;
        /* Fallback Color */
        background-image: -webkit-gradient(linear, left top, left bottom, from(#1379bb), to(#5a99ee));
        /* Saf4+, Chrome */
        background-image: -webkit-linear-gradient(top, #1379bb, #5a99ee);
        /* Chrome 10+, Saf5.1+, iOS 5+ */
        background-image: -moz-linear-gradient(top, #1379bb, #5a99ee);
        /* FF3.6 */
        background-image: -ms-linear-gradient(top, #1379bb, #5a99ee);
        /* IE10 */
        background-image: -o-linear-gradient(top, #1379bb, #5a99ee);
        /* Opera 11.10+ */
        background-image: linear-gradient(top, #1379bb, #5a99ee);
        margin-right: 40px;
        margin-left: 0;
        text-align: right;
    }

    .timeline-row:nth-child(odd) .timeline-content:after {
        right: -39px;
        border-left: 18px solid #1379bb;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
    }

    @media (max-width: 767px) {
        .timeline {
            padding: 15px 10px;
        }

        .timeline:after {
            left: 28px;
        }

        .timeline .timeline-row {
            padding-left: 0;
            margin-bottom: 16px;
        }

        .timeline .timeline-row .timeline-time {
            position: relative;
            right: auto;
            top: 0;
            text-align: left;
            margin: 0 0 6px 56px;
        }

        .timeline .timeline-row .timeline-time strong {
            display: inline-block;
            margin-right: 10px;
        }

        .timeline .timeline-row .timeline-icon {
            top: 52px;
            left: -2px;
            margin-left: 0;
        }

        .timeline .timeline-row .timeline-content {
            padding: 15px;
            margin-left: 56px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .timeline .timeline-row .timeline-content:after {
            right: auto;
            left: -39px;
            top: 32px;
        }

        .timeline .timeline-row:nth-child(odd) {
            padding-right: 0;
        }

        .timeline .timeline-row:nth-child(odd) .timeline-time {
            position: relative;
            right: auto;
            left: auto;
            top: 0;
            text-align: left;
            margin: 0 0 6px 56px;
        }

        .timeline .timeline-row:nth-child(odd) .timeline-content {
            margin-right: 0;
            margin-left: 55px;
        }

        .timeline .timeline-row:nth-child(odd) .timeline-content:after {
            right: auto;
            left: -39px;
            top: 32px;
            border-right: 18px solid #5a99ee;
            border-left: inherit;
        }

        .timeline.animated .timeline-row:nth-child(odd) .timeline-content {
            left: 20px;
        }

        .timeline.animated .timeline-row.active:nth-child(odd) .timeline-content {
            left: 0;
        }
    }
</style>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">
            <?php include 'layouts/navbar.html'; ?>
            <div class="card" style="border-radius: 1em;">
                <div class="card-header">

                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>List of <span style="font-weight: bold;color: yellowgreen;">Orders</span></h4>
                        </div>
                        <div><a href="/minishop/createOrder.php" role="button" class="btn btn-primary">New Order</a></div>
                    </div>

                </div>
                <div class="card-body" style="overflow-y: scroll; height:450px;scrollbar-width: none;">
                    <div class="container bootdey">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                                <!-- Timeline start -->
                                <div class="timeline">
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        $server = get_server($row['server'], $connection);
                                        $server_image = get_server_image($row['server'], $connection);
                                        $items = get_items($row['id'], $connection);
                                        $date = $row['date'];
                                    ?>
                                        <div class='timeline-row'>
                                            <div class='timeline-time' style="margin-top: -1em;">
                                                <span><?php echo substr($date, 11, 13) > 12 ? substr($date, 11) . "PM" : substr($date, 11) . "AM"; ?></span><small><?php echo substr($date, 0, 10); ?></small>
                                            </div>
                                            <div class='timeline-dot fb-bg'></div>
                                            <div class='timeline-content'>
                                                <div class="d-flex p-2">
                                                    <img src="images/<?php echo $server_image; ?>" width="70px" height="70px" style="border-radius: 50%;"></img>
                                                    <h5 style="margin-top: .8em;margin-left: 1em; color:#ffffff;font-weight: bold;"><?php echo $server; ?></h5>
                                                </div>
                                                <div>
                                                    <div class="d-flex">
                                                        <?php while ($row2 = $items->fetch_assoc()) {
                                                            $total += $row2['qte'] * $row2['price'];
                                                        ?>
                                                            <div class="d-flex p-2">
                                                                <img src="images/<?php echo $row2['image']; ?>" width='70px' height="70px" alt='' style='border-radius:.5em; margin-top: .5em;'><span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'> <?php echo $row2['price'] . ".00dh X " . $row2['qte']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </div>
                                                        <?php  } ?>
                                                    </div>
                                                    <div class="d-flex p-2" style="text-align: end;">
                                                        <h5> <span class='badge badge-light'>Total : <?php echo $total; ?>.00 DH</span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $total = 0;
                                    }  ?>
                                </div>
                                <!-- Timeline end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
</body>
<?php include 'layouts/scriptjs.html'; ?>

</html>