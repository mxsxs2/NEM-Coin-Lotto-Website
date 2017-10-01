$(document).ready(function(){
/*------------entryform*/
    //radio set
$("body").on("click", ".aradio", function(){
        id=$(this).attr("id");
        $(".addressfieldset").hide();
        $(".addressField").prop("disabled", true)
                          .val("");
        $(".addressField").removeClass("correct incorrect");
        $("."+id+"first").prop("disabled", false)
                         .focus();
        $("#"+id+"addressfield").show();
        
});
    //field fill
$("body").on("keydown",".addressField", function(e){
   if(e.keyCode === 8) {
        var id=$(this).attr("id");
        var n=parseInt(id.slice(1,2));
        var a=id.slice(0,1);
        n--;
        if($(this).val().trim().length==0 && n>0){
            //alert("#"+a+n);
            $("#"+a+n).focus();
            //$(this).prop("disabled", true);
            var strLength= $("#"+a+n).val().length * 2;
            $("#"+a+n)[0].setSelectionRange(strLength, strLength);
            //setCaretPosition(this.id, this.value.length);
            //e.preventDefault();
        }
        if($(this).prop("disabled")==true) e.preventDefault();
        
    } 
});
$("body").on('keyup, paste, input',".addressField", function(e) {
    value=$(this).val();
    value=value.replace(new RegExp("-", 'g'), "");
    id=$(this).attr("id");
    onum=num=id.slice(1,2);
    alph=id.slice(0,1);
    forV=0;
    if(((value.length>4 && id!="n1") || (value.length>7 && id=="n1")) && num==1){    //If its insert on the first field
        if(alph=="a"){
            //NXT-9LGJ-YESL-ARTV-74VWH 24
            //NXT9LGJYESLARTV74VWH 20
            start=3;
            end=7;
            forV=4;
            $("#"+alph+5).val(value.slice(15, 21))
                         .prop("disabled", false);
        }
        if(alph=="b"){
            //17VZ-NX1S-N5Nt-Ka8U-QFxw-QbFe-Fc3i-qRYhem
            //17VZNX1SN5NtKa8UQFxwQbFeFc3iqRYhem
            start=4;
            end=8;
            forV=7;
            $("#"+alph+8).val(value.slice(28, 34))
                         .prop("disabled", false);
        }
        if(alph=="n"){
            //TBMAKO-TAFIG5-P4EYBO-7XLPNN-SKRUCY-QOZPDW-27UA
            start=6;
            end=12;
            forV=6;
            $("#"+alph+7).val(value.slice(36, 40))
                         .prop("disabled", false);
            
        }
        $(this).val(value.slice(0,start));
        for(i=2; i<=forV; i++){
            $("#"+alph+i).val(value.slice((start), end));
            $("#"+alph+i).prop("disabled", false);
            start+=4;
            end+=4;
            if(alph=="n"){
                start+=2;
                end+=2;
            }
        }
    }else if((value.length>5) || (value.length>=4 && alph!="n")){                                 //if its not insert, just typing
        if(num==1){ 
            if(alph=="a") lastC=3;                   //last caracter in the first field for nxt
            if(alph=="n") lastC=6;                   //for nem
            if(alph=="b") lastC=4;                   //for btc
            $("#"+alph+num).val($("#"+alph+num).val().slice(0,lastC)); //cut the last caracter anything longer the the lastC character
        }
        num++;
        if(id!="a5" && id!="n7" && id!="b8"){                 //If its not the last input field from the address
            $("#"+alph+num).prop("disabled", false);          //Set it the next enabled
            $("#"+alph+num).focus();                          //And give the for next focus
        }
    }
    
    
    //------------------------------------------address checking
    forCheck="";
    address="";
    addressLength=0;
    if($('input[name="add"]:checked').val()=="nxt" && !$("#a1").prop("disabled") && alph=="a"){
        if($("#a5").val().length>=5){
            addressLength=24;
            forCheck="nxt";
                    $(".nxtaf").each(function(){
                        address+=$(this).val();
                        if($(this).attr("id")!="a5") address+='-';
                    });
        }    
    }
    if($('input[name="add"]:checked').val()=="btc"  && !$("#b1").prop("disabled") && alph=="b"){
        if($("#b8").val().length>=4){
            addressLength=34;
            forCheck="btc";
                    $(".btcaf").each(function(){
                        address+=$(this).val();
                    });
        }    
    }
    if($("#n7").val().length>=4  && !$("#n1").prop("disabled") && alph=="n"){
        addressLength=40;
        forCheck="nem";
            $(".nemaf").each(function(){
                address+=$(this).val();
            });
    }
    //alert(addressLength+": "+address+" "+forCheck);
    if(address.length==addressLength && forCheck!=""){
                        $.ajax({
                            type: "POST",
                            url: "php/addresscheck.php",
                            data: { a: address, t: forCheck }
                            })
                            .done(function( response ) {
                                if(response.trim()=="1"){
                                    $("."+forCheck+"af").addClass("correct")
                                                        .removeClass("incorrect");
                                    $("#n1").prop("disabled", false);
                                    $("#resp").html("&nbsp;");
                                    if($(".nemaf").hasClass("correct")){
                                        $("#enterbutton").prop("disabled",false);
                                    }
                                }else{
                                    $("."+forCheck+"af").removeClass("correct")
                                                        .addClass("incorrect");
                                    $("#resp").html(response);
                                    if(alph!="n"){
                                        $(".nemaf").prop("disabled", true);
                                    }
                                    $("#enterbutton").prop("disabled",true);
                                }
                            });
                    }
    
});
$("body").on('focus', "#n1",function(){
    //$(".nxtaf, .btcaf").prop("disabled", true);
});
$("body").on("click", "#enterbutton",function(){
   empty=0;
   forEnd=0;
   letter="";
   currency="";
   sender="";
   nem="";
   $("#resp").html();
   if($("#nxt").prop("checked")){
        letter="a";
        currency="nxt";
   }
   if($("#btc").prop("checked")){
        letter="b";
        currency="btc";
   }
   if(currency!=""){
        $("."+currency+"af").each(function(){
            
           if($(this).val().length==0){
                empty++;
           }else{
                sender+=$(this).val();
                if(currency=="nxt" && $(this).attr("id")!="a5") sender+="-";
           }
           
        });
        $(".nemaf").each(function(){
           if($(this).val().length==0){
                empty++;
           }else{
                nem+=$(this).val();
           }
        });    
   }
   if(empty==0 && $("#coption").html().length==1){
        checked=0;
        if(currency=="nxt" && sender.length==24) checked++;
        if(currency=="btc" && sender.length==34) checked++;
        if(nem.length==40) checked++;
        

        if(checked==2){
            //alert(empty+" "+letter+" "+currency+" "+$("#coption").val()+" "+checked);
            $.ajax({
                type: "POST",
                url: "php/insertoentry.php",
                data: "a="+sender+"&n="+nem+"&c="+currency+"&o="+$("#coption").html()+"&g="+grecaptcha.getResponse()+"&csrf="+$("#token").attr("value")
                   })
                    .done(function( response ) {
                          resp=response.split("!-!");
                          if(resp[0].trim()=="1"){
                                $("#resp").html(resp[1])
                                          .css("color","#000")
                                          .show();
                                $('input#copy').zclip({
                                    path:'zc.swf',
                                    copy:$('p#address').text()
                                }); 
                                $('input#copypk').zclip({
                                    path:'zc.swf',
                                    copy:$('p#pk').text()
                                });         
                                $("#entryform").remove();
                          }else{
                                $("."+currency+"af").prop("disabled", false);
                                $("#resp").html(response)
                                          .show();
                                $(".nemaf").prop("disabled", false);
                          }
                    });
        }
   }
});
//-----------

});