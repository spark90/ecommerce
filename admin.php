<?php 
use \Hcode\PageAdmin;
use \Hcode\Model\User;


	$app->get('/admin', function() {// rota que estou chamando
	     User::verifyLogin();
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

	$app->get("/admin/forgot", function(){//mostra no html o esqueci a senha

		$page = new PageAdmin([
				"header"=>false,
				"footer"=>false,
		]);
		$page->setTpl("forgot");



	});

	$app->post("/admin/forgot", function (){//pega o email que o usuario mandou via post
		
	$user = User::getForgot($_POST["email"]);

	header("Location: /admin/forgot/sent");
	exit;

	});

	$app->get("/admin/forgot/sent", function(){

		$page = new PageAdmin([
				"header"=>false,
				"footer"=>false,
		]);
	
		$page->setTpl("forgot-sent");

		

	});

	$app->get("/admin/forgot/reset", function(){
		$user = User::validForgotDecrypt($_GET["code"]);//verifica o codigo via get

		$page = new PageAdmin([
				"header"=>false,
				"footer"=>false,
		]);
	
		$page->setTpl("forgot-reset", array(
			"name"=>$user["desperson"],//pega o name dentro da variavel desperson no banco de dados
			"code"=>$_GET["code"]

		));


	});

	 $app->post("/admin/forgot/reset", function(){
	 	$forgot = User::validForgotDecrypt($_POST["code"]);//verifica o codigo via post
	 	User::setForgotUsed($forgot["idrecovery"]);

	 	$user = new User();

	 	$user->get((int)$forgot["iduser"]);

	 	$password =  password_hash($_POST["password"], PASSWORD_DEFAULT,[
	 		"cost"=>12
	 		]);//criptografa a nova senha

	 	$user->setPassword($password);// pega o password do formulario via post

	 	$page = new PageAdmin([
				"header"=>false,
				"footer"=>false,
		]);
	
		$page->setTpl("forgot-reset-success");




	 });

 ?>