<?php
include_once("config.php");
/**
 * @author mxsxs2  
 * @copyright 2015
 */
class getNXT{
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
        $this->extractJSONArray();
        $this->Transaction=array();
        
    }
    private function fetchJSON(){
        $answer=file_get_contents($this->URL."requestType=getAccountTransactions&account=".$this->Wallet);
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
                            //print_r($this->Transaction);
                            //$this->Transaction[$k]["validMessage"]="false";
                            //$this->Transaction[$k]["message"]= "none";
                           /* foreach($v as $k2=>$v2){
                                switch($k2){
                                    case "senderRS":
                                        $this->Transaction[$k][$k2]=$v2;
                                        break;
                                    case "timestamp":
                                        $this->Transaction[$k][$k2]=date("d/m/Y H:i:s",$v2+$this->BlockTime);
                                        break;
                                    case "amountNQT":
                                        $this->Transaction[$k][$k2]=$v2/100000000;
                                        break;
                                    case "attachment":
                                        /*if($v2["messageIsText"]){
                                            $this->Transaction[$k]["message"]=$v2["message"];
                                            $mess=preg_split("/ /",$v2["message"]);
                                            $option=false;
                                            $message=false;
                                            if(count($mess)==2 || count($mess)==3){
                                                if(isset($mess[0]) && (is_numeric($mess[0]) || strtolower($mess[0])=="one"|| strtolower($mess[0])=="two"|| strtolower($mess[0])=="three"|| strtolower($mess[0])=="four")){
                                                    $this->Transaction[$k]["option"]=strtolower($mess[0]);
                                                    $option=true;
                                                }
                                                if(isset($mess[1]) && (is_numeric($mess[1]) || strtolower($mess[1])=="one"|| strtolower($mess[1])=="two"|| strtolower($mess[1])=="three"|| strtolower($mess[1])=="four")){
                                                    $this->Transaction[$k]["option"]=strtolower($mess[1]);
                                                    $option=true;
                                                }
                                                if(isset($mess[1]) && strlen($mess[1])==46){
                                                    $this->Transaction[$k]["nem"]=$mess[1];
                                                    $message=true;
                                                }else if(isset($mess[2])  && strlen($mess[2])==46){
                                                    $this->Transaction[$k]["nem"]=$mess[1];
                                                    $message=true;
                                                }
                                            }
                                            if($option && $message){
                                                $this->Transaction[$k]["validMessage"]="true";
                                            }
                                        }
                                        break;
                                        
                                }
                    
                            }*/
                        }
                    }
                }
            }
        }else{
            echo("nope");
        }
    }
    
    public function getTransactions(){
        return $this->Transaction;
    }
}
//$g=new getNXT($SOURCEURL["NXT"], $WALLET["NXT"]);
//print_r($g->getTransactions());

?>