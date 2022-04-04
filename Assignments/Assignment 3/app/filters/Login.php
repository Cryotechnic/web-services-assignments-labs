<?php

namespace app\filters;
// Filter to make sure the user is logged in before any other action
#[\Attribute]
class Login	{
	function execute(){
		if(!isset($_SESSION['user_id'])){
			header('location:'.BASE.'app/controllers/ClientController.php');
			return true;
		}
		return false;
	}
}
