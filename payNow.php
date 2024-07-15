
    <?php

    class Payment{
        function pay(){
            
            $callback =  str_replace("\\",'/',"http://".$_SERVER['HTTP_HOST'].substr(getcwd(),strlen($_SERVER['DOCUMENT_ROOT'])))."/callback.php";
            
            $inv = md5(microtime());
            $amount = $_GET['ttl'];
            $tel = $_GET['tel'];
            $email = $_GET['eml'];
            $currency = $_GET['curr'];
            @session_start();
            $_SESSION["$inv"] = $amount;
            $fields = array("live"=> "0",
                    "oid"=> "EnigmaDonation",
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

    if(isset($_GET['donate'])){
        $payment = new Payment();
        $payment->pay();
    }

    ?>

<html>
    <head>
        <title>Enigma Enterprise</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Comfortaa:300|Nunito&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class='content'>
            <h1>Enigma Enterprise</h1>
            <h2 class='banner'>Donate today and own a share of our startup company</h2>
            <h3>Who are we?</h3>
            <p>We are an upcoming Company aiming to set up Metropolitan Area Networks (MAN) in our University. These networks will be used by students for the sharing of information, study materials, university updates and any other relevant information. It will be free and accessible to all campus staff. Currently we are short of funds and that is why we are asking for the public's help. We will greatly appreciate any amount you can give us. Thank you in advance! </p>
            <h3>Become a part of our technological development</h3>
             <form action="index.php">
                <h1>Donate Here</h1>
                <label>Amount</label><br><input name="ttl" type="number" min="1" required><br>
                <label>Phone Number</label><br><input name="tel" type="phone" value="" required><br>
                <label>Email</label><br><input name="eml" type="email" value="" required><br>
                <label>Currency</label><br><select name="curr">
                    <optgroup>
                        <option>KES</option>
                        <option>USD</option>
                    </optgroup>
                 </select><br>

            <button type="submit" name='donate'> Donate </button>

            </form>
        </div>
    </body>
</html>