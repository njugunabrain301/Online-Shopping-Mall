<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Welcome <?php echo "| ".$title ?></title>
    </head>
    <body>
        
        <content id='home'>
            <img src="images/website/bg.jpg" class='home-image'>
            <div class='home'>
                <?php require_once  "includes/header.php"; ?>
            </div>
            <p class='tag-line flow-text container'>We give you access to everything Nakuru has to offer, at the touch of a button</p>
            <div id='home-search'>
                <form action='search.php' method='get'>
                    <span class='flow-text'>Get Started</span><br>
                    <div>
                    <input type='text' name='search' placeholder="Search" required>
                    <i class='fas fa-search' type='submit'></i>
                    </div>
                </form>
            </div>
            <div id='home-menu'>
                <?php require_once "includes/menu.php";?>
            </div>
            <div class='panel'>
                
                <div class='title'>
                    <span>Popular Stores</span>
                    <a href='search.php?f_stores=on&f_product=on&f_service=on&f_category=All+Categories&f_from=0&f_to=100000&filter=apply'>More ...</a>
                </div>
                
                <div class='content'>
                    <?php
                        $handler->getPopularStores();
                    ?>
                </div>
            </div>
            
            <div class='panel'>
                
                <div class='title'>
                    <span>Best Sellers</span>
                    <a href='search.php?f_product=on&f_service=on&f_category=All+Categories&f_from=0&f_to=100000&filter=apply'>More ...</a>
                </div>
                
                <div class='content'>
                    <?php
                        $handler->getBestSellers();
                    ?>
                </div>
            </div>
            
            <div class='panel'>
                
                <div class='title'>
                    <span>New Arrivals</span>
                    <a href='search.php?f_product=on&f_service=on&f_category=All+Categories&f_from=0&f_to=100000&filter=apply'>More ...</a>
                </div>
                 
                <div class='content'>
                    <?php
                        $handler->getNewArrivals();
                    ?>
                </div>
            </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>