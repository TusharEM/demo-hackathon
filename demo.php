<?php
ini_set(error_reporting,E_ALL);
ini_set("display_errors",1);
print "Here In";
// $path = "/var/www/html/repos"; 
// chdir($path);
print exec("whoami");
print exec("git clone https://github.com/TusharEM/demo-hackathon.git");
print "After Exec command";
?>