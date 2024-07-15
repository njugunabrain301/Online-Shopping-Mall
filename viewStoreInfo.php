<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title>  <?php echo $_GET["name"]." | ".$title; ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            <div class='copy-link-div'>
                <button onclick='copyLink()' class='grey btn-small copy-btn'>Copy Link</button>
                <span class='grey darken-3 white-text tooltip' id='copy-tooltip'>Link Copied</span>
                <input type="text" id='link-address' value=''>
            </div>
            <?php   $handler->getStoreStatusMessage($_GET['store_id'])?>
            <script src='js/storeInfo.js'></script>
            <div class='container section store-website'>
                <?php
                    $handler->getStoreInfo();
                ?>
            </div>
        </content>
        <script>
            loadStoreIntroSection();
            delayScrollIntoView();
        </script>
        <?php require_once "snippets/rate.php"; ?>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>