<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('../Test-AdNetwork/Networks/TappxClass.php');


try {
    $appKey               = "pub-1234-android-1234";
    $requestContentString = file_get_contents("Request.txt");

    $test = new Launcher($appKey, $requestContentString);
    $test->Run();
    
    echo PHP_EOL . PHP_EOL . "end" . PHP_EOL . PHP_EOL . PHP_EOL;
}
catch (Exception $p_ex) {
    echo PHP_EOL . PHP_EOL . $p_ex->getMessage() . PHP_EOL . PHP_EOL . PHP_EOL;
}

exit(0);

class Launcher {

    private $m_app_key;
    private $m_request_content;
    private $m_timeout;
    
    public function __construct($p_app_key, $p_request_content_object) {
        $this->m_app_key         = $p_app_key;
        $this->m_request_content = $this->ParseContent($p_request_content_object);
    }
    private function ParseContent($p_content) {

        $json = json_decode($p_content,true);
    
        $args = [

            "sz" => urlencode($json['imp']['0']['banner']['w'] .'x'. $json['imp']['0']['banner']['h']),
            "os" => urlencode($json['device']['os']),
            "ip" => urlencode($json['device']['ip']),
            "source" => urlencode ('app'),
            "ab" => urlencode ($json['app']['bundle']),
            "aid" => urlencode($json['device']['ifa']),
            "mraid" => urlencode('2'),
            "ua" => urlencode($json['device']['ua']),
            "cb"  => urlencode('23482834829'),
            "lat" => urlencode($json['device']['geo']['lat']),
            "lon" => urlencode($json['device']['geo']['lon']),
            "an" => urlencode ($json['app']['name']),
            "url" => urlencode ($json['app']['storeurl']),
            "qapid" => urlencode ($json['bcat']['0']),
            "secure" => urlencode($json['imp']['0']['secure']),
            "test" => urlencode($json['test']),
            "timeout" => urlencode($json['tmax']),

        ];

        foreach ($args as $key => $value){

            $n_args[] = '&'.$key.'='.$value; 

        }
        
        $this->m_timeout = substr($n_args[16], 9);

        $params = implode("", $n_args);
       
        return $params;
    
    }
    
    public function Run() {

        $start = microtime(true);
        
        $test = new TappxClass($this->m_app_key, $this->m_request_content);
        $test->Run();
        $test->SaveResult();
        
        if (((microtime(true) - $start) * 1000) > $this->m_timeout || is_null($this->m_timeout))
            throw new Exception("TEST not valid");
                  
    }
    
}