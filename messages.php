<?php
    require_once "authentication.php";

    authenticateLoggedIn();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Notifications <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            
        
        </content>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>