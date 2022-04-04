<?php
namespace app\controllers;

class Main extends \app\core\Controller{

	// Filter to make sure the user is logged in before any other action
	#[\app\filters\Login]
	public function index(){
		
	}

	// Register a new user
	public function register(){
		if(isset($_POST['action']) && $_POST['password'] == $_POST['password_confirm']){
			$user = new \app\models\User();
			$user->username = $_POST['username'];
			$user->password = $_POST['password'];
			$user->insert(); // password hashing
			header('location:' . BASE . 'Main/login');
		}
	}

	// Use: /Main/login, Login form
	public function login(){
		if(isset($_POST['action'])){
			$user = new \app\models\User();
			$user = $user->get($_POST['username']);
			if(password_verify($_POST['password'], $user->password_hash)){ // Add to session variable
				$_SESSION['user_id'] = $user->user_id;
				$_SESSION['username'] = $user->username;
				header('location:' . BASE . 'Main/index');
			}
		}
	}

	// Uploads a file to the server
	public function upload() {
		$user = new \app\models\User();
		if (isset($_POST['action'])) {
			$video = $_FILES["video"]["tmp_name"];
			$name = date("Ymd").time();
			$user->startRequest($_SESSION['user_id'],$_FILES["video"]["name"],$name.'.avi');
			$command = "ffmpeg -i $video $name.avi"; 
			system($command); // Execute the command
			$user->endRequest($name.'.avi'); // Update the database
			echo '<script>alert("File converted!")</script>'; // Alert the user
		}
	}

	// Use: /Main/logout, Logs out user
	public function logout(){
		session_destroy();
		header('location:/Main/login');
	}
}