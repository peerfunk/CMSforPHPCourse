<?php
namespace MyCms;
class Comment extends Entity{
	private $comment;
	private $author;
	private $date;
	private $articleId;
	private $authorid;
	private $status;
	public function __construct(int $id, String $comment, String $author,int $articleId, $authorid, $date,$status){
		parent::__construct($id);
		$this->date = $date;
		$this->comment = $comment;
		$this->author = $author;
		$this->id = $id;
		$this->articleId=$articleId;
		$this->authorid = $authorid;
		$this->status = $status;
	}
	public function getArticleId(): int{
		return $this->articleId;
	}
	public function getComment(): String{
		return $this->comment;
	}
	public function getAuthor(): String{
		return $this->author;
	}
	public function getAuthorId(){
		return $this->authorid;
	}
	public function getDate(){
		return $this->date;
	}
		public function getStatus(){
		return $this->status;
	}
	public static function getAllComments($comments, int $currentuser = null, int $authorid = null){
		$ret = '';
		if(count($comments)>0){
			foreach($comments as $comment){
				if($comment->getStatus()!=0){
					$ret .= '<div class="row comment"><div class="comment-header"><b>'. $comment->getAuthor() . '</b> (' . $comment->getDate() .')</div><div class="text col-md-12 text-left">' . $comment->getComment() . '</div>';
					if(($currentuser != null )&& ($currentuser == $authorid || $currentuser == $comment->getAuthorId())){
						$ret .="<div class='col-md-12 text-left'><div class='btn-group'>";
						if($currentuser == $comment->getAuthorId())
							$ret .=  "<button onclick='editComment($comment->id,$comment->authorid, $(this).parent().parent().parent());' class='btn btn-xs btn-primary'><i class='fas fa-edit'></i></span></button>";
						$ret .= "<button class='btn btn-xs btn-outline-danger' onclick='delComment($comment->id,$comment->authorid	, $(this).parent().parent().parent() );'> <i class='fas fa-trash-alt'></i></button></div></div>";
					}
					$ret .='<hr></div>';
				}
			}
		}else
			$ret  = "No Comments were found!";
		return $ret;
	}
	
}
    