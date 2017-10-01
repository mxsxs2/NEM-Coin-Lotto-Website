<?php
include_once("php/config.php");
$sitexts=$MYSQL->one_row("*","sitetexts");
/**
 * @author mxsxs2
 * @copyright 2015
 */



?>

 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=no"/>
    <title>New Economy Movement Lotto - Win now!</title>
        <!--[if IE 6]><base href="<?php echo($CONFIGVAR["web"].$CONFIGVAR["SELFDIR"]);?>/"></base><![endif]-->
        <!--[if !IE 6]><!--><base href="<?php echo($CONFIGVAR["web"].$CONFIGVAR["SELFDIR"]);?>/" /><!--<![endif]-->
        <link href="css/index.css" rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/png"  href="css/img/logo.png"/>
        <meta name="description=" content="New Economy Movement Lotto"/>
        <meta name="keywords" content="Nem, New, Economy, Movement, Lotto, Next, Nxt, Bitcoin, Btc"/>
        <meta name="author" content="mxsxs2"/>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/index.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
  </head>

<body>
<div id="overlay"></div>
<div id="calculatorbox">
    <?php include_once("php/calc.php"); ?><br />
</div>
<div id="fade" class="container">
  <div id="canvas">
    <div style="display: table-row;">
        <nav class="navbar" id="head">
            <div id="desc">
                    <div id="deadline">
                        <?php $end="Not available";
                              $time=$MYSQL->one_row("end","session","","sid DESC");
                              if($time!=false) $end=$time['end'];
                        ?>
                        Deadline: <span><?php echo($end); ?></span>
                    </div>
                    <div class="pull-left visible-xs" id="menubutton">
                        <button type="button" class="button" data-toggle="offcanvas">Options</button>
                    </div>
                </div>
                <div id="home"></div>
                <div id="menu">
                    <a href="<?php echo($CONFIGVAR["web"].$CONFIGVAR["SELFDIR"]);?>/winner"><span>Biggest Winners</span></a>
                    <a href="<?php echo($CONFIGVAR["web"].$CONFIGVAR["SELFDIR"]);?>/checktransaction"><span>Transaction Check</span></a>
                    <a href="javaScript:void(0);" id="calcbutton"><span>Calculator</span></a>
                </div>
        </nav><!-- /.navbar -->
    </div>
    <div class="row row-offcanvas row-offcanvas-left" id="middle">
        <div class="sidebar-offcanvas" id="leftside">
          <?php 
                      $options=array(
                            "nxt1"=>0,
                            "nxt2"=>0,
                            "nxt3"=>0,
                            "nxt4"=>0,
                            "btc1"=>0,
                            "btc2"=>0,
                            "btc3"=>0,
                            "btc4"=>0
                        );
                        $entries=array("nxt1"=>0,"nxt2"=>0,"nxt3"=>0,"nxt4"=>0,"btc1"=>0,"btc2"=>0,"btc3"=>0,"btc4"=>0);
                        $whole=array("nxt"=>0, "btc"=>0);
                        $amounts=$MYSQL->select("`amount`,`option`,`totalentries`,`currency`","entryamount", 8);
                        if($amounts!=false){
                            while($amount=mysql_fetch_array($amounts)){
                                $entries[$amount["option"]]=$amount["totalentries"];
                                $whole[$amount["currency"]]+=$amount["amount"];
                                $options[$amount["option"]]=$amount["amount"];
                            }
                        }
                        $btcamounts=$MYSQL->one_row("`btc1`,`btc2`,`btc3`,`btc4`","amounts","`id`=1");
                        if($btcamounts!=false){
                            for($i=1;$i<=4;$i++){
                                $options["btc".$i]=explode($btcamounts["btc".$i])[1];
                                $entries["btc".$i]=explode($btcamounts["btc".$i])[0];
                                $whole["btc"]+=explode($btcamounts["btc".$i])[1];
                            }
                        }
                      ?>
                      <span id="grandtotalbtc" ><?php echo($whole["btc"]) ?></span>
                      <span id="grandtotalnxt"><?php echo($whole["nxt"]) ?></span>
                    <div id="opt1" class="option">
                        <p><?php echo($sitexts["opt1text"]); ?></p>
                        <p>Number: <?php echo($sitexts["Option1"]); ?></p>
                        <p>Profitability on 1 BTC: 
                            <span id="prof1" class="profitability">100</span>%
                        </p>
                        <p>Entries in BTC: 
                            <span id="btc1" class="totalbtc"><?php echo($options["btc1"]) ?></span>
                            <span id="nxt1" class="hiddennxt"><?php echo($options["nxt1"]) ?></span>
                        </p>
                    </div>
                    <div id="opt2" class="option">
                        <p><?php echo($sitexts["opt2text"]); ?></p>
                        <p>Number: <?php echo($sitexts["Option2"]); ?></p>
                        <p>Profitability on 1 BTC: 
                            <span id="prof2" class="profitability">100</span>%
                        </p>
                        <p>Entries in BTC: 
                            <span id="btc2" class="totalbtc"><?php echo($options["btc2"]) ?></span>
                            <span id="nxt2" class="hiddennxt"><?php echo($options["nxt2"]) ?></span>
                        </p>
                    </div>
                    <div id="opt3" class="option">
                        <p><?php echo($sitexts["opt3text"]); ?></p>
                        <p>Number: <?php echo($sitexts["Option3"]); ?></p>
                        <p>Profitability on 1 BTC: 
                            <span id="prof3" class="profitability">100</span>%
                        </p>
                        <p>Entries in BTC: 
                            <span id="btc3" class="totalbtc"><?php echo($options["btc3"]) ?></span>
                            <span id="nxt3" class="hiddennxt"><?php echo($options["nxt3"]) ?></span>
                        </p>
                    </div>
                    <div id="opt4" class="option">
                        <p><?php echo($sitexts["opt4text"]); ?></p>
                        <p>Number: <?php echo($sitexts["Option4"]); ?></p>
                        <p>Profitability on 1 BTC: 
                            <span id="prof4" class="profitability">100</span>%
                        </p>
                        <p>Entries in BTC: 
                            <span id="btc4" class="totalbtc"><?php echo($options["btc4"]) ?></span>
                            <span id="nxt4" class="hiddennxt"><?php echo($options["nxt4"]) ?></span>
                        </p>
                    </div>
        </div><!--/.sidebar-offcanvas-->
        <div id="rightside">
            <div id="entrytextbox">
                        <?php include_once("php/pageloader.php");
                            $obj=new PageLoader();
                            if(isset($_GET["a"])){
                                $obj->setGet($_GET["a"]);
                                unset($_GET);
                                $file=$obj->GetFile();
                                if($file!=false){
                                    include_once($file);
                                }else{
                                    echo(str_replace("\n","<br>",$sitexts["opening"]));
                                }
                            }else{
                                echo(str_replace("\n","<br>",$sitexts["opening"]));
                            }
                        ?>
                    </div>
        </div>
      </div>
  </div>
  <div id="foot">
                    <div id="cright">@NEM Project 2015 Released under GNU General Public License</div>
  </div>
</div>

 </body>   
</html>
