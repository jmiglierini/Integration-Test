<?php

class BaseClass {

    protected $data;
 
    public function SaveResult(){
 
        if (isset($this->data[0][0]['x-test-ad'])){
            $test = 1;   
        }else{ 
            $test = 0; 
        }
        if (isset($this->data[0][0]['x-error-reason'])){
            $error = 1;
        }else{
            $error = 0;
        }
        if($test==1){
            $output = array("test"=>$test, "error"=>$error, "error-reason"=>null,"ad"=>$this->data[0][1]);
        }
        if ($error==1){
            $output = array("test"=>$test, "error"=>$error, "error-reason"=>implode($this->data[0][0]['x-error-reason']),"ad"=>$this->data[0][1]);
        }else{
            $output = array("test"=>$test, "error"=>$error, "error-reason"=>null,"ad"=>$this->data[0][1]);
        }

        ini_set("precision", 10);
        $epochtime = microtime(true);
        
        $json_string = json_encode($output);
        $file = "$epochtime.json";
        
        $file_output = 'Output/'.$file;
        file_put_contents($file, $json_string);
        
        rename($file , $file_output);
    }

}


    