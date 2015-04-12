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
	public function __construct(Classe $c = NULL, $validated = FALSE)
	{
		parent::__construct($c, $validated);
	}

	// getters
	public function getClasse()
	{
		return parent::getGroup();
	}

	protected function setClasse(Classe $newClass = NULL)
	{
		parent::setGroup($newClass);
	}

	// others
	public function generatePDF()
	{
		// TODO
	}
}
?>
