<?php

/**
 * @author asdfg
 * @copyright 2015
 */

include("pswd.php");
$p=new Password();
$time="2015-08-21 21:40";
$rnd="799834426";
echo($p->create($time,$rnd));

?>