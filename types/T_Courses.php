<?php
/**
 * \file  T_Courses.php
 * \brief Associates an \e integer constant to each type of courses.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

define("CM", 0);
define("TD", 1);
define("TP", 2);
define("CONFERENCE", 3);
define("EXAMEN", 4);
define("RATTRAPAGE", 5);
?>
