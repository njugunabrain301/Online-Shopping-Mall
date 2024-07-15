<?php

require_once "Database.php";
@session_start();
class User extends Database{
    
    function __construct(){
        
    }
    
    function login(){
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $type = $_POST['type'];
        $modal = false;
        $redirectTo = $_POST['redirectTo'];
        $stayLoggedIn = isset($_POST['stayLoggedIn']) ? $_POST['stayLoggedIn'] : "off";
        
        if(isset($_POST['modal'])){
            $modal = true;
        }
                
        $result = $this->query("SELECT * from db.user WHERE email=?",[$email]);
        @session_start();
        if($result->rowCount() == 0){
            $_SESSION['error'] = "No such user";
            if(!$modal){
                $this->goToPage("../login.php");
            }
        }else{
            while($row = $result->fetch()){
                if(password_verify($pass, $row['password'])){
                    $_SESSION['firstname'] = $row['firstname'];
                    $_SESSION['email'] = $email;
                    $_SESSION['type'] = $type;
                    $_SESSION['id']=$row['id'];
                    $_SESSION['phone'] = $row['phone'];
                    $rank = $row['type'];
                    $ext = $row['ext'];
                    $imgPath = 'images/users/'.$row['id'].".".$ext;
                    if(!file_exists("../".$imgPath)){
                        $imgPath = 'images/users/default.png';
                    }
                    
                    if($stayLoggedIn == "on"){
                        $rememberCode = password_hash($email.$id.$type.microtime(), PASSWORD_DEFAULT);
                        $rememberCode = md5($rememberCode);
                        setcookie("id",$rememberCode, (time() + (86400 * 180)) , "/");
                        setcookie("type", $type, (time() + (86400 * 180)) , "/");
                        $this->query("update db.user set remember_me = ? where id = ?",[$rememberCode, $row['id']]);
                    }
                    
                    $_SESSION['profile-image']=$imgPath;
                    if($ext == "" || $ext == NULL){
                        $_SESSION['profile-image']='images/users/default.png';
                    }
                    if($rank=='ADMIN'){
                        $_SESSION['type'] = $rank;
                        if(!$modal){
                           $this->goToPage("../AdminDashboard.php"); 
                        }
                    }else if($type == "tenant"){
                        if(!$modal){
                            $this->goToPage("../TenantDashboard.php"); 
                        } 
                    } else {
                        if(!$modal){
                            if($redirectTo == "index.php"){
                                $this->goToPage("../index.php"); 
                            }else{
                                $this->goToPage(urldecode($redirectTo));    
                            }
                        } 
                    }
                }else{
                    $_SESSION['error'] = "Wrong password";
                    if(!$modal){
                        $this->goToPage("../login.php");
                    }
            
                }
            }
        }
    }
    
