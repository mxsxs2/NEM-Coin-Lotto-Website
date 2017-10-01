<?php
include_once("config.php");
/**
 * @author asdfg
 * @copyright 2015
 */

class getBTC{
    private $URL;
    private $Wallet;
    private $Transaction;
    private $JSONArray;
    private $BlockTime;
    private $Option=0;
    public function __Construct($URL,$Wallet, $option){
        $this->URL=$URL;
        $this->Wallet=$Wallet;
        $this->BlockTime=strtotime('2013-11-24 12:00:00'); //start of the blockchain
        $this->Option=$option;
        $this->fetchJSON();
        print_r($this->JSONArray);
        //$this->extractJSONArray();
        
    }
    private function fetchJSON(){
        echo($this->URL.$this->Wallet."?format=json");
        $answer=file_get_contents($this->URL.$this->Wallet."?format=json");
        $this->JSONArray=(array) json_decode($answer, true);
        
    }
    private function extractJSONArray(){
        if(is_array($this->JSONArray)){
            foreach($this->JSONArray as $key=>$val){
                if(is_array($val)){
                    foreach($val as $k=>$v){
                        if(is_array($v) && $v["recipientRS"]==$this->Wallet){
                            $this->Transaction[$k]["sender"]=$v["senderRS"];
                            $this->Transaction[$k]["timestamp"]=date("Y/m/d H:i:s",$v["timestamp"]+$this->BlockTime);
                            $this->Transaction[$k]["amount"]=$v["amountNQT"]/100000000;
                            $this->Transaction[$k]["id"]=$v["transaction"];
                            $this->Transaction[$k]["option"]=$this->Option;
                            $this->Transaction[$k]["currency"]="nxt";
                            print_r($this->Transaction);

                        }
                    }
                }
            }
        }
    }
    
    public function getTransactions(){
        return $this->Transaction;
    }
}
$btc= new getBTC($SOURCEURL["BTC"],"1DahoLhafgAqhgohSuyC7GboHsNqxHCCCT",1);
?>