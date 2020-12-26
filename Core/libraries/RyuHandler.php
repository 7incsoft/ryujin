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
    public function sendemail($fromName,$to,$subject,$message,$from)
    {
        if($from = null)
        {
            $fromMail = 'no-reply-'.time().'ryujinframework@php.net';
        }else{
            $fromMail = $from;
        }
        $this->mailer = new PHPMailer;
        if($this->smtp == true)
        {
            $this->mailer->isSMTP();
            $this->mailer->SMTPDebug=1;
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
            $this->mailer->From = $fromMail;
            $this->mailer->FromName = $from;                            
            $this->mailer->Subject = '=?UTF-8?B?'.base64_encode(" \xE2\x99\x93 ".$subject).'?=';
            $this->mailer->AltBody = $message;
            $this->mailer->MsgHTML($message);
            $this->mailer->AddAddress($to);
            $this->mailer->send();
        }else{
        
            $this->mailer->isMail();
            $this->mailer->CharSet =  "UTF-8";  
            $this->mailer->ContentType = "text/html"; 
            $this->mailer->Priority = 1;                                
            $this->mailer->SingleTo = true;
            $this->mailer->From = $fromMail;
            $this->mailer->FromName = $from;                            
            $this->mailer->Subject = '=?UTF-8?B?'.base64_encode(" \xE2\x99\x93 ".$subject).'?=';
            $this->mailer->AltBody = $message;
            $this->mailer->MsgHTML($message);
            $this->mailer->AddAddress($to);
            $this->mailer->send();
        }
    }
    
    
}