<?php
$results=$MYSQL->select("`amount`,`timestamp`","biggestwiner","5","","`amount` DESC");
if($results!=false){
    ?>
    <p id="winnerlabel">The biggest winners at all time</p>
    <table id="winnertable" class="table table-striped">
        <thead>
                <tr id="firstline">
                    <td class="sortable">Amount(XEM)</td>
                    <td class="sortable">Time</td>
                </tr>
        </thead>
        <tbody>
            <?php
             while($result=mysql_fetch_array($results)){
                echo('<tr>
                        <td class="refundoption">'.$result["amount"].'</td>
                        <td class="refunddate">'.$result["timestamp"].'</td>
                      </tr>');
            } ?>
          </tbody>
      </table>
<?php }else{ ?>
    <p>There are no winners yet. Enter the competition and you might be the first!</p>
<?php } ?>
