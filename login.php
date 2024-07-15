<?php
    @session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Login <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            <?php
                $num = rand(1,10);
            ?>
            <div class='form form-small login'>
                <img src='images/website/login<?php echo $num?>.jpg'>
                <div class='right'>
                    <img src='images/website/menu-bg.jpg'>
                    <div class='container'>
                        <form action='backend/User.php' method='post'>
                            <h4 id='log-in-title'>Log In</h4>
                            <div class='input-field'>
                                <input type="email" name='email' id='email' required><br>
                                <label for='email'>Email</label>
                            </div>
                            <?php
                                $redirectTo = "index.php";
                                if(isset($_GET['redirectTo'])){
                                    $redirectTo = $_GET['redirectTo'];
                                }
                            ?>
                            <input type='hidden' name='redirectTo' value='<?php echo urlencode($redirectTo); ?>'>
                            <div class='input-field'>
                                <input type='password' name='password' id='password' required><br>
                                 <label for='password'>Password</label>
                            </div>
                            <p>
                                <label>
                                    <input type='checkbox' name='stayLoggedIn'>
                                    <span>Keep me logged in</span>
                                </label>
                            </p>
                            
                            <input type="hidden" id='user-type' name='type' value='customer'>
                            
                            <p id='error' class='message red-text'></p>
                            <p id='success' class='message green-text'></p>
                            <?php report()?>
                            <button type="submit" name='login' class='btn-small green' style="margin-top: 7px"p>Log In</button> 
                        </form>
                    </div>
                    <div class='row' style="width: 100%; margin-top: 10px; position: absolute; bottom: 0px; height: 7px;">
                            <a class='blue-text col s3' onclick='toggleUserType(this)'>Tenant</a>
                            <a class='blue-text col s6 modal-trigger center-align' href="#forgot-password-modal" >Forgot Password</a>
                            <a class='col s3 right-align' href='register.php'>Register</a>
                        </div>
                </div>
            </div>
            <div id='forgot-password-modal' style="display:none" class='change modal'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h2>Forgot Password</h2>
                <form action='backend/User.php' onsubmit='return validate_forgot_password(this)'>
                    <label>Enter your email address</label><br>
                    <div class="input-field center-align">
                        <input type="email" name='email' required maxlength="50"><br>
                    </div>
                    <p id='forgot-password-error' class='message red-text'></p>
                    <input type="submit" name='forgotPassword' value='Submit' class='btn-small green'>
                </form>
            </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>