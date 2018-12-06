<?php
namespace MyCms;
use Data\DataManager;

class Controller extends BaseObject
{
    private static $instance = false;
    const ACTION = 'action';
	const LOAD = 'load';
    const PAGE = 'page';
	const VIEW = 'view';
    const USER_NAME = 'userName';
    const USER_PASSWORD = 'password';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
	private $view= 'welcome';

    private function __construct()
    {
    }

    public static function getInstance() : Controller {
        if (!self::$instance) {
            self::$instance = new Controller();
        }
        return self::$instance;
    }

    public function invokePostAction() : bool {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            throw new \Exception('Controller can only handle POST requests');
        } elseif (!isset($_REQUEST[self::ACTION])) {
            throw new \Exception(self::ACTION . ' not specified');
        }

        $action = $_REQUEST[self::ACTION];

        switch ($action) {
            case self::ACTION_LOGIN:
				if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME],
                    $_REQUEST[self::USER_PASSWORD])) {	
                    $this->forwardRequest(array('Invalid username or password'));
                }
                Util::redirect();
                break;
            case self::ACTION_LOGOUT:
                AuthenticationManager::signOut();
                Util::redirect();
                break;
			default:
                throw new \Exception('Unknown Controller action ' . $action);
        }
		
    }
	public static function cleanURL(String $url):String{
		if (!preg_match("/^[A-Za-z]+$/", $url) || preg_match("/php|file|http/", $url))
			throw new BadPageException("Bad character(s)", $url);
		else
			return $url;
	}
	public  function paint(){
		if($_SERVER['REQUEST_METHOD'] != 'GET'){
			throw new \Exception('Only GET request allowed to PagePainter');
		}
		if(isset($_REQUEST[self::VIEW])){			
			if(isset($_REQUEST[self::VIEW]) && file_exists('views/' . $_REQUEST[self::VIEW] . '.php'))
				 $this->view =  $_REQUEST[self::VIEW] ;
		}	
		require_once( 'views/' . self::cleanURL($this->view) . '.php');				
	}
	
    private function forwardRequest(array $errors = null, $target = null) {
        if ($target == null) {
            if (!isset($_REQUEST[self::PAGE])) {
                throw new \Exception('Missing target for forward');
            }
            $target = $_REQUEST[self::PAGE];
        }
        if (count($errors) > 0) {
            $target .= '&errors=' . urlencode(serialize($errors));
        }
        header('location: ' . $target);
        exit();
    }
}