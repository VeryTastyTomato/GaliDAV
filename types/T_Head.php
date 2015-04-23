<?php
/**
 * \file  T_Head.php
 * \brief Associates an \e integer constant to each type of heads.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

define("RESP_ANNEE", 0);
define("RESP_FILIERE", 1);
define("DIR_ETUDE", 2);
?>
