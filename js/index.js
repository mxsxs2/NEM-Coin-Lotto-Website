$(document).ready(function(){
    //----------------------------global variables
    var ONENXTINBTC=0;                                   //One nxt exchnaged to bitcoin
    var totalnxt=parseFloat($("#grandtotalnxt").html()); //Total nxt entries
    var totalbtc=parseFloat($("#grandtotalbtc").html())  //Total btc entries
    var totalnxtinbtc=0;                                 //All nxt echanged to bitcoin
    var totalmoney=0;                                    //All of the bitcoins currencies converted to btc
    
    
    
    function setDivSize(){
        /*middleheight=$(window).height()-$("#head").height()-$("#foot").height();
        $("#rightside").width($(window).width()-$("#leftside").width());
        if(middleheight>parseFloat($("#leftside").css("min-height"))){
            $("#rightside").height(middleheight);
            $("#leftside").height(middleheight);
            $("#middle").height($(window).height()-$("#head").height());
        }
        if(middleheight>parseFloat($("#leftside").css("min-height"))+$("#foot").height()){
            $("#middle").height($(window).height()-$("#head").height());
        }
        //$("#entrytextbox").css("margin", "auto auto");*/
    }
/*----------index*/
    $(".option").on({mouseenter: function() {
                        id=$(this).attr("id");
                        $("#"+id).stop(true,true).animate({width: "+=20px"}, "slow" );
                        //$("#"+id).stop(true,true).toggleClass("option_wide", 500);
                    }, 
                    mouseleave: function() {
                        id=$(this).attr("id");
                        $("#"+id).stop(true,true).animate({width: "-=20px"}, "slow" );
                        //$("#"+id).stop(true,true).toggleClass("option_wide", 500);
                    },
                    click:      function(){
                        option=$(this).attr("id").slice(3,4);
                        document.location.href="option"+option;
                        //$("#entrytextbox").load("php/entryform.php?o="+option);
                    }
                    });
        
    //div size
    $(window).resize(function(){
       setDivSize(); 
    });
    $(window).load(function(){
        $.get("php/btctonxt.php", {nxt: 1}).done(function(data){                    //Check how mouch btc is 1 nxt
            if($.isNumeric(data)) ONENXTINBTC=parseFloat(data).toFixed(7);          //If we got the answer as number then set the main var to the value what we got.
            totalnxtinbtc=parseFloat(totalnxt*ONENXTINBTC);                         //Change the total nxt to btc
            totalmoney=totalnxtinbtc+totalbtc;                                      //Total sum the currencies
            $("#cnxt").val(parseFloat(1/ONENXTINBTC).toFixed(7));                   //Fill the calculators nxt field
            

            for(i=1;i<5;i++){
                var id=i;
                //------------------total entries in BTC
                var btc=parseFloat($("#btc"+id).html());                            //Get the btc
                var nxttobtc=parseFloat($("#nxt"+id).html())*ONENXTINBTC;           //Get the nxt then convert to btc
                var entereddeposit=parseFloat(nxttobtc+btc).toFixed(7)              //The enetered deposits on each option
                $("#btc"+id).html(entereddeposit);                                  //Write out the total btc.
                //------------------profitability
                    var eachwins=totalmoney/entereddeposit;                        //Total divided by entries
                    var result=Math.round(eachwins*100);                           //Get back float value and round it (Entries multiplied by 100)
                    //alert("option: "+id+" totbtc:"+totalmoney+"/ entereddeposit:"+entereddeposit+" eachwin:"+eachwins+" calculated:"+result);
                    if(isFinite(result))  $("#prof"+id).html(result.toString());  //Write the result.
                
            }
        });
        setDivSize();    
    });
    

//-------------------------------calculator-----------------------------
$("body").on("click","#calcbutton, #overlay, #cclose", function(){
    $("#overlay").toggle();
    $("#calculatorbox").slideToggle();
});
$("body").on("keydown", "#cnxt",function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) || 
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
$("body").on("keyup", "#cnxt", function(){
    if($.isNumeric($("#cnxt").val())){
        var cnxt=parseFloat($("#cnxt").val())*ONENXTINBTC;
            cnxt=parseFloat(parseFloat($("#cnxt").val())*ONENXTINBTC).toFixed(7);
        $("#cbtc").val(cnxt);
    }
});
$("body").on("click", "#ccalc", function(){
    var option=$('select#calcoption').val();
    if($.isNumeric($("#cbtc").val())){
        //(this.TotalValidAmountNXT/this.EachEntries[option][1])*entered)
        //values in btc
        var btc=parseFloat($("#btc"+option).html());                        //Get the btc for chosen option
        var givenbtc=parseFloat($("#cbtc").val());                          //Get the entered ammount in btc
        var entereddeposit=btc+givenbtc;                                    //The enetered deposits for chosen option
        var totalentry=totalmoney+givenbtc;                                 //Total entries in btc plus the given
        var eachwins=totalentry/entereddeposit;                             //Total divided by entered ones
        var calculated=(eachwins*givenbtc)/ONENXTINBTC;                     //Calculated winning amount and changed back to nxt
        //alert("options_original:"+option+" givenbtc:"+givenbtc+" deposit:"+entereddeposit+" tbtc:"+totalentry+" eachwin:"+eachwins+" calculated:"+calculated);
        $("#cwin").val(parseFloat(calculated).toFixed(7));                  //Write the result.
    } 
});
//----------------------------------------------transactioncheck
$("body").on("click", "#validationbutton", function(){
    $("fieldset#input").toggle();
    tid=$("#tidinput").val();
    if(tid.length>0 && $.isNumeric(tid)){
        $.ajax({
                type: "POST",
                url: "php/chktid.php",
                data: "tid="+tid+"&csrf="+$("#token").attr("value")
                   })
                    .done(function( response ) {
                          if(response.length==1){
                                if(response=="0"){
                                    $("#resp").html("Transaction is on refound list");
                                }else{
                                    $("#resp").html("Transaction is valid");
                                }
                                
                          }else{
                                $("#resp").html("Could not find the transaction");
                          }
                    });
        }
});
//------------------------------------header buttons
$('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
});
$('body').on("click", "div#home", function(){
    document.location.href="index.php";
});
//---------------------------------load javascripts
$.getScript("js/form.js");
$.getScript("js/jquery-ui.min.js");
$.getScript("js/jquery.zclip.min.js");
$.getScript("js/bootstrap.min.js");
$.getScript("js/ie10-viewport-bug-workaround.js");
$.getScript("js/ie-emulation-modes-warning.js");



});