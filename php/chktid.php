<?php
include_once("config.php");
/**
 * @author mxsxs2
 * @copyright 2015
 */
if(isset($_POST["tid"], $_POST['csrf']) && "http://".$_SERVER['HTTP_HOST']."/"==$CONFIGVAR["web"]){//Check if the post exists
    $csrf_token = $session->getCsrfToken();
    if ($csrf_token->isValid($_POST['csrf'])) {                                                           //check token
        $tid=$SECURE->ell_n($_POST["tid"]);                                                            //filter the POST
        if(is_numeric($tid)){                                                                          //Check if the transaction id is still numeric
            $transactiontable=$MYSQL->one_row("`option`","transaction","`transactionid`=".$tid);    //Search the id in the transaction table
            if($transactiontable!=false){                                                              //If there is
                echo(1);                                                                               //Write out 1 
            }else{                                                                                     //If not in the transaction table
                $refundtable=$MYSQL->one_row("`option`","refund","`transactionid`=".$tid);          //Search in the refund table
                if($refundtable!=false){                                                               //If its there
                    echo(0);                                                                           //Write 0
                }else{                                                                                 //If not there
                    echo(-1);                                                                          //Write -1 what means the id is not in the database
                }
            }
        }
    }else{
        echo(-1);
    }
}


?>