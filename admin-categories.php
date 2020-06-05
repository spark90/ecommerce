<?php 
	
	use \Hcode\PageAdmin;
	use \Hcode\Model\User;
	use \Hcode\Model\Category;
	use \Hcode\Model\Product;


	 $app->get("/admin/categories", function(){
 		User::verifyLogin();
	 	$categories = Category::listAll();

 		$page = new PageAdmin();
	
		$page->setTpl("categories", [
			"categories"=>$categories
			]);



	 });


	 $app->get("/admin/categories/create", function(){
	 	User::verifyLogin();
 		
 		$page = new PageAdmin();
	
		$page->setTpl("categories-create");



	 });

	 $app->post("/admin/categories/create", function(){
	 	User::verifyLogin();
 		
 		$category = new Category();

 		$category->setData($_POST);
	
		$category->save();

		header('Location: /admin/categories');//redireciona para a tela principal
		exit;//para retornar a pagina


	 });

	 $app->get("/admin/categories/:idcategory/delete", function($idcategory){
	 	User::verifyLogin();
	 	$category = new Category();
	 	$category->get((int)$idcategory);
	 	$category->delete();

	 	header('Location: /admin/categories');
	 	exit;




	 });

	 $app->get("/admin/categories/:idcategory", function($idcategory){//rota tem uma tela vai mostrar html
	 	User::verifyLogin();
	 	$category = new Category();
	 	$category->get((int)$idcategory);//pega a variavel criada no get 
	 	$page = new PageAdmin();
	 	$page->setTpl("categories-update",[
	 		"category"=>$category->getValues()// passando o valor para o template  convertendo um objeto para um array

	 	]);




	 });

	 	 $app->post("/admin/categories/:idcategory", function($idcategory){//rota tem uma tela vai mostrar html
	 	 User::verifyLogin();
	 	$category = new Category();
	 	$category->get((int)$idcategory);//pega a variavel criada no get 
	 	$category->setData($_POST);//carrega os dados atuais e bota os dados que recebeu no post
	 	$category->save();
	 	header("Location: /admin/categories ");
	 	exit;



	 });

	 	
	 	 $app->get("/admin/categories/:idcategory/products", function($idcategory){
	 		User::verifyLogin();
	 	 $category = new Category();
	 	 $category->get((int)$idcategory);//pega apenas se for um numero da categoria
	 	$page = New PageAdmin();
	 	 $page->setTpl("categories-products",[
	 	 	'category'=>$category->getValues(),
	 	 	'productsRelated'=>$category->getProducts(),
	 	 	'productsNotRelated'=>$category->getProducts(false)

	 	 		]);

	 	 });

	 	  $app->get("/admin/categories/:idcategory/products/:idproduct/add", function($idcategory, $idproduct){
	 		User::verifyLogin();
	 	 $category = new Category();
	 	 $category->get((int)$idcategory);//pega apenas se for um numero da categoria
	 	$product = new Product();
	 	$product->get((int)$idproduct);
	 	$category->addProduct($product);
	 	header("Location: /admin/categories/".$idcategory."/products");
	 	exit;

	 	 });

 	   	  $app->get("/admin/categories/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct){
	 		User::verifyLogin();
	 	 $category = new Category();
	 	 $category->get((int)$idcategory);//pega apenas se for um numero da categoria
	 	$product = new Product();
	 	$product->get((int)$idproduct);
	 	$category->removeProduct($product);
	 	header("Location: /admin/categories/".$idcategory."/products");
	 	exit;

	 	 });



 ?>