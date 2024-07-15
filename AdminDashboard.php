<?php
    require_once "authentication.php";

    authenticateAdmin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Admin <?php echo "| ".$title ?></title>
        <link type="text/css" rel="stylesheet" href='DataTables/datatables.min.css'>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            <h3 class='center-align'>Admin</h3>
            <div class=''>
               <div class='dashboard-data admin row'>
                    <div class='col s6 dashboard-card'>
                        <span><span id='tStores' class='count'></span>&nbsp; Stores</span>
                    </div>
                   <div class='col s6 dashboard-card'>
                        <span><span id='tTenants' class='count'></span>&nbsp; Tenants</span>
                    </div>
                   <div class='col s12 dashboard-card'>
                        <span><span id='tIncome' class='count'></span> Revenue</span>
                    </div>
                    <div class='col s12 l6 center-align'>
                        <h5>Store Types</h5>
                        <canvas id='typesChart'></canvas>
                    </div>
                    <div class='col s12 l6 center-align'>
                        <h5>Stores Status</h5>
                        <canvas id='statusChart'></canvas>
                    </div>
                    <div class='buttons'>
                        <a href='AdminStores.php' class='btn-small green white-text'>Stores</a>
                        <a href='AdminIncome.php' class='btn-small green white-text'>Income</a>
                    </div>
                </div> 
            </div>
        </content>
    </body>
    <script src='Charts/Chart.min.js'></script>
    <script src='js/adminDashboard.js'></script>
    <?php require_once "includes/footer.php"; ?>
    <script>

    </script>
</html>