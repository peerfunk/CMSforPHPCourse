<?php
use MyCms\Util;
use MyCms\AuthenticationManager;
use Data\DataManager;
use Settings\Configuration;
$user = null;

$user = AuthenticationManager::getAuthenticatedUser();

if (isset($_GET["errors"])) {
    $errors = unserialize(urldecode($_GET["errors"]));
}
$user_id = null;
if($user != null){
	$user_id = $user->getId();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo Configuration::getSitename();?></title>
	<?php require_once('views/partials/includes.php')?>
<body>
<nav class="fixed-top  navbar navbar-expand-lg navbar-dark  bg-dark">
  <a class="navbar-brand" href="index.php"><i class="fas fa-home"></i> <?php echo Configuration::getSitename();?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
	
	<?php if ($user != null): ?>
				<li class="nav-item <?php if ($view === 'user') {?>active<?php }else echo "disabled"; ?>"><a class="nav-link" href="index.php?view=user"><i class="fa fa-list" style="color:white;"></i> User Overview</a></li>						
				<?php if($user->getRoleId() == 1):?>
					<li class="nav-item <?php if ($view === 'register') {?>active<?php }else echo "disabled"; ?>"><a class="nav-link" href="index.php?view=register"><i class="fas fa-user" style="color:white;"></i> Register New User</a></li>
					<li class="nav-item <?php if ($view === 'write') {?>active<?php }else echo "disabled"; ?>"><a class="nav-link" href="index.php?view=write"><i class="fa fa-pencil-alt" style="color:white;"></i> New Article</a></li>	
				<?php  endif;?>
	<?php endif;?>
	</ul>
	</div>
	<ul class="nav navbar-nav navbar-right login">	
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  <?php if($user == null): ?>
           Not logged in!
		  <?php else:  ?>
			Logged in as  <span class="bold"><?php echo Util::escape($user->getUserName()); ?></span>
		<?php  endif;?>
		</a>
		
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php if ($user == null): ?>
			
			<a class="dropdown-item" href="index.php?view=login">Login now</a>
		   <?php else:  ?>
		   <form method="post" action="<?php echo Util::action(MyCms\Controller::ACTION_LOGOUT);?>">
			<input class="btn btn-xs" role="button" type="submit" value="Logout" />
			</form>
		   <?php  endif;?>
		  
          
        </div>
        <!--</div>-->
      </li>
    </ul>
  <!--</div>-->
</nav>


<div class="container">