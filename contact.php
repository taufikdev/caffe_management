<?php include 'layouts/header.html';
include('connection.php');
session_start();
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' || $_SESSION['role'] !== 'server')) {
    header("location: /minishop/start.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://platform.linkedin.com/badges/js/profile.js" async defer type="text/javascript"></script>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'layouts/sidebar.html'; ?>
        <div id="content" class="p-4 p-md-5">
            <?php include 'layouts/navbar.html'; ?>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 style="color: lightslategray;">Contact information for <span style="font-weight: bold;color: yellowgreen;">The developer</span></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="badge-base LI-profile-badge" data-locale="ar_AE" data-size="medium" data-theme="light" data-type="VERTICAL" data-vanity="taoufik-ed-darraz-7484a723b" data-version="v1"><a class="badge-base__link LI-simple-link" href="https://ma.linkedin.com/in/taoufik-ed-darraz-7484a723b?trk=profile-badge">Taoufik ED-DARRAZ</a></div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include 'layouts/scriptjs.html'; ?>
</html>