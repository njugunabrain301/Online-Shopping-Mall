<?php

require_once "Utility.php";

class Database extends Utility{
    private $database = "payapico_shoppingmall";
    private $user = "payapico_mall";
    private $password = "icdattCwsm1493";
    private $server = "localhost";
    private $charset = "utf8";
    private $debug = "true";
    
    private function connect(){
        try{
            $dsn = "mysql:host=".$this->server.";dbname=".$this->database.";charset".$this->charset;
            
            $connection = new PDO($dsn, $this->user, $this->password);
            
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $connection;
        }catch(Exception $e){
            echo "Connection failed: ".$e->getMessage();
            die;
        }
    }
    
    public function query($query, $array){

            $query = str_replace('db.',$this->database.'.', $query);
            $run = $this->connect()->prepare($query);
            try{
                $run->execute($array);
                return $run;
            }catch(Exception $e){
                if($this->debug == "true"){
                    echo "Connection failed: ".$e->getMessage();
                    die;   
                }
                header("Location:../message.php");
            }
        }

}


?>