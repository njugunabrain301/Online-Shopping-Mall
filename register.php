<?php
    @session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Register <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            <?php
                $num = rand(1,5);
            ?>
            <div class='form register form-small'>
                <img src="images/website/register<?php echo $num?>.jpg">
                <div class='right'>
                    <img src="images/website/menu-bg.jpg">
                    <div class='container'>
                        <form action='backend/User.php' onsubmit="return validate_register(this)" method='post'>
                            <h4>Register</h4>
                            <div class='input-field'>
                                <input type="text" name='fname' id='fname' required maxlength="20"><br>
                                <label for='fname'>First Name</label><br>
                            </div>
                            <div class='input-field'>
                                <input type="text" name='lname' id='lname' required maxlength="20"><br>
                                <label for='lname'>Last Name</label><br>
                            </div>
                            <div class='input-field'>
                                <input type="text" name='idnum' id='idnum' required maxlength="12"><br>
                                <label for='idnum'>ID Number</label><br>
                            </div>
                            <div class='input-field'>
                                <input type="text" name='phone' id='phone' required maxlength="15"><br>
                                <label for='phone'>Phone Number</label><br>
                            </div>
                            <div class='input-field'>
                                <input type="email" name='email' id='email' required maxlength="40"><br>
                                <label for='email'>Email</label><br>
                            </div>
                            <div class='input-field'>
                                <input type='password' name='password' id='password' required minlength="6" maxlength="50"><br>
                                <label for='password'>Password</label><br>
                            </div>
                            <div class='input-field'>
                                <input type="password" name='cpassword' id='cpassword' required minlength="6" maxlength="50"><br>
                                <label for='cpassword'>Confirm Password</label><br>
                            </div>
                            <p id='error' class='message red-text'></p>
                            <p id='success' class='message green-text'></p>
                            <?php report()?>
                            <input type='submit' name='register' value='Register' class='btn-small green'>
                        </form>
                    </div>
                    <div class='row' style="width: 100%; margin-top: 10px; position: absolute; bottom: 0px; height: 7px;">
                            <a class='col s12 right-align' href='login.php'>Log In</a>
                        </div>
                </div>
            </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>