<?php
use Data\DataManager;
require_once('views/partials/header.php'); 
if($user == null || $user->getRoleId() != 1){
	header('Location: ?view=login');
	exit(1);
}
$categories = DataManager::getCategories();
if(isset($_GET['id'])){
	$article = DataManager::getArticle($_GET['id']);//inj
}
?>
<link href="assets/editor/editor.css" type="text/css" rel="stylesheet"/>
<script src="assets/editor/editor.js">
</script>
<?php
echo "<script>";
	require_once('views/js/write.js');
echo "</script>";
?>
<body>
  <button class="btn btn-success btn-lg"  onclick="save()"> Save
  </button>
  <select>
    <?php foreach($categories as $category):?>
    <option value="<?php echo $category->getId();?>">
      <?php echo $category->getName();?>
    </option>	
    <?php endforeach;?>
  </select>
  Title: <input type="text" id="title" value="<?php 	if(isset($article)) echo $article->getTitle();?>"/>
  
  Subtitle: <input type="text" id="subtitle" value="<?php 	if(isset($article)) echo $article->getSubTitle();?>"/>
  <!-- <textarea id="txtEditor"></textarea> -->
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 nopadding">
              <textarea id="txtEditor">
              </textarea> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid footer">
      <p class="pull-right">&copy; Suyati Technologies 
        <script>document.write(new Date().getFullYear())</script>. All rights reserved.
      </p>
    </div>
  </body>
</body>