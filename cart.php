<?php
    require_once "authentication.php";

    authenticateLoggedIn();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Cart <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <script src="js/cart.js"></script>
        <script src='js/setCounts.js'></script>
        <h4 class='center-align'>Cart</h4>
        <content>
            <div id='cart' class='container center-align'>
            <div>
                <ul id='cart-menu' class="tabs hide-on-small-only">
                    <li class='tab'>
                        <a href="#pending_div" class="cart_nav" onclick='checkReload()'>Pending<span class='pe clue'></span></a>
                    </li>
                    <li class='tab'>
                        <a href='#delivery_div' class="cart_nav" onclick='checkReload()'>Delivery <span class='de clue'></span></a>
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
            </div>
                <div id="pending_div" class="hide-on-small-only pe-text"></div>
                <div id="delivery_div" style="display: none" class="hide-on-small-only de-text"></div>
                <div id="pickup_div" style="display: none" class="hide-on-small-only pi-text"></div>
                <div id="completed_div" style="display: none" class="hide-on-small-only co-text"></div>
                <div id="cancelled_div" style="display: none" class="hide-on-small-only ca-text"></div>
                <div id='cart_ajax'>
                    <ul class="collapsible hide-on-med-and-up">
                        <li>
                            <div class="collapsible-header green white-text" onclick='checkReload()'>Pending <div class="pe clue"></div></div>
                            <div class="collapsible-body pe-text"></div></li>
                        <li>
                            <div class="collapsible-header green white-text" onclick='checkReload()'>On Delivery <div class="de clue"></div></div>
                            <div class="collapsible-body de-text"></div></li>
                        <li>
                            <div class="collapsible-header green white-text" onclick='checkReload()'>Pick Up Orders <div class="pi clue"></div></div>
                            <div class="collapsible-body pi-text"></div></li>
                    <li>
                            <div class="collapsible-header green white-text" onclick='checkReload()'>Completed Orders <div class="co clue"></div></div>
                        <div class="collapsible-body co-text"></div></li>
                    <li>
                            <div class="collapsible-header green white-text" onclick='checkReload()'>Cancelled Orders <div class="ca clue"></div></div>
                        <div class="collapsible-body ca-text"></div></li>
                    </ul>
                </div>
            </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
        <?php require_once "snippets/rate.php"; ?>
        <?php require_once "snippets/payment.php"; ?>
        <script src="js/initializations.js"></script>
        <script>
            reloadCart();
        </script>
    </body>
</html>