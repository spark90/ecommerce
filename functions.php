<?php 
use \Hcode\Model\User;

function formatPrice(float $vlprice){

	return number_format($vlprice, 2, ",",".");//separador da casa decimal é , casa de milhar é .

}

function checkLogin($inadmin = true)
{


	return User::checkLogin($inadmin);


}

function getUserName()
{
	
	$user = User::getFromSession();



	return $user->getdesperson();



}

 ?>