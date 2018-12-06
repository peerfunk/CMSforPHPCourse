<?php
use MyCms\Util;
use MyCms\AuthenticationManager;
use Data\DataManager;
require_once('views/partials/header.php'); 

if(!isset($_GET['id'])){
	$errors[] = "No such article found!";
	require_once('views/partials/footer.php'); 
}else{
	$article = DataManager::getArticle($_GET['id']);

if(!isset($article) || $article==null || $article->getStatus()==0  ){ 
	$errors[] = "This Article currently unavailable"; //redirect 404 with message
	require_once('views/partials/footer.php'); 
}else{

	$article_id =  $article->getId();
	$comments =(DataManager::getComments($article_id));	
	
?>
<article>
 
    <h2> <?php echo $article->getTitle();?>  </h2>    <h3> <?php echo $article->getSubTitle();?> </h3>
  

  <div class="row">
    <div class="group1 col-sm-6 col-md-6">
      <span class="fa fa-bookmark"> 
        <?php echo $article->getCategory()->getName()?>
      </span>
    </div>
    <div class="group2 col-sm-6 col-md-6">
      <span class="fa fa-comments">
      </span> 
      <a href="#comments">
        <?php echo $article->getCommentCount() ;?> Comments 
      </a>
      <span class="fa fa-calendar-alt">
      </span> 
      <?php echo $article->getModified();?> 
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <?php echo $article->getTxt();?>
    </div>
  </div>
  <hr>
</article>

<?php
	require_once('views/partials/comments.php'); 
	require_once('views/partials/footer.php'); 
	}
}
?>