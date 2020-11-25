<?php 
session_start();

if ($_SERVER['SCRIPT_FILENAME'] == 'C:/wamp64/www/lemonologueduvosgien/index.php') {
	require_once ('config/devPc.php');
}
if ($_SERVER['SCRIPT_FILENAME'] == 'Applications/MAMP/htdocs/lemonologueduvosgien/index.php') {
	require_once ('config/devMac.php');
}	

require_once ('vendor/autoload.php');

require('src/controller/frontController.php');

$router = new BrunoGrosdidier\Blog\config\Router();
$router->run();
