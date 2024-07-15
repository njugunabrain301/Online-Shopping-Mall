<?php

class Payment{
    
    function pay(){

        $callback =  str_replace("\\",'/',"http://".$_SERVER['HTTP_HOST'].substr(getcwd(),strlen($_SERVER['DOCUMENT_ROOT'])))."/callback.php";

        $inv = $_POST['id'];
        $amount = $_POST['amount'];
        $tel = $_POST['tel'];
        $email = $_POST['eml'];
        $currency = "KSH";
        @session_start();
        $_SESSION["$inv"] = $amount;
        $fields = array("live"=> "0",
                "oid"=> "Shop Online",
                "inv"=> $inv,
                "ttl"=> $amount,
                "tel"=> $tel,
                "eml"=> $email,
                "vid"=> "demo",
                "curr"=> $currency,
                "p1"=> $inv,
                "p2"=> "",
                "p3"=> "",
                "p4"=> "",
                "cbk"=> $callback,
                "cst"=> "1",
                "crl"=> "2"
                );

        $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];

        $hashkey ="demoCHANGED";

        $generated_hash = hash_hmac('sha1',$datastring , $hashkey);

        $parameters =  "";
         foreach ($fields as $key => $value) {
             if($parameters == ""){
                 $parameters .= "?$key=$value";
             }else{

                 $parameters .= "&$key=$value";
             }
         }
        $parameters.= "&hsh=$generated_hash";

        header("Location: https://payments.ipayafrica.com/v3/ke$parameters");
    }
}

if(isset($_GET['pay'])){
    $payment = new Payment();
    $payment->pay();
}

?>