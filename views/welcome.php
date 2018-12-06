<?php
use Data\DataManager;
require_once('views/partials/header.php'); 

$articles = DataManager::getArticles();
$categories = DataManager::getCategories();
echo "<script>";
	require_once('views/js/welcome.js');
echo "</script>";
?>
<style>
.bgheader{
	background-image: url('assets/images/coffee-cup-information-97050.jpg');
	background-size:100%;
	background-repeat: no-repeat;
	background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 25%;
}

</style>
<a href="https://www.pexels.com/photo/creative-smartphone-desk-notebook-97050/" alt="Photo by Markus Spiske freeforcommercialuse.net from Pexels" style="color:inherit; text-decoration:none;">

 <div class="jumbotron text-center bgheader border-bottom">
 <h1 style="color: white; text-shadow: black 0.1em 0.1em 0.2em;">Welcome to My CMS</h1>
</div>
</a>
<select onchange="cat(this);" >
    <?php foreach($categories as $category):?>
    <option value="<?php echo $category->getId();?>"><?php echo $category->getName();?></option>	
    <?php endforeach;?>
  </select>
  <button onclick="res();">Reset</button>


 <?php foreach($categories as $category){?>
	<div class="row  col-lg-12 border-bottom">
	<div id="category" class="<?php echo $category->getName();?>">
	<h2><?php echo $category->getName();?></h2>
    <div class="row">
	<?php foreach($articles as $article)if($article->getStatus()==1 && $article->getCategory()->getId() == $category->getId()){?>
		<div class="card">
			<div class="card-body">
				<a href="?view=article&id=<?php echo $article->getId();?>">
					<h3><?php echo $article->getTitle() . ' (' . $article->getSubTitle() . ')';?></h3>
					<p><?php echo $article->getTextOverview(3);?></p>
					<div class="author">Created by: <?php echo $article->getAuthor() . ", last mdfd. on " . $article->getModified() ;?> </div>
					<div class="comments"><?php echo $article->getCommentCount();?> Comment(s)</div>
				</a>
			</div>
		</div>

	 <?php }?>
	 
	 </div></br>
	 </div>
	 </div>
	 
	<?php }?>
</div>

<?php require_once('views/partials/footer.php');