<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.EDT.php');

class EDTClasse extends EDT
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	// constructor
	public function __construct($newIdTimetable, $newModifiedBy, $newGroup, $newTeacherOwner = null)
	{
		parent::__construct($newIdTimetable, $newModifiedBy, $newGroup, $newTeacherOwner);
	}

	// others
	public function generatePDF()
	{
		// TODO
	}
}
?>
