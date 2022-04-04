<?php
namespace app\core;

class Model{

	protected static $_connection = null;

	public function __construct(){
		$username = 'root';
		$password = '';
		$host = 'localhost';
		$DBname = 'Exam2'; 

		// Create connection
		if(self::$_connection == null){
			self::$_connection = new \PDO("mysql:host=$host;dbname=$DBname",$username,$password);
		}
	}

}