<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Utilisateur.php');
require_once('class.EDT.php');

class Enseignant extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $personalTimetable = NULL;

	// --- OPERATIONS ---
	// constructor
	public function __construct($familyName = NULL, $firstName = NULL, $login = NULL, $passwd = NULL, $email1 = NULL)
	{
		parent::__construct($familyName, $firstName, $login, $passwd);

		if ($login != NULL and $passwd != NULL)
		{
			$this->addStatus(new Statut_personne(Statut_personne::TEACHER));
			$this->personalTimetable = new EDT($this);
		}
	}

	// getters
	public function getPersonalTimetable()
	{
		return $this->personalTimetable;
	}

	// others
	public function readPersonalTimetable()
	{
		return parent::readTimetable($this->personalTimetable);
	}
}
?>
