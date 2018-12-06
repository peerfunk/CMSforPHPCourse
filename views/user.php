<?php
use Data\DataManager;

require_once('views/partials/header.php'); 


if($user == null){
	header('Location: ?view=login');
	exit(1);
}
$comments = DataManager::getCommentsOfUser($user->getId());
$articles = DataManager::getArticlesOfUser($user->getId());
echo "<script>";
require_once('views/js/user.js');
echo "</script>";

?>

 <style>
 i.circle {
  display: inline-block;
  border-radius: 80px;
  box-shadow: 0px 0px 2px #888;
  padding: 12px 12px;
  width:40px;
  height:40px;
}

.bgheader{
	background-size:100%;
	background-repeat: no-repeat;
	background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
	
}
 </style>


 <?php if(count($articles)>0):?>
 <a href="https://www.pexels.com/photo/finance-dollars-newspaper-stock-102720/" alt="Photo by Markus Spiske freeforcommercialuse.net from Pexels" style="color:inherit; text-decoration:none;">
 <div class="jumbotron text-center bgheader" style="background-image: url('assets/images/finance-financial-times-news-102720.jpg');">
  <h1 style="color: white; text-shadow: black 0.1em 0.1em 0.2em;">Your Articles</h1>
</div>
</a>
  <div class="row">
		<table class="table">
		  <thead class="thead-dark">
			<tr>
			  <th scope="col">ID</th>
			  <th scope="col">Article Header</th>
			  <th scope="col">Category</th>
			  <th scope="col">Created</th>
			  <th scope="col">Last Modified</th>
			  <th scope="col">Status</th>
			  <th scope="col">Edit</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php foreach($articles as $article){?>
			<tr>
				<th scope="row"><?php echo $article->getId();?></th>
				<td><a href="?view=article&id=<?php echo $article->getId();?>"><?php echo $article->getTitle();?></a></td>
				<td><?php echo $article->getCategory()->getName();?></td>
				<td><?php echo $article->getCreated();?></td>
				<td><?php echo $article->getModified();?></td>
				<td><button style="border:none; background: none;" value="<?php echo $article->getId();?>" onclick="changeStatusArticle($(this));"> <i class="fa circle <?php if($article->getStatus()==1){echo 'fa-check" style="color:green;"';}else{echo 'fa-times" style="color:red;"';}?>/></i></button></td> <?php //echo $article->getStatus()==1?"active":"inactive";?>
				<td><a href='?view=write&id=<?php echo $article->getId();?>'><i class="fa fa-edit circle"></i></a></td>
			</tr>
		  <?php }?>
		  </tbody>
		</table>
	</div>
<?php endif;?>

 <?php if(count($comments)>0):?>
 <a href="https://www.pexels.com/photo/memo-notebook-paper-pen-472311/" alt="Photo by Tirachard Kumtanom from Pexels" style="color:inherit; text-decoration:none;">
 <div  class="jumbotron text-center bgheader" style="background-image: url('assets/images/memo-notebook-paper-472311.jpg');">
  <h1 style="color: black; text-shadow: white 0.1em 0.1em 0.2em;">Your Comments</h1>
</div>
</a>	
	<div class="row">
		<table class="table">
		  <thead class="thead-dark">
			<tr>
			  <th scope="col">ID</th>
			  <th scope="col">Comment</th>
			  <th scope="col">Created</th>
			  <th scope="col">Status</th>
			</tr>
		  </thead>
		  <tbody>
		  
		  <?php foreach($comments as $comment){?>
			<tr>
				<th scope="row"><?php echo $comment->getId();?></th>
				<td><a href="?view=article&id=<?php echo $comment->getArticleId();?>"><?php echo $comment->getComment();?></a></td>
				<td><?php echo $comment->getDate();?></td>
				<td><button style="border:none; background: none;" value="<?php echo $comment->getId();?>" onclick="changeStatusComment($(this));"> <i class="fa circle <?php if($comment->getStatus()==1){echo 'fa-check" style="color:green;"';}else{echo 'fa-times" style="color:red;"';}?>/></i></button></td>
			</tr>
		  <?php }?>
		  </tbody>
		</table>
	</div>
<?php endif;?>

<?php require_once('views/partials/footer.php');