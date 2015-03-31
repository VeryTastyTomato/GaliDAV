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
	private $personalTimetable = null;

	// --- OPERATIONS ---
	public function __construct($familyName, $firstName, $id, $passwd)
	{
		parent::__construct($familyName, $firstName, $id, $passwd);
		$this->addStatus(new Statut_personne(Statut_personne::TEACHER));
		$this->personalTimetable = new EDT();
	}

	public function getPersonalTimetable()
	{
		return $this->personalTimetable;
	}

	public function readPersonalTimetable()
	{
		parent::readTimetable($this->personalTimetable);

		return parent::readTimetable($this->personalTimetable);
	}
}
?>
