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
    
    public function __construct()
    {
        $this->handler = new RyuHandler;
        $this->curl = new RyuCurl;
        $this->locale = new RyuLocale;
        $this->bot = new RyuBots; 
        $this->api = new RyuApi;
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