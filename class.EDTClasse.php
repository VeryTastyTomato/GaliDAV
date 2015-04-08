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
	public function __construct(Classe $c)
	{
		parent::__construct($c);
	}

	// getters
	public function getClasse()
	{
	}

	// others
	public function generatePDF()
	{
		// TODO
	}
}
?>
