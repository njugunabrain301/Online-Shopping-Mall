<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> <?php 
                $name = $_GET['item_name'];
            echo $name." | ".$title; ?></title>
        <script type="text/javascript" src="js/order.js"></script>
    </head>
    <body>
        <div id='header'>
            <?php require_once "includes/header.php"; ?>
        </div>
        <content style='width:100%;'>
            <div id='ajax_product'>
                <?php
                    require_once "backend/Handler.php";
                    $sid = $handler->getProductOrdered();                
                ?>
            </div>
            
        </content>
        <script src='js/slider.js'></script>
        <?php require_once "includes/footer.php"; ?>
        <script src='js/initializations.js'></script>
    </body>
</html>