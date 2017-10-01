<?php
    include_once("config.php");
    $id=$MYSQL->one_row("SID","session","","`SID` DESC");
    if($id==false){
        ?><span id="closed">There are no entries allowed at the moment!</span><?php
        die;
    }
    $ans=$MYSQL->one_row("`SID`, DATE_ADD(`end`, INTERVAL 30 MINUTE) AS `end`","session","NOW() BETWEEN DATE_SUB(`end`, INTERVAL 30 MINUTE) AND DATE_ADD(`end`, INTERVAL 30 MINUTE) AND `SID`='".$id['SID']."'","");
    if($ans!=false){ //check when the session end if its before or after 30 minute the actual time. then sow a message
        ?><span id="closed">The entries are clossed until the next session starts! <br/>The next session will start: <?php echo($ans["end"]); ?></span><?php
        die;
    }
    $ans=$MYSQL->one_row("`SID` ","session","DATE_ADD(`end`, INTERVAL 31 MINUTE)< CURRENT_DATE() AND `SID`='".$id['SID']."'","");
    if($ans!=false){ //check when the session end if its before or after 30 minute the actual time. then sow a message
        ?><span id="closed">There are no entries allowed at the moment!</span><?php
        die;
    }
    $address=mysql_query("SELECT `id` FROM `optionaddresses` WHERE `optionaddresses`.`session`='".$id['SID']."' LIMIT 1");
    if(mysql_num_rows($address)<1){ //check if the current session has addresses or not. if not then show a message
        ?><span id="closed">We have some technical difficulties please try again later.</span><?php
        die;    
    }
    //if everything is ok then show the form
    if(!isset($_GET["o"])) die; //If there is no option choosed the "die"
?>
    <div id="resp">&nbsp;</div>
    <form id="entryform">
        <fieldset id="optioncontainer">
            <p id="headertext">
                <label id="optiontext">Sign up for option </label>
                <label id="coption"><?php if(isset($_GET["o"]) && is_numeric($_GET["o"])) echo($_GET["o"]); ?></label>
            </p>
        </fieldset>
        <fieldset id="typeset">
            <legend>Addess type:
            <label for="nxt" class="currency">NXT</label>
            <input type="radio" name="add" class="aradio" id="nxt" value="nxt" checked=""/>
            <label for="btc" class="currency">BTC</label>
            <input type="radio" name="add" class="aradio" id="btc" value="btc"/>
            </legend> 
        </fieldset>
        <fieldset id="nxtaddressfield" class="addressfieldset">
            <legend>Sender's address:</legend>
            <input type="text" id="a1" name="a1" value="" class="addressField nxtaf nxtfirst"/> -
            <input type="text" id="a2" name="a2" value="" maxlength="4" class="addressField nxtaf" disabled/> -
            <input type="text" id="a3" name="a3" value="" maxlength="4" class="addressField nxtaf" disabled/> -
            <input type="text" id="a4" name="a4" value="" maxlength="4" class="addressField nxtaf" disabled/> -
            <input type="text" id="a5" name="a5" value="" maxlength="5" class="addressField nxtaf" disabled/>
        </fieldset>
        <fieldset id="btcaddressfield" class="addressfieldset">
            <legend>Sender's address:</legend>
            <input type="text" id="b1" value="" class="addressField btcaf btcfirst" disabled/> -
            <input type="text" id="b2" value="" maxlength="4" class="addressField btcaf" disabled/> -
            <input type="text" id="b3" value="" maxlength="4" class="addressField btcaf" disabled/> -
            <input type="text" id="b4" value="" maxlength="4" class="addressField btcaf" disabled/> -
            <input type="text" id="b5" value="" maxlength="4" class="addressField btcaf" disabled/> -
            <input type="text" id="b6" value="" maxlength="4" class="addressField btcaf" disabled/> -
            <input type="text" id="b7" value="" maxlength="4" class="addressField btcaf" disabled/> -
            <input type="text" id="b8" value="" maxlength="6" class="addressField btcaf" disabled/>
        </fieldset>
        <fieldset>
            <legend>NEM Address:</legend>
            <input type="text" id="n1" name="n1" value="" class="addressField nemaf" disabled/> -
            <input type="text" id="n2" name="n2" value="" maxlength="6" class="addressField nemaf" disabled/> -
            <input type="text" id="n3" name="n3" value="" maxlength="6" class="addressField nemaf" disabled/> -
            <input type="text" id="n4" name="n4" value="" maxlength="6" class="addressField nemaf" disabled/> -
            <input type="text" id="n5" name="n5" value="" maxlength="6" class="addressField nemaf" disabled/> -
            <input type="text" id="n6" name="n6" value="" maxlength="6" class="addressField nemaf" disabled/> -
            <input type="text" id="n7" name="n7" value=""   maxlength="4" class="addressField nemaf" disabled/>
        </fieldset>
        <fieldset id="submitbutton">
            <div class="g-recaptcha" data-sitekey="6LfPQwMTAAAAAFSr8aR6ZtZxay4eXIH5SacStgzN"></div>
            <div id="entrybuttoncontainer"><input type="button" value="Enter" id="enterbutton" disabled class="button"/></div>
            <input id="token" type="hidden" name="csrf" value="<?php echo($CSRF); ?>"/>
        </fieldset>
    </form>