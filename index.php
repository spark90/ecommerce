<?php 

require_once("vendor/autoload.php");// o que precisamos para criar nossa pagina

use \Slim\Slim;
use \Hcode\Page;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {// rota que estou chamando
    
	$page = new Page();
	$page->setTpl("index");

});

$app->run();// se tudo tiver carregado ele roda

 ?>