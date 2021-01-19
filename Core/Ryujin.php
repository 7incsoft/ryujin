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

Class Ryujin{


    
    /**
     * run
     *
     * @return void
     */
    public function run(){
        session_start();
        $this->init();
        $this->autoload();
        $this->lib_load();
        $this->dispatch();
    }
    
    /**
     * init
     *
     * @return void
     */
    private function init(){
       

      

        define('SEPARATOR',DIRECTORY_SEPARATOR);
        
        define('ROOT_PATH', dirname(__DIR__).SEPARATOR);

        define('APP_PATH', ROOT_PATH . 'App'.SEPARATOR);

        define('VIEW_PATH',APP_PATH. 'views'.SEPARATOR);
        define('HELPER_PATH',ROOT_PATH . 'Core'. SEPARATOR . 'helpers'.SEPARATOR);

        define('CONFIG_PATH', APP_PATH .'config' .SEPARATOR);
        require_once CONFIG_PATH.'config.php';
        define('DEFAULT_ACTION', CONFIG['web']['default_action']);
        define('DEFAULT_CONTROLLER', CONFIG['web']['default_controller']);
        
        define('CONTROLLER_PATH',APP_PATH .'controllers'.SEPARATOR);

        define('PUBLIC_PATH', ROOT_PATH .'Public'.SEPARATOR);

        define('LIB_PATH', ROOT_PATH.'Core'.SEPARATOR.'libraries'.SEPARATOR);

        define('CONTROLLER', (isset($_REQUEST['c'])) ? $_REQUEST['c'] : DEFAULT_CONTROLLER);
        define('ACTION', (isset($_REQUEST['a'])) ? $_REQUEST['a'] : DEFAULT_ACTION);

        
        require_once __DIR__.DIRECTORY_SEPARATOR.'RyuController.php';

    }
    private  function autoload(){

        spl_autoload_register(array(__CLASS__,'load'));
    
    }
    private function lib_load()
    {
        spl_autoload_register(function($class)
        {
            require_once(LIB_PATH.$class.'.php');
        });
    }
    private  function load($classname){


        
    
        if (substr($classname, -10) == "Controller"){
    
           
            if(file_exists(CONTROLLER_PATH."$classname.ryujin.php")){
            require_once CONTROLLER_PATH . "$classname.ryujin.php";
            }else{
                throw new Exception("Can't load controller => $classname");
                exit;
            }
    
        }
    
    }
    
    
       private  function dispatch(){
    
        // Instantiate the controller class and call its action method
    
        $controller_name = ucfirst(CONTROLLER) . "Controller";
    
        $action_name = ACTION."Action";
        
        if(class_exists($controller_name)){
        $controller = new $controller_name;
        }else{
            throw new Exception($controller_name." Doesn't exists ");
            exit;
        }
        if(method_exists($controller,$action_name)){
        $controller->$action_name();
        }else{
            throw new Exception($action_name."Doesn't exists ");
            exit;
        }
    
    }     
}