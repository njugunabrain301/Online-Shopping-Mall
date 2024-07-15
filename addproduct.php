<?php
    @session_start();
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Add Product <?php echo "| ".$title ;?></title>
        <script src='js/addProduct.js'></script>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <div class='container'>
            <?php
                $num = rand(1,4);
            ?>
            <div class='form addForm form-small'>
                <img src="images/website/add-product-image<?php echo $num?>.jpg">
                <div class='right'>
                    <img src='images/website/menu-bg.jpg'>
                    <form action="backend/Tenant.php" method="post" enctype="multipart/form-data" onsubmit="return validate_add_product(this)">
                    <h4 class='center-align'>Add Product</h4>
                    <div class='input-field'>
                        <label>Name</label>
                        <input type="text" name="name" maxlength="18" required>
                    </div>
                    <div class='input-field'>
                        <label>Type</label>
                        <input type="text" name="type" maxlength="20" required>
                    </div>
                    <div class='input-field'>
                        <label>Quantity</label>
                        <input type="number" name="quantity" max="1000" min="1" required>
                    </div>
                    <div class='input-field'>
                        <label>Price</label>
                        <input type="number" name="price" max="499999" min="1" required>
                    </div>
                    <input type='hidden' name='store_id' value="<?php echo $_GET['store_id']; ?>" >
                    <input type='hidden' name='store_name' value="<?php echo $_GET['sname']; ?>" >
                    <div class='input-field'>
                        <select name="category" id='select' onchange="getFeatures(this)" class='smaller-select' required>
                                <option value="" disabled selected>Select category</option>
                                <option>Phones & Accessories</option>
                                <option>Televisions</option>
                                <option>Sound System</option>
                                <option>Electronics & Appliances</option>
                                <option>Computers & Accessories</option>
                                <option>Clothes & Accessories</option>
                                <option>Shoes</option>
                                <option>Furniture</option>
                                <option>Learning Materials</option>
                                <option>Food & Beverages</option>
                                <option>Other</option>
                        </select>
                        <a id='select-info' class='disable-select-info-icon select-info-icon modal-trigger'><i class='material-icons'>info</i></a>
                    </div>
                    <div class='input-field'>
                        <label>Description</label>
                        <textarea name="description" class='materialize-textarea' minlength="40" maxlength="255" required></textarea>
                    </div>

                    <div class='file-field input-field'>
                        <div class='btn-small grey'>
                            <span>Add image</span>
                            <input type="file" name="image[]" multiple id='images'>
                        </div>
                        <div class='file-path-wrapper'>
                            <input class='file-path' type='text' placeholder='Upload File'>
                        </div>
                    </div>
                    <div id='specs-div-final'>
                    </div>
                    <p id='error' class='message red-text'></p>
                    <p id='success' class='message green-text'></p>
                    <div class='center-align'>
                    <input type="submit" value="Upload" name="addProduct" class='btn-small green'>
                    </div>
                </form>
                </div>
                <div class='change modal' id='Shoes-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_shoes_modal(this, '')">
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
                <div class='change modal' id='Clothes-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_clothes_modal(this, '')">
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
                <div class='change modal' id='Televisions-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_tv_modal(this, '')">
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
                <div class='change modal' id='Computers-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_computer_modal(this, '')">
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
                <div class='change modal' id='Phones-modal'>
                    <span class='btn-small green modal-close'><i class='fas fa-times'></i></span>
                     <form onsubmit="return validate_phone_modal(this, '')">
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
            </div>
        </div>
        <?php require_once "includes/footer.php"; ?>
        <script>
            //$('select').formSelect();
        </script>
    </body>
</html>