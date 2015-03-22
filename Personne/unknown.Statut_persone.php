<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

define("STUDENT", 0);
define("SPEAKER", 1);
define("TEACHER", 2);
define("SECREATARY", 3);
define("PERSON_IN_CHARGE", 4);
define("ADMINISTRATOR", 5);
define("OTHER", 6);
?>
