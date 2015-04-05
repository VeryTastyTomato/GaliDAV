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
	private $subject = null;

	// --- ATTRIBUTES ---
	private $typeOfCourse = null;
	private $numHours = null;

	// --- OPERATIONS ---
	// builders
	public function __construct($newSubject, $newTypeOfCourse, $newNumHours)
	{
		$this->subject = $newSubject;
		$this->typeOfCourse = $newTypeOfCourse;
		$this->numHours = $newNumHours;
	}

	// getters
	public function getTypeOfCourse()
	{
		return $this->typeOfCourse;
	}

	public function getNumHours()
	{
		return $this->numHours;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	// setters
	public function setTypeOfCourse($newTypeOfCourse)
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

	public function setSubject($newSubject)
	{
		if ($newSubject instanceof Matiere)
		{
			$this->subject = $newSubject;
		}
		else
		{
			echo 'Erreur dans la méthode setSubject() de la classe Element_de_maquette : l’argument donné n’est pas une matière.';
		}
	}
}
?>
