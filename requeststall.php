<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Request Stall <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <div class='container' id='request-stall'>
            <h4 class='center-align'>Request Online Stall</h4>
            <div class='flex-wrap-center' >
                <div class='package'>
                    <h4>Bronze</h4>
                    <div>
                        <span class='price-div'><span class="price">Ksh 499/=</span><span class='price-add'></span></span>
                        <ul>
                            <li>Personal website with customizable seller information</li>
                            <li>Add any number of features to your website</li>
                            <li>Get sharable link to your website</li>
                            <!--<li>Chat tool available when customers access your store</li>-->
                            <li>Your store will be listed in matching customer searches</li>
                            <li>Link to external website if already existing</li>
                        </ul>
                    </div>
                    <a href='requeststalladdress.php?type=bronze'>Send Request</a>
                </div>
                <div class='package'>
                    <h4>Silver</h4>
                    <div>
                        <span class='price-div'><span class="price">Ksh 1199/=</span><span class='price-add'></span></span>
                        <ul>
                            <li>All Bronze package features</li>
                            <li>Add any number of products and services to your store</li>
                            <li>Your products and services will be listed in matching customer searches</li>
                            <!--<li>Chat tool available for all products and services added</li>-->
                            <li>Get sharable link to each of your products and services</li>
                            <!--<li>Followers are updated whenever new products and services are added</li>-->
                        </ul>
                    </div>
                    <a href='requeststalladdress.php?type=silver'>Send Request</a>         
                </div>
                <div class='package'>
                    <h4>Gold</h4>
                    <div>
                        <span class='price-div'><span class="price">Ksh 1999/=</span><span class='price-add'></span></span>
                        <ul>
                            <li>All Bronze package features</li>
                            <li>Add any number of products</li>
                            <li>Get sharable link to your products</li>
                            <!--<li>Chat tool available whenever customer accesses your products</li>-->
                            <li>Your products will be listed in matching customer searches</li>
                            <!--<li>Followers are updated whenever new products are added</li>-->
                            <li>Customers can order products online</li>
                            <li>Statistics report generation on sales</li>
                            <li>Order manager</li>
                        </ul>
                    </div>
                    <a href='requeststalladdress.php?type=gold'>Send Request</a>         
                </div>
                <div class='package'>
                    <h4>Diamond</h4>
                    <div>
                        <span class='price-div'><span class="price">Ksh 2399/=</span><span class='price-add'></span></span>
                        <ul>
                            <li>All Bronze package features</li>
                            <li>Add any number of services</li>
                            <li>Get sharable link to your services</li>
                            <!--<li>Chat tool available whenever customer accesses your service page</li>-->
                            <li>Your services will be listed in matching customer searches</li>
                            <!--<li>Followers are updated whenever new services are added</li>-->
                            <li>Customers book appointments online</li>
                            <li>Statistics report generation on sales</li>
                            <li>Appointment manager</li>
                        </ul>
                    </div>
                    <a href='requeststalladdress.php?type=diamond'>Send Request</a>         
                </div>
                <div class='package'>
                    <div style='position: absolute; top: 0; width: 100px; height:20px' class='grey'></div>
                    <h4>Platinum</h4>
                    <div>
                        <span class='price-div'><span class="price">Ksh 3999/=</span><span class='price-add'></span></span>
                        <ul>
                            <li>All features of Gold Package</li>
                            <li>All features of Diamond Package</li>
                            <li>Upload both products and services for your store</li>
                            <li>Customers can order products and book appointments online</li>
                            <li>Order and Appointment managers are enabled</li>
                            <li>Statistics reports on sales from all stores</li>
                        </ul>
                    </div>
                    <a href='requeststalladdress.php?type=platinum'>Send Request</a>         
                </div>
            </div>
        </div>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>