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
	//Flora: As I said in the issue, the property shouldn't be specific to EDTclasse
	//private $classe = null; //"classe" in french because "class" is a keyword in PHP
 
	// --- OPERATIONS ---

	// builders
	
	//Flora: The constructor must use the parent constructor
	/*
	public function __construct(Classe $c)
	{
		$this->classe = $c;
	}
	*/
	// getters
	public function getClasse()
	{
		return $this->getGroupe() //Flora: As I said in the issue, the property group/classe shouldn't be specific to EDTclasse
	}

	// others
	public function generatePDF()
	{
		// TODO
	}
}
?>
