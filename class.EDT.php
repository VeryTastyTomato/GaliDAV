<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Cours.php');
require_once('class.Modification.php');
require_once('class.Utilisateur.php');

class EDT
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $idTimetable = null;
	private $modifiedBy = null;
	private $listCourses = null;
	private $listModif = null;

	// Attribut teacher_owner pour savoir si c'est un EDT de groupe/classe (null), ou EDT d'enseignant (celui-ci sera accessible depuis cet attribut)
	private $teacherOwner = null;

	// --- OPERATIONS ---
	// getters
	public function getIdTimetable()
	{
		return $this->idTimetable;
	}

	public function getModifiedBy()
	{
		return $this->modifiedBy;
	}

	public function getListCourses()
	{
		return $this->listCourses;
	}

	public function getListModif()
	{
		return $this->listModif;
	}	

	public function getTeacherOwner()
	{
		return $this->teacherOwner;
	}

	// setters

	public function setModifiedBy($newModifiedBy)
	{
		if (!empty($newModifiedBy))
		{
			$this->modifiedBy = $newModifiedBy;
		}
	}


	// others
	public function extractExams()
	{
		$examList = array();
		foreach ($this->listCourses as $tempCourse)
		{
			if ($tempCourse->getTypeOfCourse() = Examen)
			{
				$examList[] = $tempCourse;
			}			
		}
		return $examList;
	}
}
?>
