<?php 
	use \Hcode\PageAdmin;
	use \Hcode\Model\User;



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





 ?>