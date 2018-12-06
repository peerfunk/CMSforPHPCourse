<?php
use Data\DataManager;
use Data\Util;
$Roles = DataManager::getRoles();
require_once('views/partials/header.php'); 
if($user == null){
	header('Location: ?view=login');
	exit(1);
}
echo "<script>";
require_once('views/js/register.js');
echo "</script>";
?>
<h2>Register a new User
</h2>
<div class="row">
  <div class="needs-validation" class="col-sl-12">
    <div class="form-group">
      <label for="Username">Username
      </label>
      <input type="username" class="form-control" id="Username" aria-describedby="userHelp" placeholder="Enter Username" required>
      <small id="userHelp" class="form-text text-muted">Enter your prefered Username
      </small>
      <div class="invalid-feedback">
        Please enter a Username!
      </div> 
    </div>
    <div class="form-group">
      <label for="InputPassword">Password
      </label>
      <input type="password" class="form-control" id="InputPassword" aria-describedby="passHelp" placeholder="Password" required>
      <small id="passHelp" class="form-text text-muted">Enter your prefered Password
      </small>
      <div class="invalid-feedback">
        Please enter a Password!
      </div> 
    </div>
    <div class="form-group">
      <label for="UserRole">User Role
      </label>
      <select id="UserRole"  class="form-control form-control-lg custom-select" aria-describedby="RoleHelp">
        <?php foreach($Roles as $role) echo "<option value='" . $role->getId(). "'>" . $role->getRoleName() . "</option>";?>
      </select>
      <small id="RoleHelp" class="form-text text-muted">Select your User Role
      </small>
    </div>
    <button id="submit" onclick="submit($(this).parent())" class="btn btn-primary">Submit
    </button>
  </div>
</div>