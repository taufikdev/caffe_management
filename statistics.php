<?php
include('connection.php');
include('items/auth.php');

//-------------get data for bar chart---------------------

$sql = 'SELECT SUM(`order_line`.price) as "total", DAY(date) as "day" FROM `order_line` JOIN `order` ON `order_line`.`order_id` = `order`.`id` WHERE MONTH(date) = MONTH(NOW()) GROUP BY DAY(date); ';
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

while ($row = $result->fetch_assoc()) {
    $total[]  = $row['total'];
    $days[] = $row['day'] . "-" . date('m');
}

//-------------get data for pie chart---------------------
$sql2 = 'SELECT `stuff`.`name` ,SUM(`order_line`.`price`) as "earning" FROM `order_line` JOIN `order` ON `order_line`.`order_id` = `order`.`id` JOIN `stuff` ON `order`.`server` = `stuff`.`id` WHERE DAY(`order`.`date`) = DAY(NOW()) GROUP BY `stuff`.`id`; ';
$result2 = $connection->query($sql2);

if (!$result2) {
    die("Invalid query: " . $connection->error);
}

while ($row2 = $result2->fetch_assoc()) {
    $names[]  = $row2['name'];
    $earning[] = $row2['earning'];
}
//-----------------get data for num of order per server each day-------------------
$sql3 = 'SELECT count(DISTINCT(`order`.`Id`)) as "Number_of_orders", `stuff`.`name` FROM `order_line` JOIN `order` ON `order_line`.`order_id`=`order`.`id` JOIN `stuff` ON `order`.`server`=`stuff`.`id` WHERE DAY(`order`.`date`)=DAY(NOW()) GROUP BY `stuff`.id; ';
$result3 = $connection->query($sql3);

if (!$result3) {
    die("Invalid query: " . $connection->error);
}


$connection->close();

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                            <h4 style="color: lightslategray;">Summury Of : <span style="font-weight: bold;color: yellowgreen;"><?php echo date('D F, Y'); ?></span></h4>
                        </div>
                        <div>
                            <a href="#" role="button" class="btn btn-primary">Print report</a>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="d-flex justify-content: space-between">
                        <div class="chart-container" style="position: relative; height:500px; width: 450px;">
                            <h5 style="color: lightslategray;">How much the coffe shop earned each day</h5> <br>
                            <canvas id="myChart"></canvas>
                            <div class="card mt-4 pl-4 pb-4 pt-2" style="border-radius: 1em;">
                                <h5 style="color: lightslategray;">Number of order made today by:</h5>
                                <?php while ($row3 = $result3->fetch_assoc()) { ?>
                                    <h6><span style="color: yellowgreen;"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                            <?php echo $row3["name"]; ?> </span> <i class="fa fa-long-arrow-right" aria-hidden="true"></i><span style="font-weight: bold;color: lightcoral;"> <?php echo $row3["Number_of_orders"]; ?></span><span style="color: lightcoral;"> Orders</span>
                                    </h6>
                                <?php } ?>
                            </div>
                        </div> &nbsp; &nbsp; &nbsp; &nbsp;
                        <div class="chart-container" style="position: relative; height:300px; width: 350px;margin-left: 15em;">
                            <h5 style="color: lightslategray;">Waiter of the Day</h5>
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
<script type="text/javascript">
    //--------------------------populate charts--------------------------------

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($days); ?>,
            datasets: [{
                label: 'Total earns per day in MAD',
                data: <?php echo json_encode($total); ?>,
                backgroundColor: [
                    // 'rgba(202, 16, 56, 0.877)',
                    'rgb(25, 95, 141)',
                    'rgb(235, 169, 80)'
                ],

            }]
        },
    });
    if (parseInt("<?php echo count($names); ?>") > 0) {
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($names); ?>,
                datasets: [{
                    label: 'Waiter of the Day',
                    data: <?php echo json_encode($earning); ?>,
                    backgroundColor: [
                        'rgba(202, 16, 56, 0.877)',
                        'rgb(25, 95, 141)',
                        'rgb(235, 169, 80)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    }
</script>
<?php include 'layouts/scriptjs.html'; ?>

</html>