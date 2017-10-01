<?php
/**
 * @author mxsxs2
 * @copyright 2015
 */
include_once("config.php");
class insertTransaction extends Secure{
    private $Transactions;
    private $Refund=false;
    private $Option;
    private $Answer;
    public function __Construct(){}
    public function __Init($Transaction){
        $this->Transactions=$Transaction;
        if($this->checkArray()){
            if($this->matchEntryRecords()){
                if($this->insertoDB()){
                    $this->addAnswer(1);
                }
            }
        }
        $this->addAnswer("--------");
    }
    private function checkArray(){
        if(sizeof($this->Transactions)==0){
            $this->addAnswer("No transactions");
            return false;
        }
        if(isset($this->Transactions["sender"],$this->Transactions["timestamp"],$this->Transactions["amount"], $this->Transactions["id"],$this->Transactions["option"],$this->Transactions["currency"])){
            $this->Transactions["sender"]=$this->ell($this->Transactions["sender"]);
            $this->Transactions["timestamp"]=$this->ell($this->Transactions["timestamp"]);
            $this->Transactions["amount"]=$this->ell_n($this->Transactions["amount"]);
            $this->Transactions["id"]=$this->ell_n($this->Transactions["id"]);
            $this->Transactions["option"]=$this->ell_n($this->Transactions["option"]);
            $this->Transactions["currency"]=$this->ell($this->Transactions["currency"]);
            if(!$this->Transactions["sender"] || !$this->Transactions["timestamp"] || !$this->Transactions["amount"] || !$this->Transactions["id"] || !$this->Transactions["option"] || !$this->Transactions["currency"]){
                $this->insertoDB("refund");
                $this->addAnswer("Invalid data ".$this->Transactions["id"]);
                return false;
            }
            if($this->Transactions["amount"]<1){
                $this->insertoDB("refund");
                $this->addAnswer("The amount is less than 2 ".$this->Transactions["id"]);
                return false;
            }
        }
        return true;
    }
    private function matchEntryRecords(){
        $select=$this->one_row("`EID`","entry","`sender`='".$this->Transactions["sender"]."' AND `option`=".$this->Transactions["option"]);
        if($select==false){
            $this->insertoDB("refund");
            $this->addAnswer("Not in entry ".$this->Transactions["id"]);
            return false;
        }else{
            $this->Transactions["sender"]=$select["EID"];
        }
        return true;
    }
    private function matchExistingTransactionsFromDB(){
        $select=$this->select("`transactionid`","transaction",0,"`transactionid`=".$this->Transactions["id"]." AND `option`=".$this->Transactions["option"]);
        $select2=$this->select("`transactionid`","refund",0,"`transactionid`=".$this->Transactions["id"]." AND `option`=".$this->Transactions["option"]);
        if($select!=false || $select2!=false){
            $this->addAnswer("Transaction exists in DB ".$this->Transactions["id"]);
            return false;
        }
        return true;
    }
    private function insertoDB($inserto="transaction"){
        if($this->matchExistingTransactionsFromDB()){
            $insert=$this->insert($inserto,"`transactionid`,`sender`,`amount`,`timestamp`, `option`, `currency`", $this->Transactions["id"].", '".$this->Transactions["sender"]."', ".$this->Transactions["amount"].", '".$this->Transactions["timestamp"]."', ".$this->Transactions["option"].", '".$this->Transactions["currency"]."'");
            if($insert==false){
                $this->addAnswer("Insert failed ".$this->Transactions["id"]);
                return false;
            }
            return true;
        }
    }
    private function addAnswer($Ans){
        $size=sizeof($this->Answer);
        $this->Answer[$size+1]=$Ans;
    }
    public function getAnswers(){
        return $this->Answer;
    }
 }


?>