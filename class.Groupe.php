<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Classe.php');
require_once('class.EDT.php');
require_once('class.Personne.php');

class Groupe
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $name = null;
	private $isAClass = null;

	// --- OPERATIONS ---
	// getters
	public function getName()
	{
		return $this->name;
	}

	public function getIsAClass()
	{
		return $this->isAClass;
	}

	// setters
	public function setName($newName)
	{
		if (!empty($newName))
		{
			$this->name = $newName;
		}
	}

	public function setIsAClass($newIsAClass)
	{
		if (!empty($newIsAClass))
		{
			$this->isAClass = $newIsAClass;
		}
	}

	public function getTimetable()
	{
		$returnValue = null;

		return $returnValue;
	}
}
?>
