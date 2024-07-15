<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Edit <?php echo $_GET['name']." | ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <div class='container'>
            <div class='store center-align' id='ajax_store'>
                <?php
                    require_once "backend/Handler.php";
                    $handler->getStore();
                ?>
            </div>
            <div id='divSname' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Store Name</h5>
                <form action='backend/User.php' onsubmit='return validate_store_change(this, "changeSname")'>
                    <label>Enter new Store Name</label><br>
                    <div class='input-field'>
                        <input type="text" name='new' required maxlength="30"><br>
                    </div>
                    <p id='error' class='message changeSname red-text'></p>
                    <input type='hidden' name='manageStore' value='set'>
                    <input type="submit" name='changeSname' value='Save' class='btn-small green'>
                </form>
            </div>
            <div id='divStype' style="display:none" class='modal change'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Store Type</h5>
                <form action='backend/User.php' onsubmit='return validate_store_change(this, "changeStype")'>
                    <label>Enter new Store Type</label><br>
                    <div class='input-field'>
                        <select type = "text" name="new" required>
                            <option>Bronze</option>
                            <option>Silver</option>
                            <option>Gold</option>
                            <option>Diamond</option>
                            <option>Platinum</option>
                        </select>
                    </div>
                    <p id='error' class='message changeStype red-text'></p>
                    <input type='hidden' name='manageStore' value='set'>
                    <input type="submit" name='changeStype' value='Save Changes' class='btn-small green'>
                </form>
            </div>
            <div id='divSemail' style="display:none" class='modal change'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Email</h5>
                <form action='backend/User.php' onsubmit='return validate_store_change(this, "changeSemail")'>
                    <label>Enter new Email</label><br>
                    <div class='input-field'>
                        <input type="email" name='new' maxlength="50" required><br>
                    </div>
                    <p id='error' class='message changeSemail red-text'></p>
                    <input type='hidden' name='manageStore' value='set'>
                    <input type="submit" name='changeSemail' value='Save Changes' class='btn-small green'>
                </form>
            </div>
            <div id='divSphone' style="display:none" class='modal change'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Phone</h5>
                <form action='backend/User.php' onsubmit='return validate_store_change(this, "changeSphone")'>
                    <label>Enter new Phone</label><br>
                    <div class='input-field'>
                        <input type="text" name='new' maxlength="15" required><br>
                    </div>
                    <p id='error' class='message changeSphone red-text'></p>
                    <input type='hidden' name='manageStore' value='set'>
                    <input type="submit" name='changeSphone' value='Save Changes' class='btn-small green'>
                </form>
            </div>
            <div id='divSwebsite' style="display:none" class='modal change'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Website</h5>
                <form action='backend/User.php' onsubmit='return validate_store_change(this, "changeSwebsite")'>
                    <label>Enter new website link</label><br>
                    <div class='input-field'>
                        <input type="text" name='new' maxlength="50" required><br>
                    </div>
                    <p id='error' class='message changeSwebsite red-text'></p>
                    <input type='hidden' name='manageStore' value='set'>
                    <input type="submit" name='changeSwebsite' value='Save Changes' class='btn-small green'>
                </form>
            </div>
            <div id='divDesc' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Description</h5>
                <form action='backend/User.php' onsubmit='return validate_store_change(this, "changeDesc")'>
                    <label>Enter new Description</label><br>
                    <div class='input-field'>
                        <textarea name='new' class='materialize-textarea' minlength="150" maxlength="255"></textarea><br>
                    </div>
                    <p id='error' class='message changeDesc red-text'></p>
                    <input type='hidden' name='manageStore' value='set'>
                    <input type="submit" name='changeDesc' value='Save Changes' class='btn-small green'>
                </form>
            </div>
            <div id='divSimage' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Image</h5>
                <form action='backend/Tenant.php' onsubmit='return validate_store_change(this, "changeImage")' enctype="multipart/form-data" method='post'>
                    <label>Select New Image</label><br>
                    <input type='hidden' name='id' value='<?php echo $_GET['id'] ?>'>
                    <input type='hidden' name='store_name' value='<?php echo $_GET['name'] ?>'>
                    <input type='hidden' name='manageStore' value='set'>
                    <div class='file-field input-field'>
                        <div class='btn-small grey'>
                            <span>Select Image</span>
                            <input type="file" name='new'><br>
                        </div>
                        <div class='file-path-wrapper'>
                            <input class='file-path' type='text' id='image2' placeholder='Upload File'>
                        </div>
                    </div>
                    <p id='error' class='message changeImage red-text'></p>
                    <input type="submit" name='changeImage' value='Save Image' class='btn-small green'>
                </form>
            </div>
            <div class='center-align change modal' id='addProductOrService'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Add Product or service</h5>
                <form action='backend/Tenant.php' onsubmit="return validate_product_listing(this)" method='post'>
                    <div class='input-field'>
                        <label>Title</label>
                        <input name='title' type="text" required maxlength="15">
                    </div>
                    <div class='input-field'>
                        <label>Description</label>
                        <textarea name='content' class='materialize-textarea' required minlength="50" maxlength="200"></textarea>
                    </div>
                    <div class='file-field input-field'>
                        <div class='btn-small grey' style="height: 30px;">
                            <span>Add image</span>
                            <input type="file" name="image" id='images'>
                        </div>
                        <div class='file-path-wrapper'>
                            <input class='file-path' type='text' placeholder='Upload File'>
                        </div>
                    </div>
                    <input type='hidden' name='id' value='<?php echo $_GET['id']?>'>
                    <p id='product_error' class='message error red-text'></p>
                    <input type="submit" name='addProductListing' value='Add' class='btn-small green'>
                </form>
            </div>
            <div class='center-align change modal' id='modifyAvailability'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Modify Availability</h5>
                <form action='backend/Tenant.php' onsubmit="return validate_modify_availability(this)" method='post' class='row'>
                    <div class='row col s12 left-align'>
                            <div class='col s12 m6'>
                                <label>Hours Available</label><br>
                                <label>
                                <input type="radio" name='hours' value='1' checked class='with-gap'> <span>8:00 am - 5:00pm</span>
                                </label><br>
                                <label>
                                <input type="radio" name='hours' value='2' class='with-gap'> <span>8:00 am - 8:00pm</span>
                                </label><br>
                                <div id='ajax_hours'>
                                    <?php
                                        $handler->getHours();
                                    ?>
                                </div>
                                <a class='btn-floating modal-trigger' href='#hours-modal'><i class='material-icons'>add</i></a> Add Custom
                            </div>
                            <div class='col s12 m6'>
                                <label>Lunch Hours</label><br>
                                <label>
                                <input type="radio" name='lunchhours' value='1' checked class='with-gap'> <span>1:00 pm - 2:00pm</span>
                                </label><br>
                                <div id='ajax_lunch_hours'>
                                    <?php
                                        $handler->getLunchHours();
                                    ?>
                                </div>
                                <a class='btn-floating modal-trigger' href='#lunchhours-modal'><i class='material-icons'>add</i></a> Add Custom
                            </div>
                        </div>
                        <div class='col s12 left-align'>
                            <div class='col s12 m6'>
                                <label>Weekends</label><br>
                                <label>
                                <input type="radio" name='weekends' value='none' checked class='with-gap'> <span>Not available on weekends</span>
                                </label><br>
                                <label>
                                <input type="radio" name='weekends' value='both' class='with-gap'> <span>Available both on Sunday and Sartuday</span>
                                </label><br>
                                <label>
                                <input type="radio" name='weekends' value='sunday' class='with-gap'> <span>Available on Sunday</span>
                                </label><br>
                                <label>
                                <input type="radio" name='weekends' value='sartuday' class='with-gap'> <span>Available on Sartuday</span>
                                </label>

                            </div>
                            <div class='col s12 m6'>
                                <label>Holidays</label><br>
                                <label>
                                <input type="radio" name='holidays' value='none' checked class='with-gap'> <span>Not available on holidays</span>
                                </label><br>
                                <label>
                                <input type="radio" name='holidays' value='all' class='with-gap'> <span>Available on all holidays</span>
                                </label><br>
                                <label>
                                <input type="radio" name='holidays' value='national' class='with-gap'> <span>Available on national holidays</span>
                                </label><br>
                                <label>
                                <input type="radio" name='holidays' value='religious' class='with-gap'> <span>Available on religious holidays </span>
                                </label>
                            </div>
                        </div>
                    
                    <input type='hidden' name='id' value='<?php echo $_GET['id']?>'>
                    <input type="submit" name='modifyAvailability' value='Save' class='btn-small green'>
                </form>
            </div>
            <div id='hours-modal' class='modal change'>
                    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_add_hours(this)">
                        <h5>Add Custom Hours</h5>
                        <label>From</label>
                        <div class='input-field'>
                            <input type="time" name='from' required>
                        </div>
                        <label>To</label>
                        <div class='input-field'>
                            <input type="time" name='to' required>
                        </div>
                        <input type="submit" value='Save' class='btn-small green'>
                    </form>
                </div>
                <div id='lunchhours-modal' class='modal change'>
                    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_add_lunch_hours(this)">
                        <h5>Add Custom Lunch Hours</h5>
                        <label>From</label>
                        <div class='input-field'>
                            <input type="time" name='from' required>
                        </div>
                        <label>To</label>
                        <div class='input-field'>
                            <input type="time" name='to' required>
                        </div>
                        <input type="submit" value='Save' class='btn-small green'>
                    </form>
                </div>
            <div id='availability' class='section'>
                <h4 class='center-align'>Availability</h4>
                <a class='btn-small green modal-trigger section' href='#modifyAvailability' >Change</a>
                <div id='ajax_availability'>
                    <?php
                         $handler->getAvailability();                   
                    ?>
                </div>
            </div>
            <div id='PnSlisting' class='section'>
                <h4 class='center-align'>Product & Services Listing</h4>
                <a class='btn-small green modal-trigger section' href='#addProductOrService' >Add</a>
                <div id='ajax_products_listing'>
                    <?php
                         $handler->getProductListing();                   
                    ?>
                </div>
            </div>
            <div class='center-align modal change' id='addOutlet'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <form action='backend/Tenant.php' method='post' onsubmit="return validate_outlet_form(this)" class='section'>
                    <h5>Add Outlet</h5>
                    <label>Street</label><br>
                    <div class='input-field'>
                        <input type='text' name='street' required maxlength="40"><br>
                    </div>
                    <label>Building</label><br>
                    <div class='input-field'>
                        <input type='text' name='building' required maxlength="40"><br>
                    </div>
                    <label>Stall</label><br>
                    <div class='input-field'>
                        <input type='text' name='stall' required maxlength="10"><br>
                    </div>
                    <label>Description</label><br>
                    <div class='input-field'>
                        <textarea type='text' name='description' class='materialize-textarea' required minlength="50" maxlength="100"></textarea><br>
                    </div>
                    <input type='hidden' name='id' value='<?php echo $_GET['id']?>'>
                    <p id='outlet_error' class='message error red-text'></p>
                    <input type="submit" name='addOutlet' value='Add' class='btn-small green'>
                </form>
            </div>
            <div>
                <h4 class='center-align'>Outlets</h4>
                <a class='btn-small green modal-trigger section' href='#addOutlet' >Add</a>
                <div id='ajax_outlets' class='flex-wrap-center'>
                    <?php
                        $handler->getLocations();
                    ?>
                </div>
            </div>
        </div>
        <div id='package_change_modal' class='modal change'>
            <button class='btn-small modal-close green'><i class='fas fa-times'></i></button>
            <br><br>
                <h4>Response</h4>
                <p>Package change request submitted. You need to complete the payment for the change to be implemented</p> <a class='btn-small green white-text' href='invoice.php'>Pay Now</a>
            <br><br>
        </div>
        <script type="text/javascript" src='js/editing.js'></script>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>