    function register(){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $id_num = $_POST['idnum'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $result = $this->query("SELECT * FROM db.user WHERE email = ?",[$email]);
        if($result->rowCount() > 0){
            $this->goToPage("../register.php?error=Email already in use");
        }else{
            
            $result = $this->query("INSERT INTO db.user (firstname, lastname, id_number, email, phone, password, verification_key) VALUES(?,?,?,?,?,?,?)",[$fname, $lname, $id_num, $email, $phone, password_hash($password, PASSWORD_DEFAULT),"not sent"]);

            $this->sendVerifyLink($email);
            $_SESSION['success'] = "Registration Successfull";
            $this->goToPage("../login.php");
        }
    }
    
    //Go through to check credentials
    function sendVerifyLink($email){
        $vkey = md5(microtime().$email);
            
        $verifyLink = "https://www.buynsell.co.ke/v2/php/handler.php?mess=verify&key=$vkey&email=$email";
        $to = $email;
        $subj = "Email verification";
        $msg = "<center>Thank you for joining the BuynSell Community.<br>Click the link below to verify your email account and complete your registration<br><br><br><a id = 'mylink' href= '$verifyLink' style='padding: 15px; margin: 10px; background-color: #008ecc; color: white; cursor: pointer; box-shadow: 0px 0px 5px grey; text-decoration: none; font-family: serif;' >Verify Email</a><br><br></center>";
        $from = 'response@buynsell.co.ke';
        $name = 'Buy n\' Sell';

        $result = $this->sendEmail($to,$from, $name ,$subj, $msg);
        
        if($result){
            $this->query("update","users","set verification_key = ? where email = ?",[$vkey, $email]);
            header("Location:../message.php?message=Registration successful.<br>Now you need to verify your email to complete the registration.<br>We have sent a verification link to the email you provided.&redirectTo=login.php");
        }else{
            $this->query("delete from","users","where email = ?",[$email]);
            header("Location:../message.php?message=Unable to send verification email<br>Please try again after some time&redirectTo=login.php");
        }
    }
    
    //Go through to verify compatibility
    function verify(){
        if(isset($_GET['key'])){
            $res = $this->query("select * from","users","where verification_key = ?",[$_GET['key']]);
            if($res->rowCount() == 0){
                
                if(isset($_GET['email'])){
                    $res = $this->query("select * from","users","where email = ?",[$_GET['email']]);
                    if($res->rowCount() == 0){
                        header("Location: ../message.php?message=Invalid verification key&redirectTo=login.php");
                    }else{
                        $row = $res->fetch();
                        if($row['verified'] == 1){
                            header("Location: ../message.php?message=Email is already verified&redirectTo=login.php");
                        }else{
                            header("Location: ../message.php?message=Invalid verification key&redirectTo=login.php");  
                        }
                    }   
                }else{
                    header("Location: ../message.php?message=Invalid verification key&redirectTo=login.php"); 
                }
                
            }else{
                $this->query("update","users","set verified = ?, verification_key = ? where verification_key = ?",[1, "verified",$_GET['key']]);
                header("Location: ../message.php?message=Email verification successful&redirectTo=login.php");
            }
        }else{
            header("Location: ../message.php?message=Invalid verification key&redirectTo=login.php");
        }
    }
    
    function manageProfile(){
        $this->checkLoggedIn();
        $id = $_SESSION['id'];
        $new = $_POST['new'];
        if(isset($_POST['changeFname'])){
            $this->query("UPDATE db.user set firstname = ? where id = ?",[$new,$id]);
        }else if(isset($_POST['changeLname'])){
            $this->query("UPDATE db.user set lastname = ? where id = ?",[$new,$id]);
            echo "here in";
        }else if(isset($_POST['changePhone'])){
            $this->query("UPDATE db.user set phone = ? where id = ?",[$new,$id]);
        }else if(isset($_POST['changeEmail'])){
            
            $res = $this->query("SELECT * from db.user where email = ?",[$new]);
            
            if($res->rowCount() > 0){
                $_SESSION['email_error'] = "* Email already in use";
            }else{
                $this->query("UPDATE db.user set email = ? where id = ?",[$new,$id]);   
            }
        }else if(isset($_POST['changePass'])){
            $old = $_POST['old'];
            $res = $this->query("select * from db.user where id = ?",[$id]);
            $row = $res->fetch();
            if(password_verify($old, $row['password'])){
                $this->query("update db.user set password = ? where id = ?",[password_hash($new), $id]);
            }else{
                $_SESSION['password_error'] = "* Email already in use";
                
            }
        }else if(isset($_POST['changeImage'])){
            $res = $this->query("select ext from db.user where id = ?",[$id]);
            $row = $res->fetch();
            $ext = $row['ext'];
            $folder = "../images/users/";
            $type = strtolower(pathinfo($_FILES['new']['name'], PATHINFO_EXTENSION));
            unlink($folder.$id.".".$ext);
            $target_file = $folder.$id.".".$type;
            if (move_uploaded_file($_FILES["new"]["tmp_name"], $target_file)) {
                $uploadOk = 1;
                $this->query("update db.user set ext = ? where id = ?",[$type, $id]);
                $_SESSION['profile-image']='images/user/'.$id.".".$type;
            } else {
                $uploadOk = 0;
            }
            $this->goToPage("../profile.php");
        }
    }
    
    function logout(){
        @session_start();
        session_destroy();
        session_unset();
        setcookie("id","", -1,"/");
        setcookie("type","", -1,"/");
        $this->goToPage("../index.php");
    }
    
    function addView(){
        $pid = $_POST['pid'];
        $date = date('Y-m-d');
        $uid = $_SESSION['id'];
        $res = $this->query("select recorded_last from db.user where id = ?",[$uid]);
        
        $row = $res->fetch();
        
        if($row['recorded_last'] == $date){

        }else{
            $this->query("insert into db.views (product_id, day) values (?,?) on duplicate key update number_of_views = number_of_views + 1",[$pid, $date]);
            $this->query("update db.user set recorded_last = ? where id = ?",[$date, $uid]);
        }
    }
    
    function forgotPassword(){
        $email = $_POST['email'];
        
        $res = $this->query("select * from db.user where email = ?",[$email]);
        
        if($res->rowCount() == 0){
            echo '{ "okay": false,
                "message": "The email provided does not exist"
            }';
        }else{
            $row = $res->fetch();
            $res = $this->sendResetPasswordLink($row['id'], $email);
            
            if($res){
//                echo '{ "okay": true,
//                "message": "We have sent a password reset link to your email",
//                "link" : "'.$res.'"
//                }';
                
                echo '{ "okay": true,
                "message": "We have sent a password reset link to your email"
                }';
            }else{
                echo '{ "okay": false,
                "message": "We encountered a problem. Please try again after some time"
                }';
            }
        }
    }
    
    function sendResetPasswordLink($uid, $email){
        $key = md5($uid."_".microtime());
        $changeLink = "https://www.buynsell.co.ke/v2/resetPassword.php?key=$key";
        $to = $email;
        $subj = "Password Reset";
        $msg = "<center>We have received a request to change your password. Click the link below to complete the process. The link is valid for 20 minutes only. If this was not you then ignore this email.<br><br><br><a id = 'mylink' href= '$changeLink' style='padding: 15px; margin: 10px; background-color: #008ecc; color: white; cursor: pointer; box-shadow: 0px 0px 5px grey; text-decoration: none; font-family: serif;' >Reset password</a><br><br></center>";
        $from = 'response@buynsell.co.ke';
        $name = 'Buy n\' Sell';

//        $result = smtpmailer($to,$from, $name ,$subj, $msg);
        $result = true;
        if($result){
            $this->query("update db.user set reset_key = ?, reset_time = ? where email = ?",[$key, strtotime("now"), $email]);
            return $changeLink;
        }else{
            return false;
        }
    }
 
    function resetPassword(){
        $pass = $_POST['password'];
        $key = $_POST['key'];
        
        if($this->isPasswordResetKeyValid($key, "bool")){
            $this->query("update db.user set password = ? where reset_key = ?", [password_hash($pass, PASSWORD_DEFAULT), $key]);
            echo '{ "okay": true,
                "message": "Password was successfully updated. <a href=\'login.php\'>Log In?</a>"
            }';
        }else{
            echo '{ "okay": true,
                "message": "Invalid key. <a href=\'login.php\'>Try again?</a>"
            }';
        }
        
    }
    
    function isPasswordResetKeyValid($key, $type){
        $res = $this->query("select reset_time from db.user where reset_key = ?",[$key]);
        
        $ans = "";
        $bool = false;
        
        if($res->rowCount() == 0){
            $ans ='{ "okay": false,
                "message": "Invalid key"
            }';
        }else{
            $row = $res->fetch();
            $time = $row['reset_time'];
            $diff = strtotime("now") - $time;
            
            if($diff > 1200){
                $ans ='{ "okay": false,
                    "message": "Expired key"
                }';
            }else{
                $ans ='{ "okay": true,
                    "message": "Valid key"
                }';
                $bool = true;
            }
        }
        
        if($type == "bool"){
            return $bool;
        }else{
            return $ans;
        }
    }
}

function foward(){
    $user = new User();
    if(isset($_POST['register'])){
        $user->register();
    }else if(isset($_POST['login'])){
        $user->login();
    }else if(isset($_GET['logout'])){
        $user->logout();
    }else if(isset($_POST['manageProfile'])){
        $user->manageProfile();
    }else if(isset($_POST['addView'])){
        $user->addView();
    }else if(isset($_POST['forgotPassword'])){
        $user->forgotPassword();
    }else if(isset($_POST['resetPassword'])){
        $user->resetPassword();
    }else{
        $user->goToPage("../login.php");
    }
}

foward();
?>