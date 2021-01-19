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

Class RyuHandler{

    public $smtp;
    public $mailer;
    public $smtp_settings = array();
    
    /**
     * post
     *
     * @param  mixed $name
     * @return void
     */
    public function post($name = null)
    {
        if($name == null)
        {
            return isset($_POST);
        }
        else{

            return $_POST[''.$name.''];
        }
    }    
    /**
     * retrive
     *
     * @param  mixed $data
     * @return void
     */
    public function retrive($data = [])
    {
        return $_REQUEST;
    }    
    /**
     * get
     *
     * @param  mixed $name
     * @return void
     */
    public function get($name = null)
    {
        if($name == null)
        {
            return isset($_GET);
        }
        else{
            return $_GET[''.$name.''];
        }
    }
    public function parameter($param)
    {
        if(isset($_GET[''.$param.'']))
        {
            return true;
        }else{
            return false;
        }
    }
    /**
     * session
     *
     * @param  mixed $name
     * @return void
     */
    public function session($name = null)
    {
        if($name == null)
        {
            return isset($_SESSION);
        }
        else{
            return $_SESSION[''.$name.''];
        }
    }
    public function set_session($arr = [])
    {
        $x = '';
		if(is_array($arr)){
		foreach($arr as $name=>$val)
		{
			$x.= @$_SESSION[$name]=$val;
		}
		}
		return $x;
    }
    public function _session($name,$val)
    {
        return $_SESSION[''.$name.''] = $val;
    } 
    /**
     * file
     *
     * @param  mixed $fname
     * @param  mixed $content
     * @param  mixed $method
     * @return void
     */
    public function file($fname, $content,$method = 'w')
    {
        $fp = fopen($fname,$method);
        fwrite($fp,$content);
        fclose($fp);
        return true;
    }    
    /**
     * file_gets
     *
     * @param  mixed $fname
     * @return void
     */
    public function file_gets($fname)
    {
        return file_get_contents($fname);
    }    
    /**
     * sendemail
     *
     * @param  mixed $fromName
     * @param  mixed $to
     * @param  mixed $subject
     * @param  mixed $message
     * @param  mixed $from
     * @return void
     */
    public function sendemail($from = [],$to,$subject,$message,$attach = null)
    {
        $rr = 'no-reply@'.time().'.ryujinframework.net';
        if($from['from_mail'] == null)
        {
            $fromMail = $rr;
        }else{
            $fromMail = $from['from_mail'];
        }
        $fromName = $from['from_name'];

       
        $this->mailer = new PHPMailer;
        if($this->smtp == true)
        {
            $this->mailer->isSMTP();
            $this->mailer->SMTPDebug=0;
            $this->mailer->Host = $this->smtp_settings['hostname'];
            $this->mailer->SMTPAuth = true;                               
            $this->mailer->Username = $this->smtp_settings['username'];
            $this->mailer->Password = $this->smtp_settings['password'];                  
            $this->mailer->SMTPSecure = $this->smtp_settings['secure'];
            $this->mailer->KeepAlive = true;                           
            $this->mailer->Port = $this->smtp_settings['port'];
            $this->mailer->Priority = 3;
            $this->mailer->CharSet =  "UTF-8";  
            $this->mailer->ContentType = "text/html"; 
            $this->mailer->Priority = 1;                                
            $this->mailer->SingleTo = true;
            $this->mailer->setFrom($fromMail , $fromName);                            
            $this->mailer->Subject = '=?UTF-8?B?'.base64_encode("[\xe2\x98\x98]".$subject).'?=';
            $this->mailer->AltBody = $message;
            $this->mailer->MsgHTML($message);
            if($attach !== null){
            foreach($attach as $photo){
            $this->mailer->AddAttachment($photo);
    //$mail->AddEmbeddedImage($photo);
              }
              }
            $this->mailer->AddAddress($to);
            $this->mailer->send();
            
        }else{
        
            $this->mailer->isMail();
            $this->mailer->CharSet =  "UTF-8";  
            $this->mailer->ContentType = "text/html"; 
            $this->mailer->Priority = 1;                                
            $this->mailer->SingleTo = true;
            $this->mailer->setFrom($fromMail , $fromName);                             
            $this->mailer->Subject = '=?UTF-8?B?'.base64_encode("[\xe2\x98\x98]".$subject).'?=';
            $this->mailer->AltBody = $message;
            $this->mailer->MsgHTML($message);
              if($attach !== null){
            foreach($attach as $photo){
            $this->mailer->AddAttachment($photo);
    //$mail->AddEmbeddedImage($photo);
              }
              }
            $this->mailer->AddAddress($to);
            $this->mailer->send();
        }
    }
    public function userIP()
	{
       $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'unknown';
    return $ipaddress;
     }
     public function getDomain()
    {
        $domain = preg_replace('/www\./i','',$_SERVER['SERVER_NAME']);
        $domain = ($domain == '127.0.0.1') ? 'localhost' : $domain;
        return $domain;
    }
    public function getBrowser() {
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $browser        =   "Unknown Browser";
        $browser_array  =   array(
                                '/msie/i'       =>  'Internet Explorer',
                                '/firefox/i'    =>  'Firefox',
                                '/safari/i'     =>  'Safari',
                                '/chrome/i'     =>  'Chrome',
                                '/opera/i'      =>  'Opera',
                                '/netscape/i'   =>  'Netscape',
                                '/maxthon/i'    =>  'Maxthon',
                                '/konqueror/i'  =>  'Konqueror',
                                '/mobile/i'     =>  'Handheld Browser'
                            );
        foreach ($browser_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $browser    =   $value;
            }
        }
        return $browser;
        }
    
        public function getOS() { 
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
                                '/windows nt 10/i'     =>  'Windows 10',
                                '/windows nt 6.3/i'     =>  'Windows 8.1',
                                '/windows nt 6.2/i'     =>  'Windows 8',
                                '/windows nt 6.1/i'     =>  'Windows 7',
                                '/windows nt 6.0/i'     =>  'Windows Vista',
                                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                                '/windows nt 5.1/i'     =>  'Windows XP',
                                '/windows xp/i'         =>  'Windows XP',
                                '/windows nt 5.0/i'     =>  'Windows 2000',
                                '/windows me/i'         =>  'Windows ME',
                                '/win98/i'              =>  'Windows 98',
                                '/win95/i'              =>  'Windows 95',
                                '/win16/i'              =>  'Windows 3.11',
                                '/macintosh|mac os x/i' =>  'Mac OS X',
                                '/mac_powerpc/i'        =>  'Mac OS 9',
                                '/linux/i'              =>  'Linux',
                                '/ubuntu/i'             =>  'Ubuntu',
                                '/iphone/i'             =>  'iPhone',
                                '/ipod/i'               =>  'iPod',
                                '/ipad/i'               =>  'iPad',
                                '/android/i'            =>  'Android',
                                '/blackberry/i'         =>  'BlackBerry',
                                '/webos/i'              =>  'Mobile'
                            );
        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }
        }   
        return $os_platform;
        }
      public function is_mobile()
      {
        $platform = $this->getOS();
        $mobile = ['iPad','iPhone','iPod','Android','BlackBerry','Mobile'];
        if(in_array($platform,$mobile))
        {
          return true;
        }else{
          return false;
        }
      }      
      /**
       * rand_str
       *
       * @param  mixed $randstr
       * @return void
       */
      public function rand_str($randstr)
      {
          $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $str  = '';
          for ($i = 0;
              $i < $randstr;
              $i++) {
              $pos = rand(0, strlen($char) - 1);
              $str .= $char[$pos];
          }
          return $str;
      }
      
    public function detection()
    {
        $data['userip'] = $this->userIP();
        $data['hostname'] = gethostbyaddr($this->userIP());
        $data['useragent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['webdomain'] = $this->getDomain();
        $data['browser'] = $this->getBrowser();
        $data['platform'] = $this->getOS();
        $data['is_mobile'] = $this->is_mobile();
        $data['http_lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        return $data;
    }
    public function getInfo($country = null)
    {
        $info = $this->detection();
       return $country .' - '.$info['userip'].' - '.$info['browser'].' - '.$info['platform'];
    }
    public function result($type ,  $data =[])
    {

        $source = VIEW_PATH . 'html/'.$type.'.html';
        $fsource = file_get_contents($source);
        $rpl1=[];
        $val1=[];
        foreach($data as $rpl=>$val)
        {
            $rpl1[]="{".$rpl."}";
            $val1[]=$val;
        }
        $access_preg = ['{ip}' , '{agent}' , '{browser}' , '{device}' , '{date}'];
        $access_info = [$this->detection()['userip'], 
         $this->detection()['useragent'], 
         $this->detection()['browser'],
         $this->detection()['platform'], 
         date('D,d-m-Y H:i')
        ];

        $ret = str_replace($access_preg , $access_info , $fsource);
        return str_replace($rpl1,$val1,$ret);
    }
    public function emaildetect($email)
    {
      if(filter_var($email,FILTER_VALIDATE_EMAIL))
      {
        if(preg_match("/@gmail/",$email))
        {
          return 'gmail';
        }elseif(preg_match("/@hotmail|@outlook|@live|@msn/",$email))
        {
          return 'microsoft';
        }elseif(preg_match("/@yandex/",$email))
        {
          return 'yandex';
        }elseif(preg_match("/@icloud|@mac|@me/",$email))
        {
          return 'icloud';
        }elseif(preg_match("/@yahoo|@ymail|@rocketmail/",$email))
        {
          return 'yahoo';
        }elseif(preg_match("/@aol/", $email))
        {
          return 'aol';
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

    public function UploadImage($name,$ccname)
  {
    
    $filename = $_FILES[$name]['name'];
    $tmpname  = $_FILES[$name]['tmp_name'];
    $fileext  = strtolower(end(explode(".",$filename)));

    $allowed_ext = array('jpg','png','jpeg');

    if(!in_array($fileext,$allowed_ext))
    {
      return false;
      exit;
    }
    $base_dir = PUBLIC_PATH.'uploads/';
    $uploaded=$base_dir.$ccname.'.'.$fileext;
    @touch($uploaded);
    if(move_uploaded_file($tmpname,$uploaded))
    {
      @chmod($uploaded,0777);
      return $uploaded;
    }else{
      return false;
    }
    


  }
}