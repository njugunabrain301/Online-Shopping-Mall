<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Reset Password <?php echo "| ".$title ?></title>
    </head>
    <body>
        <content>
            <div id='divPassword' class='change'>
                <h4>Reset Password</h4>
                <form action='backend/User.php' onsubmit='return validate_password_reset(this)'>
                    <label>Enter new password</label><br>
                    <div class="input-field">
                        <input type="password" name='new' required minlength="6" maxlength="50"><br>
                    </div>
                    <?php
                        $key = "";
                        if(isset($_GET['key'])){
                            $key = $_GET['key'];
                        }
                    ?>
                    <label>Confirm new password</label><br>
                    <div class="input-field">
                        <input type="password" name='cnew' required minlength="6" maxlength="50"><br>
                    </div>
                    <input type="hidden" name="key" value="<?php echo $key; ?>">
                    <p id='reset-password-error' class='message password red-text'></p>
                    <input type="submit" name='passwordReset' value='Save' class='btn-small'>
                </form>
            </div>
        </content>
    </body>
</html>