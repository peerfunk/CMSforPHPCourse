<?php

namespace MyCms;
//use MyCms\AuthenticationManager;
use Data\DataManager;

class AJAXController extends BaseObject{
    private static $instance = false;
    const ACTION = 'ajax';
    const ACTIONS = array('createComment','newArticle','updateArticle','delComment','updateComment','registerUser','loadAllComments','updateArticleStatus');
	private $user = null;

    private function __construct(){
		$this->user = AuthenticationManager::getAuthenticatedUser();
    }
    public static function getInstance() : AJAXController {
        if (!self::$instance) {
            self::$instance = new AJAXController();
        }
        return self::$instance;
    }
	private static function logging($user_id, $action){
		DataManager::logger($user_id,$action, $_SERVER['REMOTE_ADDR']);
	}
	public function invokePostAction(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            throw new \Exception('Controller can only handle POST requests');
        } elseif (!isset($_REQUEST[self::ACTION])) {
            throw new \Exception(self::ACTION . ' not specified');
        }

        $action = $_REQUEST[self::ACTION];
		if(in_array($action, self::ACTIONS))
			if(isset($_REQUEST['data']))
				$this->execute($action);
	}	
	public function execute(String $action){
		if(AuthenticationManager::getAuthenticatedUser() == null){
				echo "Not Authenticated, please log in!";
		}else{
			self::logging($this->user->getId(),$action);
			if($action =='createComment'){ //check if user is logged 
					$var = json_decode($_POST['data']);
					//echo $var->comment . " ".  $var->user_id ." ".$var->article_id;
					if(DataManager::addComment($var->comment, $var->user_id, $var->article_id)){
						$comments = DataManager::getComments($var->article_id);
						//print_r($comments);
						echo json_encode(array("content"  => Comment::getAllComments($comments,$var->user_id),"count"  => count($comments)));
					}else
						echo "comment could not be added!";
			}
			if($action =='newArticle'){ // check if user is editor
				if($this->user->getRoleId() != 1){
					echo  "You cannot Create an Article!";
				}else{
					$data = json_decode($_POST['data']);
					$text = $data->text;
					$user = $data->user_id;
					$cat = $data->category;
					$title = $data->title;
					$subtitle = $data->subtitle;
					echo (DataManager::addArticle($text,$title,$subtitle,$user,$cat) );
				}
			}
			if($action =='updateArticle'){ // check if user is editor
				if($this->user->getRoleId()!=1){
					echo "You cannot update this Article!";
				}else{
					
					$data = json_decode($_POST['data']);
					$text = $data->text;
					$cat = $data->category;
					$title = $data->title;
					$subtitle = $data->subtitle;
					$aid= $data->article_id;
					//TODO: is this the comment of the logged in user?
					(DataManager::updateArticle($text,$title,$subtitle,$cat,$aid));
					echo $aid;
				}
			}
			if($action =='delComment'){ // check whether logged in user = user who created comment or article
					//is thisuser roleid =1 or is this his comment 
					$data = json_decode($_POST['data']);
					$id = $data->cid;
				if ($this->user->getRoleId() == 1 || true) echo(DataManager::setActivationComment($id) );
			}
			if($action =='updateComment'){ // check whether loged in user = user who created comment
				$data = json_decode($_POST['data']);
				$cid = $data->cid;
				$uid = $data->uid;
				$aid = $data->aid;
				$comment = $data->comment;
				if ($this->user->getRoleId() == 1 || true)(DataManager::updateComment($comment,$cid, $uid, $aid) ); //TODO: user of comment= thisUser
			}
			if($action =='registerUser'){
				$data = json_decode($_POST['data']);
				$user = $data->user;
				$pass = hash('sha1', "$user|$data->pass");
				$roleid = $data->roleid;		
				if ($this->user->getRoleId() == 1)(DataManager::registerUser($user, $pass,$roleid,1)); 
			}
			if($action =='loadAllComments'){
				$data = json_decode($_POST['data']);
				$article_id=$data->aid;
				$user_id=$data->uid;
				$author_id=$data->autid;
				echo Comment::getAllComments(DataManager::getComments($article_id),$user_id, $author_id);
			}
			if($action =='updateArticleStatus'){
				$data = json_decode($_POST['data']);
				if ($this->user->getRoleId() == 1)( DataManager::setActivationArticle($data->articleId));
			}
		}
	}	
}		
?>