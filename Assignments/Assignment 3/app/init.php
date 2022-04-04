<?php
session_start();
// Load code
include('core/autoload.php');
include('core/phpqrcode/qrlib.php');
// Pathing stuff
$path = getcwd().'/';
$path = str_replace('\\', '/', $path);
$path = preg_replace('/^.+\/htdocs\//', '/', $path);
$path = preg_replace('/\/+/', '/', $path);
define('BASE', $path);
