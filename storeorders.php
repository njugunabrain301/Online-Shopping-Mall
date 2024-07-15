<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Orders <?php echo "| ".$title ?></title>
        <link type="text/css" rel="stylesheet" href='DataTables/datatables.min.css'>
        <script src='DataTables/datatables.min.js'></script>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <script src="js/cart.js"></script>
        <script src='js/setCounts.js'></script>
        <content>
            <div id='cart' class='container section center-align'>
                <div class='section right-align'>
                    <button class='btn-small green complex' onclick="fetchSimpleOrders()">Simple</button>
                    <button class='btn-small green simple' onclick="fetchDetailedOrders()">Detailed</button>
                </div>
                <div class='simple'>
                    <ul id='cart-menu' class='tabs hide-on-small-only'>
                    <li class='tab active'>
                        <a href='#delivery_div' class="cart_nav" onclick='checkReload()'>Delivery<span class='de clue'></span></a>
                    </li>
                    <li class='tab'>
                        <a href='#pickup_div' class="cart_nav" onclick='checkReload()'>Pick Up <span class='pi clue'></span></a>
                    </li>
                    <li class='tab'>
                        <a href='#completed_div' class="cart_nav" onclick='checkReload()'>Completed <span class='co clue'></span></a>
                    </li>
                    <li class='tab'>
                        <a href='#cancelled_div' class="cart_nav" onclick='checkReload()'>Cancelled <span class='ca clue'></span></a>
                    </li>
                </ul>
                    <div id='cart_ajax'>
                    <div id='delivery_div' class='hide-on-small-only de-text'></div>
                    <div id='pickup_div' style='display: none' class='hide-on-small-only pi-text'></div>
                    <div id='completed_div' style='display: none' class='hide-on-small-only co-text'></div>
                    <div id='cancelled_div' style='display: none' class='hide-on-small-only ca-text'></div>
                    <ul class='collapsible hide-on-med-and-up'>
                        <li>
                            <div class='collapsible-header green white-text' onclick='checkReload()'>Delivery Orders <div class='de clue'></div></div>
                            <div class='collapsible-body de-text'></div></li>
                        <li>
                            <div class='collapsible-header green white-text' onclick='checkReload()'>Pick Up Orders <div class='pi clue'></div></div>
                            <div class='collapsible-body pi-text'></div></li>
                        <li>
                            <div class='collapsible-header green white-text' onclick='checkReload()'>Completed Orders <div class='co clue'></div></div>
                            <div class='collapsible-body co-text'></div></li>
                        <li>
                            <div class='collapsible-header green white-text' onclick='checkReload()'>Cancelled Orders <div class='ca clue'></div></div>
                            <div class='collapsible-body ca-text'></div></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class='complex' style="max-width: 90%; min-width: 700px; margin: auto;">
                    <div id='data-div'>
                        <div class='data'>
                            <table id='order-data-table'>
                                <thead>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Cost</th>
                                    <th>Date Ordered</th>
                                    <th>Order Status</th>
                                    <th>Order Type</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id='order-data'>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </content>
        <?php require_once "snippets/reason.php"?>
        <?php require_once "includes/footer.php"; ?>
        <script>
            tenant = true;
            reloadCart();
            reloadCounts();
            fetchSimpleOrders();
        </script>
        <script src='js/initializations.js'></script>
    </body>
</html>