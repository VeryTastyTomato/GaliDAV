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
	private $classe = null; //"classe" in french because "class" is a keyword in PHP
 
	// --- OPERATIONS ---

	// builders
	public function __construct(Classe $c)
	{
		$this->classe = $c;
	}

	// getters
	public function getClasse()
	{
		return $this->classe;
	}

	// others
	public function generatePDF()
	{
		// TODO
	}
}
?>
