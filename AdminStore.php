<?php
    require_once "authentication.php";

    authenticateAdmin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Admin <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <script src="js/admin.js"></script>
        <div id='content' class='container center-align'>
            <h4>Store</h4>
            <div>
                <div id='ajax_stores' class='section'>
                    <?php

                        require_once "backend/adminGet.php";

                        $adminGet->getStoreAdmin($_GET['sid']);

                    ?>
                </div>
            </div>
        </div>
        <?php require_once "includes/footer.php"; ?>
        <script src="js/initializations.js"></script>
        <?php require_once "includes/footer.php"; ?>
        <script>
        </script>
    </body>
</html>