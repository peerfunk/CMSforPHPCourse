<?php
namespace MyCms;
class Article extends Entity{
	
	private  $title;
	private  $text;
	private  $author;
	private  $status;
	private  $category; 
	private  $created;
	private  $modified;
	private  $authorId;
	private  $commentCount;
	
	public function __construct(int $id, String $title, String $text, String $subtitle,String $author,int $authorId,Category $category,$modified,$created, int  $count, int $status){
		parent::__construct($id);
		$this->title = $title;
		$this->subtitle = $subtitle;
		$this->text = $text;
		$this->author = $author;
		$this->category = $category;
		$this->created = $created;
		$this->modified = $modified;
		$this->status = $status;
		$this->authorId = $authorId;
		$this->commentCount = $count;
	}
    public function getTitle(): String{
		return $this->title;
	}
	public function getSubTitle(): String{
		return $this->subtitle;
	}
	public function getTxt(): String{
		return $this->text;
	}
	public function getAuthor(): String{
		return $this->author;
	}
	public function getCategory() :Category{
		return $this->category;
	}
	public function getCreated() {
		return $this->created;
	}
	public function getModified(){
		return $this->modified;
	}
	public function getAuthorId(){
		return $this->authorId;
	}
	public function getStatus(): int{
		return $this->status;
	}
		public function getCommentCount(){
		return $this->commentCount;
	}
	
	public function getTextOverview(int $n) : String{
		return strip_tags(implode(' ', array_slice(explode(' ', $this->text,$n+1),0,$n))) . '...';		
	}
}
    