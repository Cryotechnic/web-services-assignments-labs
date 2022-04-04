<?php
namespace app\core;

class Controller{
	public function view($name,$data=null){
		include 'app/views/' . $name . '.php';
	}
}