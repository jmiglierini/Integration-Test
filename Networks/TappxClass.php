<?php

require_once("BaseClass.php");

class TappxClass extends BaseClass{

    public function __construct($appKey, $requestContentString) {

        $this->m_app_key = $appKey;
        $this->m_request_content = $requestContentString;
    
    }
    public function Run(){
    
        $ch = curl_init();
        $headers = [];
    
        curl_setopt($ch, CURLOPT_URL,'http://test-ssp.tappx.net/ssp/req.php?key='.$this->m_app_key.$this->m_request_content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,

        function($curl, $header) use (&$headers){
           $len = strlen($header);
           $header = explode(':', $header, 2);
           if (count($header) < 2) 
                return $len;
    
           $headers[strtolower(trim($header[0]))][] = trim($header[1]);
       
           return $len;
         }
       );
       
       $data = curl_exec($ch);

       $res[] = array($headers,$data);

       $this->data = $res;
    
    }

}
