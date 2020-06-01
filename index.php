<?php 
session_start();
require_once("vendor/autoload.php");// o que precisamos para criar nossa pagina

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;// sempre adicionar o user da pagina que vc for usar
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {// rota que estou chamando

   
	$page = new Page();
	$page->setTpl("index");

});


$app->get('/admin', function() {// rota que estou chamando
     User::verifiyLogin();
	$page = new PageAdmin();
	$page->setTpl("index");

});



$app->get('/admin/login', function() {// rota que estou chamando
    
	$page = new PageAdmin([
			"header"=>false,
			"footer"=>false,
	]);
	$page->setTpl("login");

});

$app->post('/admin/login',function(){
	User::login($_POST["login"],$_POST["password"]);//pega a senha e o login do metodo login.html
	header("Location: /admin");
	exit;
});

$app->get('/admin/logout',function(){

	User::logout();
	Header("Location: /admin/login");
	exit;


});

$app->run();// se tudo tiver carregado ele roda

 ?>