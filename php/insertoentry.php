<?php
include_once("config.php");
/**
 * @author mxsxs2
 * @copyright 2015
 */
class Error extends Exception{};
class inserToEntry extends Secure{
    private $response;
    private $POST;
    private $SECURE;
    private $SOURCEURL;
    public function __Construct($post,$sourceurl){
        $this->SOURCEURL=$sourceurl;
        $this->getPost($post);
        $this->checkPOST();
        $this->checkDuplicate();
        $this->insertEntry();
    }
    private function checkPOST(){
        if(isset($this->POST["a"], $this->POST["n"], $this->POST["c"], $this->POST["o"], $this->POST["g"])){
            $this->POST["a"]=$this->ell($this->POST["a"]);
            $this->POST["n"]=$this->ell($this->POST["n"]);
            $this->POST["c"]=$this->ell($this->POST["c"]);
            $this->POST["o"]=$this->ell_n($this->POST["o"]);
            //echo($this->POST["a"]."   ".strlen($this->POST["a"]));
            if(!$this->checkRecaptcha()) throw new Error("Are you a robot?");
            if(!$this->POST["a"] || (strlen($this->POST["a"])!=24 && strlen($this->POST["a"])!=34)) throw new Error("Wrong sender address");
            if($this->POST["o"]>4 || $this->POST["o"]<1) throw new Error("Not exsisting option");
            if(!$this->POST["n"] || strlen($this->POST["n"])!=40) throw new Error("Wrong NEM address");
            if($this->POST["c"]!="nxt" && $this->POST["c"]!="btc") throw new Error("Wrong currency");
            
        }//else error
    }
    private function checkDuplicate(){
        $recipientfield="";
        $pk="";
        if($this->POST["c"]=="btc"){
            $recipientfield=",`recipientaddress`";                          //use if it is btc
        }
        $select=$this->one_row("`sender`".$recipientfield,"entry","`sender`='".$this->POST["a"]."' AND `Nem`='".$this->POST["n"]."' AND `option`=".$this->POST["o"]);
        if($select!=false){
            if($this->POST["c"]=="btc"){
                $address=$select["recipientaddress"];                         //use if it is btc
            }else{
                $nxt=$this->getOptionAddress();
                $address=$nxt[0];
            }
            if($address=="")throw new Error("We have some technical difficulties please try again later.");
            if(isset($nxt[1]) && $this->checkFirstTransaction()) $pk='<p id="pk">'.$nxt[1].'<p><input type="button" id="copypk" class="button" value="Copy public key to clipboard" name="copypk"/>';
            throw new Error('1!-!Address is already logged. To make another entry just send more '.$this->POST["c"].' to the following address:
                             <p id="address">'.$address.'<p>
                             <input type="button" id="copy" class="button" value="Copy to clipboard" name="copy"/>
                            '.$pk);
        }
    }
    private function insertEntry(){
        
        $pk="";
        $recipient="";                                                  //use if it is btc
        $recipientfield="";                          //use if it is btc
        if($this->POST["c"]=="btc"){                                    //create new btc address if it is a new entry
            require_once("createbtcaddress.php");
            $create=New CreateBTCAddress($this->POST["n"],$this->POST["o"]);
            if($create->getNewAddress()!=false){
                $address=$create->getNewAddress(); //override the $address variable with the new address
                $recipient=", '".$create->getNewAddress()."'";     //add it to de sql insert
                $recipientfield=",`recipientaddress`";                          //use if it is btc
            }
        }elseif($this->POST["c"]="nxt"){
            $nxt=$this->getOptionAddress();
            $address=$nxt[0];
        }
        if(!isset($address) || $address=="")throw new Error("We have some technical difficulties please try again later.");
        $insert=$this->insert("entry","`sender`,`Nem`,`Type`,`option`".$recipientfield,"'".$this->POST["a"]."','".$this->POST["n"]."','".$this->POST["c"]."',".$this->POST["o"]." ".$recipient);
        if($insert==false) throw new Error("Try again");
        if(isset($nxt[1]) && $this->checkFirstTransaction()) $pk='<p id="pk">'.$nxt[1].'<p><input type="button" id="copypk" class="button" value="Copy public key to clipboard" name="copypk"/>';
        throw new Error('1!-! The address is succesfully logged. To make an entry just send '.$this->POST["c"].' to the following address:
                             <p id="address">'.$address.'<p>
                             <input type="button" id="copy" class="button" value="Copy to clipboard" name="copy"/>
                             '.$pk);
    }
    private function checkFirstTransaction(){
        $first=$this->one_row("`transactionid`","transaction","`option`='".$this->POST['o']."'","`transactionid` DESC");
        if($first==false){
            include_once("getnxt.php");
            $g=new getNXT($this->SOURCEURL["NXT"], $this->getOptionAddress()[0],$this->POST['o']);
            if(sizeof($g->getTransactions())<1) return true; 
        }
        false;
    }
    private function getPost($post){
        $this->POST=$post;
    }
    private function getOptionAddress(){                    //does not apply for BTC !!
        $lastsession=$this->one_row("sid","session","","`sid` DESC");
        if($lastsession==false) return "";
        $address=$this->one_row("`".$this->POST["c"].$this->POST["o"]."`,`".$this->POST["c"]."p".$this->POST["o"]."`","optionaddresses","`session`='"+$lastsession["sid"]+"'","`session` DESC");
        if($address==false) return "";
        return array($address[$this->POST["c"].$this->POST["o"]],$address[$this->POST["c"]."p".$this->POST["o"]]);
    }
    private function checkRecaptcha(){
        $params = array();
        $params['secret'] = '6LfPQwMTAAAAAL2sxFnaDhcPNZc65oSvXkEtrEmb'; // Secret key
        $params['response'] = urlencode($this->POST["g"]);
        $params['remoteip'] = $_SERVER['REMOTE_ADDR'];
        $params['version'] = PHP_VERSION;
        $params_string = http_build_query($params);
        $requestURL = 'https://www.google.com/recaptcha/api/siteverify';
        /*
        $peer_key = version_compare(PHP_VERSION, '5.6.0', '<') ? 'CN_name' : 'peer_name';
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => $params_string,
                'verify_peer' => true,
                $peer_key => 'www.google.com',
            ),
        );
        $context = stream_context_create($options);
        $response = json_decode(file_get_contents($requestURL, false, $context), true);*/
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestURL."?".$params_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        curl_setopt($curl, CURLOPT_CAINFO, __DIR__.'/../ca-bundle.crt');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array());
        $response = json_decode(curl_exec($curl));
        //echo(curl_error($curl));
        if(is_array($response)){
            if ($response['success'] == true) return true;   
        }else if(is_object($response)){
            if ($response->{'success'} == true) return true;
        }
        return false;
    }
}
if(isset($_POST, $_POST['csrf']) && "http://".$_SERVER['HTTP_HOST']==$CONFIGVAR["web"]){
    @$csrf_token = $session->getCsrfToken();
    if (@$csrf_token->isValid($_POST['csrf'])) {
        $session->getCsrfToken()->regenerateValue();
        try{
            $opj= new inserToEntry($_POST,$SOURCEURL);
        }catch(Error $e){
            echo($e->getMessage());
        }
    }else{
        echo("Invalid request");
    }
}

?>