<?php 
define('__ROOT__', dirname(dirname(dirname(__FILE__)))); 
/*
print "__FILE__ ==>" . __FILE__; print "<br>";
print "dirname(__FILE__) ==>" . dirname(__FILE__); print "<br>";
print "dirname(dirname(__FILE__)) ==>" . dirname(dirname(__FILE__)); print "<br>";
print "dirname(dirname(dirname(__FILE__))) ==>" . dirname(dirname(dirname(__FILE__))); print "<br>";
print "__ROOT__ ==>" . __ROOT__; 

*/
define ('__HTTPHOST__', "http://" . $_SERVER['HTTP_HOST']); // eg. http://localhost 
define ('__HTTPURL__', "http://" . $_SERVER['HTTP_HOST'] . "/"); // eg. http://localhost/coditop
?> 