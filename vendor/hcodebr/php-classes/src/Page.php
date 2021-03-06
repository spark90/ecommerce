<?php 
namespace Hcode;

use Rain\Tpl;

class Page{
	private $tpl;
	private $options = [];
	private $defaults =[
		"header"=>true,// padrão é sempre ter header e footer
		"footer"=>true,
		"data"=>[]
	];

	public function __construct($opts = array(),$tpl_dir = "/views/"){// se nao falar nada no parametro é /views

		$this->options = array_merge($this->defaults, $opts);// merge junta os array e pega o ultimo 

		$config = array(
		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
		"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
		"debug"         => false// set to false to improve the speed
	   );

	Tpl::configure( $config );

	$this->tpl = new Tpl;//atributo dessa classe
	$this->setData($this->options["data"]);
	if($this->options["header"] === true)$this->tpl->draw("header");// se header for igual verdadeiro carrega o header
	}

	private function setData($data = array()){
			foreach ($data as $key => $value) {
		$this->tpl->assign($key,$value);
		# code...
	}


	}

	public function setTpl($name,$data = array(), $returnHTML = false){

		$this->setData($data);
		$this->tpl->draw($name,$returnHTML);



	}


	public function __destruct(){

		if ($this->options["footer"] === true) $this->tpl->draw("footer");// se footer for igual a verdadeiro carrega o footer

	}

}



 ?>