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
	
	const TABLENAME="ggroup";
	const SQLcolumns="id serial PRIMARY KEY, name varchar(30) NOT NULL, is_class boolean not null DEFAULT false, id_current_timetable serial REFERENCES gcalendar(id),id_validated_timetable serial REFERENCES gcalendar(id)";
	
		
	const composedOfTABLENAME="ggroup_composed_of";
	const composedOfSQLcolumns="id_person serial REFERENCES gperson(id), id_group serial REFERENCES ggroup(id), constraint ggroup_composed_of_pk PRIMARY KEY(id_person,id_group)";
	
	const linkedToTABLENAME="ggroup_linked_to";
	const linkedToSQLcolumns="id_group serial REFERENCES ggroup(id), id_class serial REFERENCES ggroup(id), constraint ggroup_linked_to_pk PRIMARY KEY(id_group,id_class)";
	
	

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
