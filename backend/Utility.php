<?php
@session_start();
class Utility{
    
    function report(){
        print_r($_SESSION);
        echo "here";
        die;
        if(isset($_SESSION['error'])){
            $mess = $_SESSION['error'];
            echo "<p id='error' class='message red-text'>$mess</p>";
            unset($_SESSION['error']);
        }else if (isset($_SESSION['success'])){
            $mess = $_SESSION['success'];
            echo "<p id='success' class='message green-text'>$mess</p>";
            unset($_SESSION['success']);
        }
    }
    
    public function encode($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    function goToPage($url){
        @header("Location: $url");
        print_r($_SESSION);die;
        echo "<script>window.open('$url','_self');</script>";
        die();
    }
    
    function checkLoggedIn(){
        if(!isset($_SESSION['id'])){
            $this->goToPage("../login.php");
        }
    }
    
    function isLoggedIn(){
        if(!isset($_SESSION['id'])){
            return false;
        }else{
            return true;
        }
    }
    
    function checkAdmin(){
        if($_SESSION['type'] != 'ADMIN'){
            echo "not admin type is ".$_SESSION['type'];
//            $this->goToPage("../login.php");
        }
    }
    
    function isAdmin(){
        if($_SESSION['type'] == 'ADMIN'){
            return true;
        }
        return false;
    }
    
    function formatTime($str){
        $suffix = "am";
        $str = (int) $str;
        if($str == 1200){ 
            $suffix = "noon";
        }else if($str > 1200){
            $suffix = "pm";
            if($str > 1259){
                $str-=1200;
            }
        }
        $out = "".$str;
        if(strlen($out) < 4)
            $out= " ".$out;
        $ret = substr($out,0,2).":".substr($out,2)." ".$suffix;
        return $ret;
    }
    
    function formatDate($str){
        $date = strtotime($str);
        return date('M j, Y', $date);
    }
    
    function sendEmail($to,$from, $name ,$subj, $msg){
        return smtpmailer($to,$from, $name ,$subj, $msg);
    }
}

if(isset($_GET['isLoggedIn'])){
    $utility = new Utility();
    
    if($utility->isLoggedIn()){
        $email = $_SESSION['email'];
        $phone = $_SESSION['phone'];
        echo '{"okay": true, "email": "'.$email.'", "phone": "'.$phone.'"}';
    }else{
        echo '{"okay": false}';
    }
}

?>