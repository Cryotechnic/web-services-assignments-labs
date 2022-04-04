<?php
$fhinput = fopen('/xampp/php/php.ini', 'r');
$fhoutput = fopen('/xampp/php/php.ini.new', 'w');
while(!feof($fhinput)){
	$line = fgets($fhinput);
	$line = str_replace(';extension=gd', 'extension=gd', $line);
	fputs($fhoutput,$line);	
}
fclose($fhinput);
fclose($fhoutput);
shell_exec("del \\xampp\\php\\php.ini");
shell_exec("ren \\xampp\\php\\php.ini.new php.ini");
