<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> <?php 
                $name = $_GET['item_name'];
            echo $name." | ".$title; ?></title>
        <script type="text/javascript" src="js/order.js"></script>
        <script src='js/addProduct.js'></script>
    </head>
    <body>
        <div id='header'>
            <?php require_once "includes/header.php"; ?>
        </div>
        <div class='copy-link-div item-page'>
                <button onclick='copyLink()' class='grey btn-small copy-btn'>Copy Link</button>
                <span class='grey darken-3 white-text tooltip' id='copy-tooltip'>Link Copied</span>
                <input type="text" id='link-address' value=''>
        </div><br>
        <content style='width:100%;'>
            <div id='ajax_product'>
                <?php
                    require_once "backend/Handler.php";
                    $sid = $handler->getProduct();                
                ?>
            </div>
            <div class='panel' id='best-sellers'>
                
                <div class='title'>
                    <span>From same store</span>
                    <a href='viewproducts.php?name=<?php echo $name?>&store_id=<?php echo $sid; ?>'>More...</a>
                </div>
                
                <div class='content'>
                    <?php
                        $handler->getStoreBestSellers($sid);
                    ?>
                </div>
                <div id='comments-section'>
                    <script> 
                        
                        if(setComments) document.getElementById('comments-section').innerHTML = commentSecond; 
                        else document.getElementById('best-sellers').innerHTML = "";
                    </script>
                </div>
            </div>
            <a href='#login-modal' class='modal-trigger hide' id='logInModal'></a>
            <div class='change modal specs' id='Shoes-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_shoes_modal(this, '<?php echo $_GET['id']?>')">
                        <h5>Item Specifications</h5>
                        <div class='input-field'>
                            <label>Brand</label>
                            <input type="text" name="brand" required minlength="3" maxlength="25">
                        </div>
                        <div class='input-field'>
                            <label>Colors :</label><br>
                            <div id='shoeColors' class='spec-small color'>
                                <div class='color' style='width:100%'><input type='color' class='shoe-color-input'><span class='btn-small red white-text' onclick ='removeSpec(this.parentNode)'><i class='fas fa-times'></i></span></div>
                            </div>
                            <span class='btn-floating green white-text' onclick="addColor('shoeColors', 'shoe')"><i class='material-icons'>add</i></span>
                        </div>
                        <div class='input-field'>
                            <label>Sizes :</label><br>
                            <div id='shoeNumbers' class='spec-small'>
                                <div class='text' style='width:100%'><input type='text' maxlength='3' class='shoe-size-input' required><span class='btn-small red white-text' onclick ='removeSpec(this.parentNode)'><i class='fas fa-times'></i></span></div>
                            </div>
                            <span class='btn-floating green white-text' onclick="addSize('shoeNumbers', 'shoe')"><i class='material-icons'>add</i></span>
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
                <div class='change modal specs' id='Clothes-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_clothes_modal(this, '<?php echo $_GET['id']?>')">
                        <h5>Clothe Information</h5>
                        <div class='input-field'>
                            <label>Brand</label>
                            <input type="text" name="brand" required minlength="3" maxlength="25">
                        </div>
                        <div class='input-field'>
                            <label>Colors :</label><br>
                            <div id='clotheColors' class='spec-small color'>
                                <div class='color' style='width:100%'><input type='color' class='clothe-color-input'><span class='btn-small red white-text' onclick ='removeSpec(this.parentNode)'><i class='fas fa-times'></i></span></div>
                            </div>
                            <span class='btn-floating green white-text' onclick="addColor('clotheColors', 'clothe')"><i class='material-icons'>add</i></span>
                        </div>
                        <div class='input-field'>
                            <label>Sizes :</label><br>
                            <div id='clotheSizes' class='spec-small'>
                                <div class='text' style='width:100%'><input type='text' maxlength='3' class='clothe-size-input' required><span class='btn-small red white-text' onclick ='removeSpec(this.parentNode)'><i class='fas fa-times'></i></span></div>
                            </div>
                            <span class='btn-floating green white-text' onclick="addSize('clotheSizes', 'clothe')"><i class='material-icons'>add</i></span>
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
                <div class='change modal specs' id='Televisions-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_tv_modal(this, '<?php echo $_GET['id']?>')">
                        <h5>TV Specifications</h5>
                        <div class='input-field'>
                            <label>Make</label>
                            <input type="text" name="make" required minlength="3" maxlength="25">
                        </div>
                        <div class='input-field'>
                            <label>Model</label>
                            <input type="text" name="model" required minlength="3" maxlength="40">
                        </div>
                        <div class='input-field'>
                            <label>Size in inches</label>
                            <input type="number" name="inches" required min="10" max="1000">
                        </div>
                        <div class='input-field'>
                            <label>Display<i>(8K, HD etc.)</i></label>
                            <input type="text" name="display" required minlength="2" maxlength="8">
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
                <div class='change modal specs' id='Computers-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_computer_modal(this, '<?php echo $_GET['id']?>')">
                        <h5>Computers Specifications</h5>
                        <div class='input-field'>
                            <label>Make</label>
                            <input type="text" name="make" required minlength="3" maxlength="25">
                        </div>
                        <div class='input-field'>
                            <label>Model</label>
                            <input type="text" name="model" required minlength="3" maxlength="40">
                        </div>
                        <div class='input-field'>
                            <label>Size in inches</label>
                            <input type="number" name="inches" required min="5" max="100">
                        </div>
                        <div class='input-field'>
                            <label>Memory</label>
                            <input type="text" name="memory" required maxlength="5">
                        </div>
                        <div class='input-field'>
                            <label>Storage</label>
                            <input type="text" name="storage" required minlength="3" maxlength="7">
                        </div>
                        <div class='input-field'>
                            <label>Processor Type</label>
                            <input type="text" name="ptype" required minlength="5" maxlength="25">
                        </div>
                        <div class='input-field'>
                            <label>Processor Speed</label>
                            <input type="text" name="pspeed" required minlength="3" maxlength="10">
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
                <div class='change modal specs' id='Phones-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                     <form onsubmit="return validate_phone_modal(this, '<?php echo $_GET['id']?>')">
                        <h5>Phone Specifications</h5>
                        <div class='input-field'>
                            <label>Make</label>
                            <input type="text" name="make" required minlength="3" maxlength="25">
                        </div>
                        <div class='input-field'>
                            <label>Model</label>
                            <input type="text" name="model" required minlength="3" maxlength="40">
                        </div>
                        <div class='input-field'>
                            <label>Size in inches</label>
                            <input type="number" name="inches" required min="2" max="15">
                        </div>
                        <div class='input-field'>
                            <label>Memory</label>
                            <input type="text" name="memory" required maxlength="5">
                        </div>
                        <div class='input-field'>
                            <label>Storage</label>
                            <input type="text" name="storage" required minlength="3" maxlength="7">
                        </div>
                        <div class='input-field'>
                            <label>Front Camera</label>
                            <input type="text" name="fcamera" required minlength="3" maxlength="7">
                        </div>
                        <div class='input-field'>
                            <label>Back Camera</label>
                            <input type="text" name="bcamera" required minlength="3" maxlength="7">
                        </div>
                        <div class='input-field'>
                            <label>Battery Capacity</label>
                            <input type="text" name="bcapacity" required minlength="3" maxlength="15">
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
        </content>
        <?php  
            require_once "snippets/OrderForm.php"; 
            require_once "snippets/LoginForm.php";
        ?>
        <script src='js/slider.js'></script>
        <script src='js/product.js'></script>
        <?php require_once "snippets/rate.php"; ?>
        <?php require_once "includes/footer.php"; ?>
        <script src='js/initializations.js'>
        </script>
        <script src='js/bookCalendar.js'></script>
        <script>
            $('.datepicker').datepicker(options);
        </script>
    </body>
</html>