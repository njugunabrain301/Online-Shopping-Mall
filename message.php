<?php


?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Message <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            
            <?php 
                if(isset($_GET['requestWebSection'])){
                    if($_GET['requestWebSection'] == "success"){
                        echo "Request has been sent to the Administrator. You will be notified immediately on any changes to your request";
                    }else{
                        echo "Failed to send request";
                    }
                }
            
            
            ?>
        
        </content>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>