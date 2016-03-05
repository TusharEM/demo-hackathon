<?php
ini_set(error_reporting,E_ALL);
ini_set("display_errors",1);
print "Here In";

$input = file_get_contents("php://input");
$filename = 'test.txt';
$filehandle = fopen($filename, 'w');
fwrite($filehandle, $input);
fclose($filehandle);
?>