<?php

/**
 * @author mxxs2
 * @copyright 2015
 */

include_once("getnxt.php");
include_once("inserttransaction.php");

$secure=new Secure();
$wallets=$secure->one_row("*","optionaddresses");
foreach ($wallets as $key => $value) {
    if (is_int($key)) {
        unset($wallets[$key]);
    }
}
foreach($wallets as $option=>$address){
    $option=str_split($option, 3);
    //print_r($option);
    if($option[0]=="nxt" && strlen($address)>20){
        try{
            $getNXT=new getNXT($SOURCEURL["NXT"], $address, $option[1]);
            //print_r($option);
            $insertTransaction= new insertTransaction();
            if(is_array($getNXT->getTransactions())){
                foreach($getNXT->getTransactions() as $Main=>$Transaction){
                    $insertTransaction->__Init($Transaction);
                }
            }else{
                echo("not array: ".$getNXT->getTransactions());
            }
            print_r($insertTransaction->getAnswers());
        }catch(Exception $e){
            print($e->getMessage());
        }
    }
}
?>