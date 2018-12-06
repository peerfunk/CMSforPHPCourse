<?php
require_once('inc/bootstrap.php');
require_once('inc/Configuration.php');
$default_view = 'welcome';
$view = $default_view;

if (isset($_REQUEST[\MyCms\Controller::ACTION])) {
   \MyCms\Controller::getInstance()->invokePostAction();
}
else if (isset($_REQUEST[\MyCms\AJAXController::ACTION])) {
	\MyCms\AJAXController::getInstance()->invokePostAction();
}else{
	\MyCms\Controller::getInstance()->paint();
}
