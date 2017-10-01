<?php
//@session_start();
//-------------session manager from:
//https://github.com/auraphp/Aura.Session
include_once("session/SessionFactory.php");
include_once("session/Phpfunc.php");
include_once("session/Session.php");
include_once("session/SegmentFactory.php");
include_once("session/SegmentInterface.php");
include_once("session/Segment.php");
include_once("session/CsrfToken.php");
include_once("session/CsrfTokenFactory.php");
include_once("session/RandvalInterface.php");
include_once("session/Randval.php");
$session_factory = new \Aura\Session\SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$session->regenerateId();
$CSRF=$session->getCsrfToken()->getValue();
//---------------end session manager
ini_set("default_charset","utf-8");
header('Content-Type: text/html; charset=utf-8');
include_once('function.php');
try{
    
    $mysql_host = "localhost";
    $mysql_database = "nemlotto";
    $mysql_user = "root";
    $mysql_password = "";
    $MYSQL=new mysql($mysql_password, $mysql_user, $mysql_database, $mysql_host);
}catch(MysqlErrorException $e){
    if($e->getMessage()==1){
            include("php/dberror.php");
			die;
   }
}

$SECURE=new Secure();
Class Answer Extends Exception{}
mysql_query("SET NAMES `utf8`");
@ini_set("display_errors",true);
@ini_set("register_globals",false);
@ini_set("log_errors",true);
//@ini_set("magic_quotes_gpc",false);
@ini_set("safe_mode",true);
ini_set("safe_mode_gid",false);
ini_set("allow_url_fopen",false);
@ini_set("output_buffering",true);
@ini_set("safe_mod_grid",false);
@ini_set("enable_dl",false);
@error_reporting(E_ALL);
//-------------------------------site variables
$vars=$MYSQL->one_row("`root_dir`,`web_address`,`nxt_address`,`nis_address`, `btc_address`","siteaddress","`id`=1");
if($vars == FALSE){
    include("php/dberror.php");
    die;
}
if($vars["root_dir"]!="") $vars["root_dir"]="/".$vars["root_dir"];
$CONFIGVAR=array(
        'web'     => "http://".$vars["web_address"],
        'SELFDIR' => $vars["root_dir"]
);
$SOURCEURL=array(
        'NXT'     => $vars["nxt_address"]."nxt?",
        'NEM'     => $vars["nis_address"],
        'BTC'     => $vars["btc_address"]
);
?>