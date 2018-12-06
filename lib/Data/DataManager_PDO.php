<?php

namespace Data;

use MyCms\Category;
use MyCms\User;
use MyCms\Article;
use MyCms\Comment;
use MyCms\Role;
use Settings\Configuration;

class DataManager {
	
    private static $__connection;

    /**
     * connect to the database
     *
     * note: alternatively put those in parameter list or as class variables
     *
     * @return connection resource
     */
    private static function getConnection() : \PDO {
        if (!isset(self::$__connection)) {
            self::$__connection = new \PDO(Configuration::getDbtype() . ':host=' . Configuration::getHost() . ';dbname='. Configuration::getDbName() . ';charset=utf8', Configuration::getUser() , Configuration::getPass());
        }
        return self::$__connection;
    }

    /**
     * place query
     *
     * note: using prepared statements
     * see the filtering in bindValue()
     *
     * @return mixed
     */
    private static function query(\PDO $connection, string $query, array $parameters = array()) {
        $statement = $connection->prepare($query);
		$i = 1;
        foreach ($parameters as $param) {
            if (is_int($param)) {
                $statement->bindValue($i, $param, \PDO::PARAM_INT);
            }
            if (is_string($param)) {
                $statement->bindValue($i, $param, \PDO::PARAM_STR);
            }
            $i++;
        }
		
        $statement->execute();
		return $statement;
    }
	 
	private static function escapeScrict(String $in){
		return htmlspecialchars($in);
	}
	
