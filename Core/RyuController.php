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

/**
 * RyuController
 */
class RyuController{

    public $handler;
    public $curl;
    public $locale;
    public $bot;
    public $api;
    public $sec;
    
    public function __construct()
    {
        $this->handler = new RyuHandler;
        $this->curl = new RyuCurl;
        $this->locale = new RyuLocale;
        $this->bot = new RyuBots; 
        $this->api = new RyuApi;
        $this->sec = new RyuSecurity;
    }   
    public function minify($html)
    {
        $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace = array('>', '<', '\\1', '');
        $minify = preg_replace($search, $replace, $html);
        $minify = preg_replace('/<div/', '<!-- '.substr(md5($_SERVER['REMOTE_ADDR']),0,6).' --><div', $minify);
        $minify = preg_replace('/<\/div/', '<!-- '.base64_encode(time()).' --></div', $minify);
        $undetect = preg_replace('/class=\"/', 'class="'.substr(sha1((rand())),0,5).' ', $minify);

        return $undetect;
    } 
    /**
     * view
     *
     * @param  mixed $view
     * @param  mixed $data
     * @return void
     */
    public function view($view,$data = null)
    {
        ob_start('self::minify');
        if($data !== null)
        {
            extract($data);
        }
        if(file_exists(VIEW_PATH."{$view}.php"))
        {
            require_once VIEW_PATH."{$view}.php";
        }else{
            echo "error ".VIEW_PATH."{$view}.php";
            exit;
        }
        ob_end_flush();
    }    
    /**
     * helper
     *
     * @param  mixed $helper
     * @return void
     */
    public function helper($helper)
    {
        if(file_exists(HELPER_PATH . $helper .'_helper.php'))
        {
            require_once HELPER_PATH . $helper .'_helper.php';
        }else{
            echo "Helper not found";
            exit;
        }
    }
    /**
     * render
     *
     * @param  mixed $template
     * @param  mixed $view
     * @param  mixed $data
     * @return void
     */
    public function render($template , $view,$data=null)
    {
        if($data !== null)
        {
            extract($data);
        }
        if(file_exists(VIEW_PATH.$template.'.php'))
        {
            $content = $view;
            require_once VIEW_PATH.$template.'.php';
        }else{
            echo VIEW_PATH.$template.'.php doesnt exist';
        }
    }

    public function redirect($to,$delay ='0')
    {
        @ob_start();
        @ob_flush();
        @header('HTTP/1.1 302 Moved Permanent');
        @header('location:'.$to);
        return;
    }
}