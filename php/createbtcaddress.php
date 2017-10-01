<?php

/**
 * @author asdfg
 * @copyright 2015
 */

include_once("config.php");
class CreateBTCAddress extends Secure{
    Private $Wallet;
    Private $NewAddress;
    Private $Nemaddress;
    Private $Option;
    public function __construct($nem,$option){
        $this->NewAddress="";
        $this->Nemaddress=$nem;
        $this->Option=$option;
        $this->checkWallet();
        $this->createNewAddress();
    }
    private function checkWallet(){
        $sql=mysql_query("SELECT `guid`,`time`,`rnd`,`SID` FROM `btcwallet`,`session` WHERE `session`.`SID`=`btcwallet`.`session` ORDER BY `session`.`sid` DESC LIMIT 1 ");
        if(mysql_num_rows($sql)<1) throw Error("We have some technical difficulties please try again later.");
        $this->Wallet=mysql_fetch_assoc($sql);
    }
    private function getPassword(){
        require_once("pswd.php");
        $p=new Password();
        return $p->create($this->Wallet["time"],$this->Wallet["rnd"]);
    }
    private function createNewAddress(){
        $api_code="daaa9b8c-fa02-46c4-b5a7-5efe11538f15";
        $content="password=".$this->getPassword()."&label=".$this->Wallet["SID"]."_".$this->Option."_".$this->Nemaddress."&api_code=".$api_code;
        //echo("<--Sends-".$this->Pswd."->");
        $Curl=curl_init();
        curl_setopt($Curl, CURLOPT_URL,"https://blockchain.info/hu/merchant/".$this->Wallet["guid"]."/new_address");
        curl_setopt($Curl, CURLOPT_USERAGENT, 'Blockchain-PHP/1.0');
        curl_setopt($Curl, CURLOPT_CAINFO, __DIR__.'\..\ca-bundle.crt');
        curl_setopt($Curl, CURLOPT_HEADER, false);
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($Curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        curl_setopt($Curl, CURLOPT_POST, true);
        curl_setopt($Curl, CURLOPT_POSTFIELDS, $content);
        $this->Answer = curl_exec($Curl);
        if(curl_error($Curl)){
            $RESPONSE=curl_error($Curl);
        }else{
            $RESPONSE=(array) json_decode($this->Answer, true);
            if(isset($RESPONSE["address"])){
                $this->NewAddress=$RESPONSE["address"];
            }
        }
        curl_close($Curl);
    }
    public function getNewAddress(){
        if($this->NewAddress=="") return false;
        return $this->NewAddress; 
    }
}
    
?>