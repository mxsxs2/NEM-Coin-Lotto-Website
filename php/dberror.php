<?php
$CONFIGVAR=array(
        //'web'     => "http://estair.mxsxs2.info",
        'SELFDIR' => 'nem',
        'web'     => "http://176.61.83.49/",
);
/**
 * @author mxsxs2
 * @copyright 2015
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <title>New Economy Movement Lotto - Database Error</title>
        <!--[if IE 6]><base href="<?php echo($CONFIGVAR["web"].$CONFIGVAR["SELFDIR"]);?>/"></base><![endif]-->
        <!--[if !IE 6]><!--><base href="<?php echo($CONFIGVAR["web"].$CONFIGVAR["SELFDIR"]);?>/" /><!--<![endif]-->
        <link href="css/index.css" rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/png"  href="css/img/favicon.ico"/>
        <meta charset="utf-8"/>
        <meta name="description=" content="New Economy Movement Lotto"/>
        <meta name="keywords" content="Nem, New, Economy, Movement, Lotto, Next, Nxt, Bitcoin, Btc"/>
        <meta name="author" content="mxsxs2"/>
        <script type="text/javascript">
								var x=5;
							function load(){
								if(x==0){
									document.getElementById("back").innerHTML="-";
									document.location.reload();
								}else{
									document.getElementById("back").innerHTML=x;
								}
								x--;
								setTimeout("load()",1000);
							}
						</script>
    </head>
    <body onload="load()">
        <div id="fade" class="container">
            <div id="canvas">
                <div style="display: table-row;">
                    <nav class="navbar" id="head"></nav>
                </div>
                <div class="row" id="middle" style="display: table">
                    <div id="rightside">
                        <div id="entrytextbox">
                            <p style="text-align: center">
							     <b>Cannot connect to the database.</b>
							     <br/>
							     The site will reload in <a id="back"></a> seconds.
                            </p>
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