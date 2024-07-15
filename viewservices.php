<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Cart <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            
            <div>
                <?php
                    require_once "backend/Handler.php";
                    $handler->getProducts();
                ?>
            </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>