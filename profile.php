<?php
    require_once "authentication.php";

    authenticateLoggedIn();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> My Profile <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content id='profile-content'>
            <h4 class='center-align'>My Profile</h4>
            <div class='profile' id='ajax'>
                <?php  
                    
                    $handler->getProfile();
                ?>
            </div>
            <div id='divImage' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Change Image</h5>
                <form action='backend/User.php' onsubmit='return validate_profile_change(this, "changeImage")' enctype="multipart/form-data" method='post'>
                    <label>Select New Image</label><br>
                    <input type='hidden' name='manageProfile' value='set'>
                    <div class='file-field input-field'>
                        <div class='btn-small grey'>
                            <span>Select Image</span>
                            <input type="file" name='new' required><br>
                        </div>
                        <div class='file-path-wrapper'>
                            <input class='file-path' type='text' id='image2' placeholder='Upload File'>
                        </div>
                    </div>
                    <p id='error' class='message changeImage red-text'></p>
                    <input type="submit" name='changeImage' value='Save Image' class='btn-small green'>
                </form>
            </div>
            <div id='divFname' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h2>Change First Name</h2>
                <form action='backend/User.php' onsubmit='return validate_profile_change(this, "fname")'>
                    <input type='hidden' name='manageProfile' value='set'>
                    <p id='error' class='message fname red-text'></p>
                    <label for='fname' class=" center-align">Enter New First Name</label>
                    <div class="input-field center-align">
                        <input id="fname" name='new' type="text" required maxlength="20"><br>
                    </div>
                    <input type="submit" name='changeFname' value='Save' class='btn-small'> 
                </form>
            </div>
            <div id='divLname' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h2>Change Last Name</h2>
                <form action='backend/User.php' onsubmit='return validate_profile_change(this, "lname")'>
                    <label>Enter new Last Name</label><br>
                    <div class="input-field center-align">
                        <input type="text" name='new' id='lname' required maxlength="20"><br>
                    </div>
                    <p id='error' class='message lname red-text'></p>
                    <input type='hidden' name='manageProfile' value='set'>
                    <input type="submit" name='changeLname' value='Save' class='btn-small'>
                </form>
            </div>
            <div id='divEmail' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h2>Change Email</h2>
                <form action='backend/User.php' onsubmit='return validate_profile_change(this, "email")'>
                    <label>Enter new Email</label><br>
                    <div class="input-field center-align">
                        <input type="email" name='new' required maxlength="40"><br>
                    </div>
                    <p id='error' class='message email red-text'></p>
                    <input type='hidden' name='manageProfile' value='set'>
                    <input type="submit" name='changeEmail' value='Save' class='btn-small'>
                </form>
            </div>
            <div id='divPhone' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h2>Change Phone Number</h2>
                <form action='backend/User.php' onsubmit='return validate_profile_change(this, "phone")'>
                    <label>Enter new Phone Number</label><br>
                    <div class="input-field center-align">
                        <input type="tel" name='new' required maxlength="15"><br>
                    </div>
                    <p id='error' class='message phone red-text'></p>
                    <input type='hidden' name='manageProfile' value='set'>
                    <input type="submit" name='changePhone' value='Save' class='btn-small'>
                </form>
            </div>
            <div id='divIdnum' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h2>Change ID Number</h2>
                <form action='backend/User.php' onsubmit='return validate_profile_change(this, "idno")'>
                    <p>You are not allowed to change your ID number. Please contact the Administrator</p><br>
                </form>
            </div>
            <div id='divPassword' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h2>Change Password</h2>
                <form action='backend/User.php' onsubmit='return validate_profile_change(this, "password")'>
                    <label>Enter old password</label><br>
                    <div class="input-field">
                        <input type="password" name='old' required minlength="6" maxlength="50"><br>
                    </div>
                    <label>Enter new password</label><br>
                    <div class="input-field">
                        <input type="password" name='new' required minlength="6" maxlength="50"><br>
                    </div>
                    <label>Confirm new password</label><br>
                    <div class="input-field">
                        <input type="password" name='cnew' required minlength="6" maxlength="50"><br>
                    </div>
                    <p id='error' class='message password red-text'></p>
                    <input type='hidden' name='manageProfile' value='set'>
                    <input type="submit" name='changeFname' value='Save' class='btn-small'>
                </form>
            </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
        <script type="text/javascript" src='js/editing.js'></script>
    </body>
</html>