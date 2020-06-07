<?php 
use \Hcode\Model\User;

function formatPrice($vlprice){


	if(!$vlprice > 0 ) $vlprice = 0;

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