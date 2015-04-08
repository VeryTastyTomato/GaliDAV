<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Utilisateur.php');
require_once('class.Matiere.php');
require_once('Cours/unknown.Type_cours.php');
require_once('class.Groupe.php');
require_once('class.Classe.php');
require_once('class.Element_de_maquette.php');

class Secretaire extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	// constructor
	public function __construct($familyName, $firstName, $id, $passwd)
	{
		parent::__construct($familyName, $firstName, $id, $passwd);
		$this->addStatus(new Statut_personne(Statut_personne::SECRETARY));
	}

	// others
	public function modifyTimetable(EDT $e, Cours $c, $operation)
	{
		if ($operation == 'add')
		{
			$e->addCourse($c);
		}
		else if ($operation == 'remove')
		{
			$e->removeCourse($c);
		}
		else
		{
			echo 'Opération invalide';
		}
	}

	public function addGroup(String $name)
	{
		new Groupe($name, false);
	}

	public function modifyGroup_Members(Groupe $group, Personne $etu, $operation)
	{
		if ($operation == 'add')
		{
			$group->addStudent($etu);
		}
		else if ($operation == 'remove')
		{
			$group->removeStudent($etu);
		}
		else
		{
			echo 'Opération invalide';
		}
	}

	public function modifyGroup_LinkedClasses(Classe $c, Personne $etu, $operation)
	{
		if ($operation == 'add')
		{
			$c->addStudent($etu);
		}
		else if ($operation == 'remove')
		{
			$c->removeStudent($etu);
		}
		else
		{
			echo 'Opération invalide';
		}
	}

	// Flora NOTE: On va devoir faire appel aux commandes 'bas niveau' du serveur caldav
	public function compareTimetables($listOfTimetable, $begin, $end)
	{
		$returnValue = null;

		return $returnValue;
	}

	public function validateTimetable(EDT $e)
	{
		$e->emptyModifications();
	}

	// Flora TODO: implémenter des accesseurs pour la maquette dans la classe Classe
	public function modifyClass_CoursesModel(Classe $c, Element_de_maquette $elem,$operation)
	{
		if ($operation == 'add')
		{
			$c->getCoursesModel->addElemOfClassesModel($elem);
		}
		else if ($operation == 'remove')
		{
			$c->getCoursesModel->removeElemOfClassesModel($elem);
		}
		else
		{
			echo 'Opération invalide';
		}
	}
}
?>
