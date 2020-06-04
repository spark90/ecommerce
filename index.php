<?php 
	session_start();
	require_once("vendor/autoload.php");// o que precisamos para criar nossa pagina

	use \Slim\Slim;//pra não precisar chamar new \Slim\Slim()
	use \Hcode\Page;// Pra criar o html do site
	use \Hcode\PageAdmin;//Pra criar o html do admin
	use \Hcode\Model\User;


	$app = new Slim();

	$app->config('debug', true);

	$app->get('/', function() {// rota que estou chamando

	   
		$page = new Page();
		$page->setTpl("index");

	});


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

	$app->get("/admin/users", function(){
		User::verifyLogin();
		$users = User::listAll();

		$page = new PageAdmin();

		$page->setTpl("users",array(
		"users"=>$users
		));//nome do template
	});


	$app->get("/admin/users/create", function(){//acessando via get responde com html
		User::verifyLogin();

		$page = new PageAdmin();

		$page->setTpl("users-create");//nome do template
	});


	$app->get("/admin/users/:iduser", function($iduser){
		User::verifyLogin();
		$user = new User();
		$user->get((int)$iduser);
		$page = new PageAdmin();

		$page->setTpl("users-update", array(
			"user"=>$user->getValues()

		));
		
	});


	$app->get("/admin/users/:iduser/delete", function($iduser){//via post espera receber os dados no banco de dados
	User::verifyLogin();//verifica se o usuario estar logado
	$user = new User();
	$user->get((int)$iduser);
	$user->delete();
	header("Location: /admin/users");
	exit;
	

	});




	$app->post("/admin/users/create", function(){//via post espera receber 
 	
 	User::verifyLogin();

	$user = new User();

 	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

 	$user->setData($_POST);

	$user->save();

	header("Location: /admin/users");
 	exit;

	});


	$app->post("/admin/users/:iduser", function($iduser){//via post espera receber os dados no banco de dados
	User::verifyLogin();//verifica se o usuario estar logado
	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update();

	header("Location: /admin/users");
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


	$app->run();// se tudo tiver carregado ele roda
?>