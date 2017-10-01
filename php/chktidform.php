<?php
include_once("config.php");
/**
 * @author mxsxs2
 * @copyright 2015
 */
?>


<form id="chktidform">
    <fieldset>
        <p>Check your NXT transaction if it is valid</p>
    </fieldset>
    <fieldset id="input">
        Transaction ID: <input type="text" name="tid" id="tidinput" value=""/><input type="button" id="validationbutton" value="Check" class="button"/>
        <input id="token" type="hidden" name="csrf" value="<?php echo($CSRF); ?>"/>
    </fieldset>
    <fieldset id="resp"></fieldset>
</form>