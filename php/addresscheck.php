<?php
include_once("config.php");
class addressChecker{
    private $URL="";
    private $Address="";
    private $Currency="";
    private $Source;
    private $Curl;
    private $Answer;
    public function __Construct($POST, $SOURCEURL){
        $this->addPOST($POST);
        $this->Source=$SOURCEURL;
        $this->Curl=curl_init();
        $this->setURL();
        $this->callCurl();
        $this->checkAnswer();
    }
    private function addPOST($POST){
        if(isset($POST["a"])){
            $this->Address=mysql_real_escape_string($POST["a"]);
        }
        if(isset($POST["t"])){
            $this->Currency=strtoupper($POST["t"]);
        }
    }
    private function setURL(){
        if($this->Currency=="NXT"){
            $this->URL=$this->Source["NXT"]."requestType=getAccount&account=".$this->Address;
        }else if($this->Currency=="BTC"){
            $this->URL=$this->Source["BTC"]."address/".$this->Address."?format=json";
        }else if($this->Currency=="NEM"){
            $this->URL=$this->Source["NEM"]."account/get?address=".$this->Address;
        }else{
             throw new Exception("Wrong currency: ".$this->Currency);
        }
    }
    private function callCurl(){
        //echo($this->URL);
        curl_setopt($this->Curl, CURLOPT_URL,$this->URL);
        curl_setopt($this->Curl, CURLOPT_USERAGENT, 'Blockchain-PHP/1.0');
        curl_setopt($this->Curl, CURLOPT_CAINFO, __DIR__.'\..\ca-bundle.crt');
        curl_setopt($this->Curl, CURLOPT_HEADER, false);
        curl_setopt($this->Curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->Curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->Curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($this->Curl, CURLOPT_POST, false);
        curl_setopt($this->Curl, CURLOPT_HTTPHEADER, array());
        $this->Answer = curl_exec($this->Curl);
        if(curl_error($this->Curl)) throw new Exception("Connection error."); //curl_error($this->Curl) to get error message
        curl_close($this->Curl);
    }
    private function  checkAnswer(){
        $JSONArray=(array) json_decode($this->Answer, true);
        $error=0;
        //print_r($JSONArray);
        if($this->Currency=="NXT" && isset($JSONArray["errorCode"]))  $error=1; 
        if($this->Currency=="NEM" && !isset($JSONArray["account"]))   $error=1; 
        if($this->Currency=="BTC" && !isset($JSONArray["address"]))   $error=1;
        if($error!=0) throw new Exception ("Invalid account.");
    }
}
if(isset($_POST) || isset($_GET)){
    try{
        if(isset($_POST["t"],$_POST["a"])) $p=$_POST;
        if(isset($_GET["t"],$_GET["a"]))  $p=$_GET;
        $checker= new addressChecker($p, $SOURCEURL);
        echo(1);
    }catch(Exception $e){
        echo($e->getMessage());
    }
}
?>