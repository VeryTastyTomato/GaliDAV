<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Cours.php');
require_once('class.Utilisateur.php');

class Modification
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $date;
	private $madeBy = null;
	private $courseModified = null;

	// --- OPERATIONS ---
	// getters
	public function getDate()
	{
		return $this->date;
	}

	public function getMadeBy()
	{
		return $this->madeBy;
	}

	public function getCourseModified()
	{
		return $this->courseModified;
	}

	// setters
	public function setDate($newDate)
	{
		if (!empty($newDate))
		{
			$this->date = $newDate;
		}
	}

	public function setMadeBy($newMadeBy)
	{
		if (!empty($newMadeBy))
		{
			$this->madeBy = $newMadeBy;
		}
	}

	public function setCourseModified($newCourseModified)
	{
		if (!empty($newcourseModified))
		{
			$this->courseModified = $newCourseModified;
		}
	}
}
?>
