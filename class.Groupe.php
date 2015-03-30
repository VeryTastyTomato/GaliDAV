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
	private $listOfStudents = array();

	// --- ATTRIBUTES ---
	private $name = null;
	private $isAClass = null;

	// --- OPERATIONS ---
	// buiders
	public function __construct($newName, $newIsAClass)
	{
		$this->name = $newName;
		$this->isAClass = $newIsAClass;
	}

	// getters
	public function getName()
	{
		return $this->name;
	}

	public function getIsAClass()
	{
		return $this->isAClass;
	}

	public function getListOfStudents()
	{
		return $this->listOfStudents;
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

	// others
	public function addStudent($newStudent)
	{
		if ($newStudent instanceof Personne)
		{
			$this->listOfStudents[] = $newStudent;
		}
		else
		{
			echo 'Erreur dans la méthode addStudent() de la classe Groupe, l’argument donné n’est pas une personne.';
		}
	}

	public function removeStudent($studentToRemove)
	{
		if ($studentToRemove instanceof Personne)
		{
			$indice = array_search($studentToRemove, $this->listOfStudents);
			if ($indice !== false)
			{
				unset($this->listOfStudents[$indice]);
			}
			else
			{
				echo 'L’étudiant donné n’est pas dans ce groupe.';
			}
		}
		else
		{
			echo 'Erreur dans la méthode removeStudent() de la classe Groupe, l’argument donné n’est pas une personne.';
		}
	}
}
?>
