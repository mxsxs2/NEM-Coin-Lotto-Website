<?php
class PageLoader{
                    private $URL=array(
                        'winner'  =>"php/*winners",                 //Biggest winners
                        'def'  =>"/*index",                         //Default
                        'option1'  =>"php/*entryform",              //Entry form
                        'option2'  =>"php/*entryform",              //Entry form
                        'option3'  =>"php/*entryform",              //Entry form
                        'option4'  =>"php/*entryform",              //Entry form
                        'checktransaction' =>"php/*chktidform"      //Transaction checker form
                    );
                    private $GET;
                    public function GetFile(){
                        $this->explodeGET();
                        //print_r($this->GET);
                            if(isset($this->URL[$this->GET[0]])){             //If isset in $this->GET
                                $b=explode("*",$this->URL[$this->GET[0]]);    //Get separate url and dir
                                $dir=$b[0];
                                $file=$b[1];
                                if($this->isLink($dir,$file)){       //Is file
                                      $param='?';
                                      foreach($this->GET as $key=>$val){
                                        if($key>0 && $key%2 && isset($this->GET[$key+1])) $_GET[$val]=$_GET[$this->GET[$key+1]];
                                      }
                                      if(substr($this->GET[0], 0,6)=="option") $_GET["o"]=substr($this->GET[0], 6,1);
                                      return $dir.$file.".php";      //Return the php file 
                                }
                            }
                                  
                        return false;                                //Return false if there is no existing file
                    }
                    private function isLink($dir,$file){
                        //echo($dir.$file.".php");
                        if (!preg_match("/[^a-z0-9_]/i",$file)){
                            if (file_exists($dir.$file.".php")){
                                return true;
                            }
                        }
                    }
                    private function explodeGET(){
                        $this->GET=explode("/",$this->GET);
                    }
                    public function setGet($GET){
                        $this->GET=$GET;
                    }                    
                }
                /*$obj=new PageLoader();
                if(isset($_GET['a'])){
                    $get=explode('/',$_GET['a']);
                    unset($_GET['a']);
                    foreach($get as $key=>$val){
                        if($key==0){
                            if(isset($get[$key+1])){
                                $_GET[$get[0]]=$get[$key+1];
                            }else{
                                $_GET[$get[0]]="";
                            }
                        }else{
                            if($key%2){
                                    $_GET[$get[$key-1]]=$get[$key];
                            }
                        }
                   }
                }*/

?>