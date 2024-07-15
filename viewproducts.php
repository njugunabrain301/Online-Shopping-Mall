<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title>  <?php echo $_GET["name"]." | ".$title; ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <script src='js/storeProducts.js'></script>
        <content>
            <div class='copy-link-div'>
                <button onclick='copyLink()' class='grey btn-small copy-btn'>Copy Link</button>
                <span class='grey darken-3 white-text tooltip' id='copy-tooltip'>Link Copied</span>
                <input type="text" id='link-address' value=''>
            </div>
            <?php   $handler->getStoreStatusMessage($_GET['store_id'])?>
            <div class='container section'>
                <h4 class='center-align'><?php echo $_GET['name']; ?></h4>
                <?php
                    require_once "backend/Handler.php";
                    $name = $_GET['name'];
                    $id = $_GET['store_id'];
                    $handler->getList("viewproducts.php?store_id=$id&name=$name","store");
                ?>
            </div>
            <div class='change modal' id='Shoes-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_shoes_modal(this)">
                        <h5>Shoe Specifications</h5>
                        <div class='input-field'>
                            <label>Brand</label>
                            <input type="text" name="brand" required>
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
                <div class='change modal' id='Clothes-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_clothes_modal(this)">
                        <h5>Clothe Information</h5>
                        <div class='input-field'>
                            <label>Brand</label>
                            <input type="text" name="brand" required>
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
                <div class='change modal' id='Televisions-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_tv_modal(this)">
                        <h5>TV Specifications</h5>
                        <div class='input-field'>
                            <label>Make</label>
                            <input type="text" name="make" required>
                        </div>
                        <div class='input-field'>
                            <label>Model</label>
                            <input type="text" name="model" required>
                        </div>
                        <div class='input-field'>
                            <label>Size in inches</label>
                            <input type="number" name="inches" required>
                        </div>
                        <div class='input-field'>
                            <label>Display<i>(8K, HD etc.)</i></label>
                            <input type="text" name="display" required>
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
                <div class='change modal' id='Computers-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_computer_modal(this)">
                        <h5>Computers Specifications</h5>
                        <div class='input-field'>
                            <label>Make</label>
                            <input type="text" name="make" required>
                        </div>
                        <div class='input-field'>
                            <label>Model</label>
                            <input type="text" name="model" required>
                        </div>
                        <div class='input-field'>
                            <label>Size in inches</label>
                            <input type="number" name="inches" required>
                        </div>
                        <div class='input-field'>
                            <label>Memory</label>
                            <input type="text" name="memory" required>
                        </div>
                        <div class='input-field'>
                            <label>Storage</label>
                            <input type="text" name="storage" required>
                        </div>
                        <div class='input-field'>
                            <label>Processor Type</label>
                            <input type="text" name="ptype" required>
                        </div>
                        <div class='input-field'>
                            <label>Processor Speed</label>
                            <input type="text" name="pspeed" required>
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
                <div class='change modal' id='Phones-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                     <form onsubmit="return validate_phone_modal(this)">
                        <h5>Phone Specifications</h5>
                        <div class='input-field'>
                            <label>Make</label>
                            <input type="text" name="make" required>
                        </div>
                        <div class='input-field'>
                            <label>Model</label>
                            <input type="text" name="model" required>
                        </div>
                        <div class='input-field'>
                            <label>Size in inches</label>
                            <input type="number" name="inches" required>
                        </div>
                        <div class='input-field'>
                            <label>Memory</label>
                            <input type="text" name="memory" required>
                        </div>
                        <div class='input-field'>
                            <label>Storage</label>
                            <input type="text" name="storage" required>
                        </div>
                        <div class='input-field'>
                            <label>Front Camera</label>
                            <input type="text" name="fcamera" required>
                        </div>
                        <div class='input-field'>
                            <label>Back Camera</label>
                            <input type="text" name="bcamera" required>
                        </div>
                        <div class='input-field'>
                            <label>Battery Capacity</label>
                            <input type="text" name="bcapacity" required>
                        </div>
                        <br>
                        <button class='btn-small green' type="submit">Okay</button>
                    </form>
                </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>