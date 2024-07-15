
<?php
    
    $val = "demo"; //assigned iPay Vendor ID... hard code it here.
    /*
    these values below are picked from the incoming URL and assigned to variables that we
    will use in our security check URL
    */
    $val1 = $_GET["id"];
    $val2 = $_GET["ivm"];
    $val3 = $_GET["qwh"];
    $val4 = $_GET["afd"];
    $val5 = $_GET["poi"];
    $val6 = $_GET["uyt"];
    $val7 = $_GET["ifd"];

    $iPayResponse = "{ \"response\": {";
    $dbString = "insert into db.ipay_payments ";
    $colNames = "(";
    $values = " values (";
    $valuesArray = [];
    foreach($_GET as $key => $value){
        if($iPayResponse != "{ \"response\": {"){
            $iPayResponse .= ",";
            $colNames.=", ";
            $values.=", ";
        }
        $iPayResponse .= "\"$key\":\"$value\"";
        $colNames.=$key;
        $values.="?";
        array_push($valuesArray, $value);
    }
    $iPayResponse.="}, ";

    $logFile = "data/iPayResponse.log";
 
    $log = fopen($logFile, "a");

    fwrite($log, $iPayResponse);

    fclose($log);

    $ipnurl = "https://www.ipayafrica.com/ipn/?vendor=".$val."&id=".$val1."&ivm=".$val2."&qwh=".$val3."&afd=".$val4."&poi=".$val5."&uyt=".$val6."&ifd=".$val7;

    $fp = fopen($ipnurl, "rb");
    $status = stream_get_contents($fp, -1, -1);
    fclose($fp);
    //the value of the parameter “vendor”, in the url being opened above, is your iPay assigned
    //Vendor ID.
    //this is the correct iPay status code corresponding to this transaction.
    //Use it to validate your incoming transaction(not the one supplied in the incoming url)

    //continue your shopping cart update routine code here below....
    $inv = $_GET['p1'];
    $amtSent = $_GET['mc'];
    $txncd = $_GET['txncd'];
    $successful = false;
    $message = "blank";
    if($amtRequired != $amtSent){
        $message = 'Invalid amount';
    }else if($status == "fe2707etr5s4wq"){
        $message = 'Failed';
    }else if($status == "aei7p7yrx4ae34"){
        $message = 'Success';
        $successful = true;
    }else if($status == "bdi6p2yy76etrs"){
        $message = 'Pending'; 
    }else if($status == "cr5i3pgy9867e1"){
        $message = 'Used';
    }else if($status == "dtfi4p7yty45wq"){
        $message = 'Less'; 
    }else if($status == "eq3i7p5yt7645e"){
        $message = 'More';
    }
    
    $colNames .= ", statusResponse, message)";
    $values .= ", ?, ?)";
    array_push($valuesArray, $status);
    array_push($valuesArray, $message);
    
    $validationResult = "\"validation\": {\"message\":\"$message\", \"status\":\"$status\"} }\n";
    $logFile = "data/iPayResponse.log";
 
    $log = fopen($logFile, "a");

    fwrite($log, $validationResult);

    fclose($log);
    
    //then redirect to to the customer notification page here...
    
    require_once "Tenant.php";
    $tenant = new Tenant();
    if($successful){
        $tenant->makePayment($inv, $amtSent, $txncd);
    }
    $query = $dbstring.$colNames.$values;
    $tenant->recordPayment($query, $valuesArray);
    $url = "invoice.php?message=$message&successsful=$successful";
    $utility->goToPage($url);
?>

