<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('Cours/unknown.Type_cours.php');
require_once('class.Maquette.php');
require_once('class.Matiere.php');

class Element_de_maquette
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $typeOfCourse = null;
	private $numHours = null;

	// --- OPERATIONS ---
	// getters
	public function getTypeOfCourse()
	{
		return $this->typeOfCourse;
	}

	public function getNumHours()
	{
		return $this->numHours;
	}

	// setters
	public function setTypeofCourse($newTypeOfCourse)
	{
		if (!empty($newTypeOfCourse))
		{
			$this->typeOfCourse = $newTypeOfCourse;
		}
	}

	public function setNumHours($newNumHours)
	{
		if (!empty($newNumHours))
		{
			$this->numHours = $newNumHours;
		}
	}
}
?>
