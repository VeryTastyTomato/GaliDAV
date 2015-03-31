<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('Responsable/unknown.Type_responsable.php');
require_once('class.Groupe.php');
require_once('class.Classe.php');
require_once('class.Utilisateur.php');

class Responsable extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	// Flora NOTE: Etant donné que tous les responsables ont les mêmes droits de modifications, le type
	// est pour l'instant non réellement utile mais gardons le pour des évolutions futures.
	private $type = null;

	// --- OPERATIONS ---
	public function __construct($familyName, $firstName, $id, $passwd)
	{
		parent::__construct($familyName, $firstName, $id, $passwd);
		$this->addStatus(new Status_personne(Statut_personne::HEAD));
	}

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
	public function compareTimetable($listOfTimetable, $begin, $end)
	{
		$returnValue = null;

		return $returnValue;
	}

	public function validateTimetable(EDT $e)
	{
		$e->applyModifications();
	}

	// Flora TODO: implémenter des accesseurs pour la maquette dans la classe Classe
	public function modifyClass_CoursesModel(Classe $c, Matiere $m, Type_cours $type, $numHours)
	{
	}
}
?>
