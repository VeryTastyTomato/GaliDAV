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

class Secretaire extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	public function __construct($familyName, $firstName, $id, $passwd)
	{
		parent::__construct($familyName, $firstName, $id, $passwd);
		$this->addStatus(new Statut_personne(Statut_personne::SECRETARY));
	}

	// Flora TODO: Utiliser les méthodes de la classe EDT pour compléter cette fonction
	public function modifyTimetable(EDT $e, Cours $c, $operation)
	{
		$returnValue = null;

		return $returnValue;
	}

	public function addGroup(String $name)
	{
		new Groupe($name, false);
	}

	// Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer un étudiant en l'occurence)
	public function modifyGroup_Members(Personne $etu, $operation)
	{
		$returnValue = null;

		return $returnValue;
	}

	// Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer un étudiant en l'occurence)
	public function modifyGroup_LinkedClasses(Classe $c, $operation)
	{
		$returnValue = null;

		return $returnValue;
	}

	// Flora NOTE: On va devoir faire appel aux commandes 'bas niveau' du serveur caldav
	public function compareTimetables($listOfTimetable, $begin, $end)
	{
		$returnValue = null;

		return $returnValue;
	}

	// Flora TODO: Utiliser les fonctions de la classe EDT (valider l'ensemble des modifs en l'occurrrence)
	public function validateTimetable(EDT $e)
	{
	}

	// Flora TODO: implémenter des accesseurs pour la maquette dans la classe Classe
	public function modifyClass_CoursesModel(Classe $c, Matiere $m, Type_cours $type, $numHours)
	{
	}
}
?>
