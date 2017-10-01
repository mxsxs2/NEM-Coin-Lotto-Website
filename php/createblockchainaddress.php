<?php

/**
 * @author mxsxs2
 * @copyright 2015
 */

include("config.php");
class CreateBlockchainWallet extends Secure{
    Private $RESPONSE;
    Private $Time;
    Private $rnd;
    Private $Pswd;
    Private $NewAddress;
    Private $Guid;
    Private $Inserted;
    public function __construct(){
        $this->Time=date("Y-m-d H:i:s");
        $this->rnd=rand(0, 999999999999999999);
        $this->Pswd="";
        require_once("pswd.php");
        $p=new Password();
        $this->Pswd=$p->create($this->Time,$this->rnd);
        if($this->Pswd!="") $this->CreateNewWallet();
    }

    private function Send_Request(){
        $api_code="daaa9b8c-fa02-46c4-b5a7-5efe11538f15";
        $mail="nem@mxsxs2.info";
        $content="password=".$this->Pswd."&api_code=".$api_code."&email=".$mail;
        //echo("<--Sends-".$this->Pswd."->");
        $Curl=curl_init();
        curl_setopt($Curl, CURLOPT_URL,"https://blockchain.info/hu/api/v2/create_wallet");
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
            if(isset($RESPONSE["guid"], $RESPONSE["address"])){
                $this->Guid=$RESPONSE["guid"];
                $this->NewAddress=$RESPONSE["address"];
            }
        }
        //echo("response: <br>".$this->Answer);
        curl_close($Curl);
    }
    private function InsertWallet(){
        if(strlen($this->NewAddress)>15){
            require_once("function.php");
            $i=$this->insert("btcwallet","`guid`,`address`,`time`,`rnd`","'".$this->Guid."','".$this->NewAddress."','".$this->Time."','".$this->rnd."'");
            $this->Inserted=$i;  //$i is redundant. either true or false;
        }else{
            $this->Inserted=false;
        }
    
    }
    private function CreateNewWallet(){
        $this->Send_Request();
        $this->InsertWallet();
        //if(!$this->Inserted) $this->CreateNewAddress();  //if not created or saved then loop back to create one
    }
    public function get_Wallet(){
        return array($this->Guid, $this->Inserted);
    }
}

$c=new CreateBlockchainWallet();
print_r($c->get_Wallet());
?>