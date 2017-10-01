<?php

/**
 * @author mxsxs2
 * @copyright 2015
 */ 
 
 
 
    $Currency[0]="BTC_NXT";
    $Currency[1]="nxt_btc";                                          
    if(isset($_GET["BTC_XEM"]) || isset($_GET["xem"])){     //if we are converting nem
        $Currency[0]="BTC_XEM";
        $Currency[1]="xem_btc"; 
    } 
 
    $url=array("http://data.bter.com/api/1/ticker/".$Currency[1], "https://poloniex.com/public?command=returnTicker");
    $wurl;
    $json=@file_get_contents($url[0]);
    if($json==false){
        $json=@file_get_contents($url[1]);
        if($json==false){
            die("0");
        }
    }
    $decoded=(array) json_decode($json, true);
    $last=0;
    if(isset($decoded[$Currency[0]]["last"])) $last=$decoded[$Currency[0]]["last"];
    if(isset($decoded["last"])) $last=$decoded["last"];
    
    
    if($last>0 && $Currency[0]=="BTC_NXT"){
        $btc=1;
        $nxt=10000;
        if(isset($_GET["btc"])) $btc=$_GET["btc"];
        if(isset($_GET["nxt"])){
            $nxt=$_GET["nxt"];
            echo(round($nxt*$last, 7));
        }else{
            echo(round($btc/$last, 3));
        }
    }elseif($last>0 && $Currency[0]=="BTC_XEM" ){
        $btc=1;
        $xem=10000;
        if(isset($_GET["BTC_XEM"])) $btc=$_GET["BTC_XEM"];
        if(isset($_GET["xem"])){
            $xem=$_GET["xem"];
            echo(round($xem*$last, 7));
        }else{
            echo(round($btc/$last, 3));
        }
    }else{
        echo(0);
    }  
?>