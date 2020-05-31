<?php 

require_once("vendor/autoload.php");// o que precisamos para criar nossa pagina

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;// sempre adicionar o user da pagina que vc for usar

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {// rota que estou chamando
    
	$page = new Page();
	$page->setTpl("index");

});


$app->get('/admin', function() {// rota que estou chamando
    
	$page = new PageAdmin();
	$page->setTpl("index");

});

$app->run();// se tudo tiver carregado ele roda

 ?>