<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was generated for PHP 5');
}

require_once('class.BaseDeDonnees.php');

class Systeme
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $database = null;

	// --- OPERATIONS ---
	// constructor
	public function __construct($newDatabase)
	{
		$this->database = $newDatabase;
	}

	// getters
	public function getDatabase()
	{
		return $this->database;
	}

	// setters
	public function setDatabase(BaseDeDonnees $newDatabase)
	{
		if (!empty($newDatabase))
		{
			$this->database = $newDatabase;
		}
	}

	//others
	public function blockTimetable(EDT $edt)
	{
	//TODO
	}

	public function sendEmail(Personne $p)
	{
	//TODO
	}

	public function generateTimetable_PDF(EDTClasse $edt)
	{
	//TODO
	}

	public function autoSave(BaseDeDonnees $database)
	{
	//TODO
	}

	public function recoverData($location)
	{
		$database = null;
	//TODO (p-e mettre directement le résultat dans l'attribut "database" au lieu de simplement le retourner ?)
		return $database;
	}

	public function generateExamList(EDT $edt)
	{
	//TODO
	}
}
?>
