<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Admin <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <h5 class='center-align'>Tenant Dashboard</h5>
        <div class='container flex-wrap-center'>
            <a id='orders-link' onclick='checkEnabled(orders)'>
                <div class='store-card shadow-hover card'>
                    <div class='card-title'>Orders (<?php $handler->getStoreOrderCount("text");?>)</div>
                    <div class='bottom grey' id='orders-indicator'>Disabled</div>
                </div>
            </a>
            
            <a id='apts-link' onclick='checkEnabled(apts)'>
                <div class='store-card shadow-hover card'>
                    <div class='card-title'>Appointments (<?php $handler->getStoreAptCount("text");?>)</div>
                    <div class='bottom grey' id='apts-indicator'>Disabled</div>
                </div>
            </a>
            
            <a href='myStores.php'>
                <div class='store-card shadow-hover card'>
                    <div class='card-title'>Stores (<?php $handler->getStoreCount();?>)</div>
                    <div class='bottom green'>Enabled</div>
                </div>
            </a>
            
            <a href='invoice.php'>
                <div class='store-card shadow-hover card'>
                    <div class='card-title'>Invoices</div>
                    <div class='bottom green'>Enabled</div>
                </div>
            </a>
            
            <a href='messages.php'>
                <div class='store-card shadow-hover card'>
                    <div class='card-title'>Messages</div>
                    <div class='bottom green'>Enabled</div>
                </div>
            </a>
            
            <a href='payments.php'>
                <div class='store-card shadow-hover card'>
                    <div class='card-title'>Payment History</div>
                    <div class='bottom green'>Enabled</div>
                </div>
            </a>
            
            <a id='reports-link' onclick='checkEnabled(reports)'>
                <div class='store-card shadow-hover card'>
                    <div class='card-title'>Reports</div>
                    <div class='bottom grey' id='reports-indicator'>Disabled</div>
                </div>
            </a>
        </div>
        <div class='dashboard-data'>
            <div class='data center-align'>
                <h5>Performance</h5>
                <canvas id='progressChart'></canvas>
            </div>
            <div class='data center-align'>
                <h5>Totals</h5>
                <canvas id='totalsChart'></canvas>
            </div>
        </div>
        <?php require_once "includes/footer.php"; ?>
        <script src='Charts/Chart.min.js'></script>
        <script src='js/tenantDashboard.js'></script>
        <script>
            setEnabled();
            getEnabled();
        </script>
    </body>
</html>