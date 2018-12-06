<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 14.11.2017
 * Time: 11:24
 */
use MyCms\AuthenticationManager;
use MyCms\Util;
use MyCms\Controller;

if (AuthenticationManager::isAuthenticated()) {
    Util::redirect("index.php");
}

require_once ('views/partials/header.php');
?>

    <div class="page-header">
        <h2>Login</h2>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Please fill out the form below:
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="<?php echo Util::action(Controller::ACTION_LOGIN); ?>">
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">User name:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputName" name="<?php echo Controller::USER_NAME; ?>" placeholder='admin'>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Password:</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="inputPassword" name="<?php echo Controller::USER_PASSWORD; ?>" placeholder='admin' >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" class="btn btn-default">Login</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

<?php
require_once ('views/partials/footer.php');