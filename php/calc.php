<?php
/**
 * @author mxsxs2
 * @copyright 2015
 */
?>
<form id="calculator">
    <fieldset>
        <label>Next: </label><input type="text" id="cnxt" value=""/><br />
        <label>Bitcoin: </label><input type="text" id="cbtc" value="1" disabled/><br />
        <label>Option: </label><select id="calcoption">
                    <option value="1" selected="selected">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select><br />
        <label>Win: </label><input type="text" id="cwin" value="" disabled/>
    </fieldset>
    <fieldset>
        <input type="button" id="ccalc" value="Calculate" class="button"/>
        <input type="button"  id="cclose" value="Close" class="button"/>
    </fieldset>
</form>