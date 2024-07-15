<?php
    @session_start();
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Stall Address <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <div class='center-align container'>
            <div id='request-stall-form'>
                <h4>Request Store</h4>
                <form action="backend/Tenant.php" method="post" onsubmit="return validate_physical_address(this)" enctype="multipart/form-data" class='container left-align'>
                    <div class='row'>
                        <h6 class='col s12'>Store Information</h6>
                        <div class='col s12 m6'><div class='input-field'>
                            <label>Store Name</label>
                            <input type="text" name="name" required maxlength="30">
                        </div></div>
                        <div class='file-field input-field col s12 m6'>
                            <div class='btn-small grey'>
                                <span>Select Image</span>
                                <input type='file' name='image' id='images' id='image'><br>
                            </div>
                            <div class='file-path-wrapper'>
                                <input class='file-path' type='text' id='image2' placeholder='Upload File'>
                            </div>
                        </div>
                        <div class='input-field col s12'>
                            <textarea name="description" id='about' class='materialize-textarea' required minlength="150" maxlength="500"></textarea><br>
                            <label for='about'>About store</label>
                        </div>
                        <div class='input-field col s12'>
                            <input type="number" min="1" max="100" id='capacity' name="capacity" required><br>
                            <label for='capcity'>Capacity <i>(Number of clients you can handle at a time)</i></label>
                            <label></label>
                        </div>
                        <span class='divider col s12'></span>
                        <h6 class='col s12'>Store Address</h6>
                        <div class='input-field col s12 m6'>
                            <input type="text" name="street" id='street' required maxlength="40"><br>
                            <label for='street'>Street</label>
                        </div>
                        <div class='input-field col s12 m6'>
                            <input type="text" name="building" id='building' required maxlength="40"><br>
                            <label for='building'>Building Name</label>
                        </div>
                        <div class='input-field col s12 m6'>
                            <input type="text" name="stall" id='stall' required maxlength="10"><br>
                            <label for='stall'>Stall <i>(if applicable)</i></label>
                        </div>
                        <div class='input-field col s12 m6'>
                            <textarea name="addressDescription" id='about-loc' class='materialize-textarea' required minlength="50" maxlength="100"></textarea><br>
                            <label for='about-loc'>Additional information about location</label>
                        </div>
                        <span class='divider col s12'></span>
                        <h6 class='col s12'>Store Contact</h6>
                        <div class='input-field col s12 m6'>
                            <input type="email" name="email" id='email' required maxlength="50"><br>
                            <label for='email'>Contact Email</label>
                        </div>
                        <div class='input-field col s12 m6'>
                            <input type="tel" name="phone" id='phone' required maxlength="15"><br>
                            <label for='phone'>Contact Phone</label>
                        </div>
                        <div class='input-field col s12'>
                            <input type="text" name="website" id='website' maxlength="50"><br>
                            <label for='website'>Website <i>(If you have one)</i></label>
                        </div>
                        <span class='divider col s12'></span>
                        <h5 class='col s12'>Availability</h5>
                        <div class='row col s12'>
                            <div class='col s12 m6'>
                                <label>Hours Available</label><br>
                                <label>
                                <input type="radio" name='hours' value='0' checked class='with-gap'> <span>24 hours</span>
                                </label><br>
                                <label>
                                <input type="radio" name='hours' value='1' class='with-gap'> <span>8:00 am - 5:00 pm</span>
                                </label><br>
                                <label>
                                <input type="radio" name='hours' value='2' class='with-gap'> <span>8:00 am - 8:00 pm</span>
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
                                <input type="radio" name='lunchhours' value='0' checked class='with-gap'> <span>No lunch break</span>
                                </label><br>
                                <label>
                                <input type="radio" name='lunchhours' value='1' class='with-gap'> <span>1:00 pm - 2:00 pm</span>
                                </label><br>
                                <div id='ajax_lunch_hours'>
                                    <?php
                                        $handler->getLunchHours();
                                    ?>
                                </div>
                                <a class='btn-floating modal-trigger' href='#lunchhours-modal'><i class='material-icons'>add</i></a> Add Custom
                            </div>
                        </div>
                        <div>
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
                    </div>
                    <input type='hidden' name='package' value='<?php echo $_GET['type']?>'>
                    <p id='error' class='message col s12 red-text'></p>
                    <p id='success' class='message col s12 green-text'></p>
                    <div class='col s12'><?php report()?></div>
                    <div class='col s12'>
                        <input type="submit" value="Upload" name="requeststall" class='btn-small green'>                
                    </div>
                </form>
                <div id='hours-modal' class='modal change'>
                    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_add_hours(this)">
                        <h5>Add Custom Hours</h5>
                        <label>From</label>
                        <div class='input-field'>
                            <input type="time" name='from'>
                        </div>
                        <label>To</label>
                        <div class='input-field'>
                            <input type="time" name='to'>
                        </div>
                        <p id='err-hours' class = 'error'></p>
                        <input type="submit" value='Save' class='btn-small green'>
                    </form>
                </div>
                <div id='lunchhours-modal' class='modal change'>
                    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
                    <form onsubmit="return validate_add_lunch_hours(this)">
                        <h5>Add Custom Lunch Hours</h5>
                        <label>From</label>
                        <div class='input-field'>
                            <input type="time" name='from'>
                        </div>
                        <label>To</label>
                        <div class='input-field'>
                            <input type="time" name='to'>
                        </div>
                        <p id='err-lunch-hours' class='error'></p>
                        <input type="submit" value='Save' class='btn-small green'>
                    </form>
                </div>
            </div>
        </div>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>