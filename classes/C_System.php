<?php
/**
 * \file    C_System.php
 * \brief   Defines the class System.
 * \details Represents the system.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was written for PHP 5');
}

require_once('C_Database.php');

class System
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $database = NULL;

	// --- OPERATIONS ---
	/**
	 * \brief System’s constructor
	 * \param $newDatabase The database managed by the system.
	*/
	public function __construct($newDatabase)
	{
		$this->database = $newDatabase;
	}

	// getters
	/**
	 * \brief  Getter for the attribute $database.
	 * \return The value of $database.
	*/
	public function getDatabase()
	{
		return $this->database;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $database.
	 * \param  $newDatabase Contains the new value of $database.
	*/
	public function setDatabase(Database $newDatabase)
	{
			$this->database = $newDatabase;
	}

	// others
	public function blockTimetable(Timetable $aTimetable)
	{
		// TODO
	}

	public function sendEmail(Person $aPerson)
	{
		// TODO
	}

	public function generatePDFTimetable(ClassesTimetable $aClassesTimetable)
	{
		// TODO
	}

	public function autoSave(Database $database)
	{
		// TODO
	}

	public function recoverData($location)
	{
		$database = NULL;

		return $database;
	}

	public function generateExamList(Timetable $aTimetable)
	{
		// TODO
	}
}
?>
