<?php

class Password{
    private function shift($D, $Content){
        $CHARS="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-";
        $Shifted="";
        for($Pos=0; $Pos<strlen($Content); $Pos++){
             if($D==1){
                $n=strpos($Content[$Pos], $CHARS)+1;
             }else{
                $n=strpos($Content[$Pos], $CHARS)-1;
             }
             if($n<0) $n=35;
             if($n==36) $n=0;
             if($n>36)  $n=36;
             $Shifted+=$CHARS[$n];
        }
        return $Shifted;
    }
    public function create($Time, $UserBTCAddress){
         return hash_pbkdf2("sha1",strtoupper($UserBTCAddress), $Time, 100, 128);
    }
}


?>