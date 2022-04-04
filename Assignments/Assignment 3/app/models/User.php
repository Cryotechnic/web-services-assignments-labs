<?php
// User model class
class User{
	public $user_id;
	public $username;
	public $password_hash;
	public $password;
	protected static $_connection = null;
	
	public function __construct(){
		$username = 'root';
		$password = '';
		$host = 'localhost';
		$DBname = 'Video'; 


		// Create connection
		if(self::$_connection == null){
			self::$_connection = new \PDO("mysql:host=$host;dbname=$DBname", $username, $password);
		}
	}

	// Get user by username
	public function get($username){
		$SQL = 'SELECT * FROM user WHERE username LIKE :username';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$username]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'User');
		return $STMT->fetch(); // Returns the first row
	}

	// Insert a new user
	public function insert(){
		$this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
		$SQL = 'INSERT INTO user(username, password_hash) VALUES (:username, :password_hash)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$this->username, 'password_hash'=>$this->password_hash]);
	}

	// Request for conversion of a video
	public function startRequest($user_id, $video, $newVideo) {
		$SQL = 'INSERT INTO video VALUES (Default, :user_id, :video, :newVideo, Default, Default)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['user_id'=>$user_id, 'video'=>$video, 'newVideo'=>$newVideo]);
	}

	// Complete the conversion of a video
	public function endRequest($newVideo){
		$SQL = 'UPDATE video set completeTime = CURRENT_TIMESTAMP where newVideo = :newVideo';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['newVideo'=>$newVideo]);
	}
	
	// Verify authentication
	public function verify($username,$password){
		$SQL = 'SELECT * FROM user WHERE username = :username and password = :password and licenseEnd > CURRENT_DATE;';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$username, 'password'=>$password]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS, 'User');
		return $STMT->fetch(); 
	}

}