	private static function escapeLean(String $in){//normally I would use a lib for this and only whitelist but I am not allowed to so ...
		$blacklistelem = array('script','iframe','button','input','textbox','link','src','href','javascript','name','alert','onmouseover','onload','expression');
		
		foreach($blacklistelem as $elem){
			$in = preg_replace('/'. $elem.'/','',$in);
		}
		return $in;
	}	
	public static function lastInsertId(\PDO $connection) {
        return $connection->lastInsertId();
    }
    private static function fetchObject(\PDOStatement $cursor) {
        return $cursor->fetchObject();
    }
    private static function close(\PDOStatement $cursor) {
        $cursor->closeCursor();
    }
    private static function closeConnection() {
        self::$__connection = null;
    }
    public static function getCategories() {
        $categories = array();
        $con = self::getConnection();
        $res = self::query($con, "
      SELECT category_id, name 
      FROM category;
      ");
        while ($cat = self::fetchObject($res)) {
            $categories[] = new Category($cat->category_id, $cat->name);
        }
        self::close($res);
        self::closeConnection();
        return $categories;
    }
    public static function getArticle(int $articleId) {
        $con = self::getConnection();
		$article;
        $res = self::query($con, "
         SELECT article_id, category_id, article_title, article_text, date_created, date_modified,
					category.name as catname, category_id, status, article.article_subtitle,
					username, user_id , IFNULL(count,0) as count
					FROM article inner join category on article.category = category.category_id 
        			 inner join users on creator_id= user_id
                   	 left join (SELECT article.article_id, count(comments.comment_id) as count 
                                 FROM `article` left join comments on comments.article_id = article.article_id  where comments.status =1
                                 group by article.article_id)j  using(article_id)
					WHERE article_id= ?;
      ", array($articleId));
		if ($article = self::fetchObject($res)) {
			$category = new Category($article->category_id,$article->catname);
			$article = new Article((int)$article->article_id, $article->article_title, $article->article_text,$article->article_subtitle,$article->username,$article->user_id,$category,$article->date_modified,$article->date_created, $article->count,$article->status);
		}
        self::close($res);
        self::closeConnection();
        return $article;
    }
	public static function getArticles() {
			$articles = array();
			$con = self::getConnection();
			$res = self::query($con, "
			 SELECT article_id, category_id, article_title, article_text, date_created, date_modified,
					category.name as catname, category_id , status,article.article_subtitle as subtitle,
					username, user_id , IFNULL(count,0) as count
					FROM article inner join category on article.category = category.category_id 
        			 inner join users on creator_id= user_id
                   	 left join (SELECT article.article_id, count(comments.comment_id) as count 
                                 FROM `article` left join comments on comments.article_id = article.article_id where comments.status =1
                                 group by article.article_id)j  using(article_id) order by article.date_modified desc;
		  ",array());
			while($article = self::fetchObject($res)) {
				$category = new Category($article->category_id,$article->catname);
				$articles[] = new Article((int)$article->article_id, $article->article_title, $article->article_text,$article->subtitle,$article->username,$article->user_id,$category,$article->date_modified,$article->date_created, $article->count,$article->status);
			}
			self::close($res);
			self::closeConnection();
			return $articles;
		}
		public static function getArticlesOfUser(int $user_id) {
			$articles = array();
			$con = self::getConnection();
			$res = self::query($con, "
			 SELECT article_id, category_id, article_title, article_text, date_created, date_modified,
					category.name as catname, category_id , status,article.article_subtitle,
					username, user_id , IFNULL(count,0) as count
					FROM article inner join category on article.category = category.category_id 
        			 inner join users on creator_id=user_id
                   	 left join (SELECT article.article_id, count(comments.comment_id) as count 
                                 FROM `article` left join comments on comments.article_id = article.article_id where comments.status =1
                                 group by article.article_id )j  using(article_id) where users.user_id = ? order by article.date_modified desc;
		  ",array($user_id));
			while($article = self::fetchObject($res)) {
				$category = new Category($article->category_id,$article->catname);
				$articles[] = new Article((int)$article->article_id, $article->article_title, $article->article_text,$article->article_subtitle,$article->username,$article->user_id,$category,$article->date_modified,$article->date_created, $article->count,$article->status);
			}
			self::close($res);
			self::closeConnection();
			return $articles;
		}
	
	public static function addArticle(String $text, String $title,String $subtitle, int $user_id, int $category_id) : int {
		$con = self::getConnection();
		$sql ="INSERT INTO article(article_title, article_text, article_subtitle,category, creator_id,date_created) VALUES (?,?,?,?,?,now());";
	   $res = self::query($con, $sql, array(self::escapeScrict($title), self::escapeLean($text),self::escapeScrict($subtitle), $category_id, $user_id));
       self::close($res);
	   self::closeConnection();
        return(self::lastInsertId($con));
    }
	public static function updateArticle(String $text, String $title,String $subtitle , int $category_id, int $articleId)  {
		$con = self::getConnection();
		$sql ='Update article set article_title=?,  article_text=?, article_subtitle=?, category=? where article_id = ?;';
	   $res = self::query($con, $sql, array(self::escapeScrict($title), self::escapeLean($text),self::escapeScrict($subtitle), $category_id, $articleId));
       self::close($res);
	   self::closeConnection();
	 }
	public static function setActivationArticle(int $ArticleId){
			$con = self::getConnection();
			$res = self::query($con, "update article , (Select  (1-ar2.status) as status from article as ar2 where article_id=?) as A1 set article.status=A1.status where article.article_id =?;", array($ArticleId,$ArticleId));
			self::close($res);
			self::closeConnection();
			return($res);
	}
    public static function getUserById(int $userId) {
        $user = null;
        $con = self::getConnection();
        $res = self::query($con, "
      SELECT user_id, username, password_hash , users.role_id  as role_id ,RoleName
      FROM users  inner join roles on users.role_id = roles.role_id
      WHERE user_id = ?;
      ", array($userId));
        if ($u = self::fetchObject($res)) {
            $user = new User($u->user_id, $u->username, $u->password_hash, $u->role_id, $u->RoleName);
        }
        self::close($res);
        self::closeConnection();
        return $user;
    }

    public static function getUserByUserName(string $userName) {
        $user = null;
        $con = self::getConnection();
		$sql = "SELECT user_id, username, password_hash, users.role_id as role_id,RoleName FROM users  inner join roles on users.role_id = roles.role_id WHERE username = ?;";
	
        $res = self::query($con, $sql , array($userName));
        if ($u = self::fetchObject($res)) {
            $user = new User($u->user_id, $u->username, $u->password_hash, $u->role_id, $u->RoleName);
        }
        self::close($res);
        self::closeConnection();
        return $user;
    }

	 public static function getRoles(){
		 $roles = array();
			$con = self::getConnection();
			$res = self::query($con, "SELECT * from roles;",array());
			while($role = self::fetchObject($res)) {
				$roles[] = new Role((int)$role->role_id, $role->RoleName);
			}
			self::close($res);
			self::closeConnection();
			return $roles;
	 }
    public static function addComment( String $comment, int $user_id, int $article_id) {
		$con = self::getConnection();
        $res = self::query($con, "INSERT INTO comments (comment,user_id, article_id) VALUES (?,?,?);", array(self::escapeScrict($comment), $user_id, $article_id));
		self::close($res);
        self::closeConnection();
        return($res);
    }
	   public static function registerUser( String $user, String $pass, int $roleid, int $active) {
		$con = self::getConnection();
        $res = self::query($con, 'INSERT INTO users (username, password_hash, user_active,Role_id) VALUES (?,?,?,?);', array(self::escapeScrict($user),self::escapeScrict($pass),$active,$roleid));
		self::close($res);
        self::closeConnection();
        return($res);
		
    }
	   public static function logger( String $user_id, String $action, String $ip) {
		$con = self::getConnection();
        $res = self::query($con, 'INSERT INTO logger (user_id,action,ip) VALUES (?,?,?);', array($user_id,self::escapeScrict($action),self::escapeScrict($ip)));
		self::close($res);
        self::closeConnection();
        return($res);
		
    }
	
	
	public static function setActivationComment(int $Comment_id){
			$con = self::getConnection();
			$res = self::query($con, "update comments , (Select (1-C2.status) as status from comments as C2 where comment_id=?) as C1 set comments.status=C1.status where comments.comment_id =?;", array($Comment_id,$Comment_id));
			self::close($res);
			self::closeConnection();
			return($res);
	}
	
	// public static function delComment( int $id, int $uid,int $article_id) {
		// $con = self::getConnection();
        // $res = self::query($con, "DELETE from comments where comment_id = ? and  user_id = ? and  article_id = ?;", array($id, $uid, $article_id));
		// self::close($res);
        // self::closeConnection();
        // return($res);
    // }
	
	 public static function getComments(int $article_id) {
			$comments = array();
			$con = self::getConnection();
			$res = self::query($con, "SELECT comment_id,comment,username ,comments.user_id as user_id,  date as datecreated , comments.status FROM comments inner join users on comments.user_id = users.user_id WHERE article_id = ? order by date desc",array($article_id));
			while($comment = self::fetchObject($res)) {
				$comments[] = new Comment((int)$comment->comment_id, $comment->comment, $comment->username,$article_id, $comment->user_id, $comment->datecreated, $comment->status);
			}
			self::close($res);
			self::closeConnection();
			return $comments;
		}
	public static function getCommentsOfUser(int $user_id) {
			$comments = array();
			$con = self::getConnection();
			$res = self::query($con, "select article_id, comment_id, comment, date, comments.status from comments inner join article using (article_id) where user_id =?;",array($user_id));
			while($comment = self::fetchObject($res)) {
				$comments[] = new Comment((int)$comment->comment_id, $comment->comment,"",$comment->article_id, $user_id, $comment->date,$comment->status);
			}
			self::close($res);
			self::closeConnection();
			return $comments;
		}
		
	public static function UpdateComment( String $comment, int $comment_id, int $user_id, int $article_id) {
			$con = self::getConnection();
			$res = self::query($con, "Update comments set comment = ? where comment_id=?  and user_id = ? and  article_id = ?;", array(self::escapeScrict($comment),$comment_id, $user_id, $article_id));
			self::close($res);
			self::closeConnection();
			return($res);
		}
}