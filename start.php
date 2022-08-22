<?php
session_start();

include('connection.php');

$php_errormsg = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password = sha1($password);

    $sql = "SELECT * FROM users where username='$username' AND password = '$password'";
    $result = $connection->query($sql);
    if (!$result) {
        $php_errormsg = "Invalid username or pawwsord";
        die("Invalid query: " . $connection->error);
    }

    $row = $result->fetch_assoc();

    if ($result->num_rows == 1 && $row['role'] === 'admin') {
        session_regenerate_id();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['staff_id'] = $row['staff_id'];
        session_write_close();
        header('location: /minishop/home.php');
    } else if ($result->num_rows == 1 && $row['role'] === 'server') {
        session_regenerate_id();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['staff_id'] = $row['staff_id'];
        session_write_close();
        header('location: /minishop/ordersList.php');
    } else {
        header('location: /minishop/start.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/loginStyle.css">
    <!------ Include the above in your HEAD tag ---------->
    <title>Coffe shop</title>
</head>
<style>
    body {
        background-image: url('images/doodles.jpg');
    }
</style>

<body>
    <div class="login-reg-panel">
        <div class="login-info-box">
            <h2>Have an account?</h2>
            <p>Lorem ipsum dolor sit amet</p>
            <label id="label-register" for="log-reg-show">Login</label>
            <input type="radio" name="active-log-panel" id="log-reg-show" checked="checked">
        </div>

        <div class="register-info-box">
            <h2>Don't have an account?</h2>
            <p>Lorem ipsum dolor sit amet</p>
            <label id="label-login" for="log-login-show">Register</label>
            <input type="radio" name="active-log-panel" id="log-login-show">
        </div>

        <div class="white-panel">
            <div class="login-show">
                <h2>LOGIN</h2>
                <form action="" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" class="bttn" name="login" value="Login">
                    <a href="">Forgot password?</a>
                </form>
                <img src="images/logo.png" style="width: 120px;height: 110px;" alt="" class="mt-4">
            </div>
            <div class="register-show">
                <h2>REGISTER</h2>
                <input type="text" placeholder="Email">
                <input type="password" placeholder="Password">
                <input type="password" placeholder="Confirm Password">
                <input type="button" value="Register">
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('.login-info-box').fadeOut();
        $('.login-show').addClass('show-log-panel');
    });


    $('.login-reg-panel input[type="radio"]').on('change', function() {
        if ($('#log-login-show').is(':checked')) {
            $('.register-info-box').fadeOut();
            $('.login-info-box').fadeIn();

            $('.white-panel').addClass('right-log');
            $('.register-show').addClass('show-log-panel');
            $('.login-show').removeClass('show-log-panel');

        } else if ($('#log-reg-show').is(':checked')) {
            $('.register-info-box').fadeIn();
            $('.login-info-box').fadeOut();

            $('.white-panel').removeClass('right-log');

            $('.login-show').addClass('show-log-panel');
            $('.register-show').removeClass('show-log-panel');
        }
    });
</script>

</html>