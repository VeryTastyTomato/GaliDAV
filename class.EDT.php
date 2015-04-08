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

	// --- ATTRIBUTES --- //Flora: Attributes shouldn't be private since they are used by inheriting classes
	protected $idTimetable = null;
	protected $modifiedBy = null;
	protected $listCourses = null;
	protected $listModif = null;
	protected $group = null;
	protected $teacherOwner = null; // if it’s a teacher’s timetable, else it’s value is null

	const TABLENAME = "gcalendar";
	const SQLcolumns = "id serial PRIMARY KEY, id_collection bigint unique, is_class_calendar boolean, is_validated_calendar boolean default false, id_current_timetable serial,id_validated_timetable serial";

	// --- OPERATIONS ---
	// constructor
	public function __construct($newIdTimetable, $newModifiedBy, $newGroup, $newTeacherOwner = null)
	{
		$this->idTimetable = $newIdTimetable;
		$this->modifiedBy = $newModifiedBy;
		$this->group = $newGroup;
		$this->teacherOwner = $newTeacherOwner;
	}

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

	public function getGroup()
	{
		return $this->group;
	}

	public function getTeacherOwner()
	{
		return $this->teacherOwner;
	}

	// setters
	public function setIdTimetable($newIdTimetable)
	{
		if (!empty($newIdTimetable))
		{
			$this->idTimetable = $newIdTimetable;
		}
	}

	public function setModifiedBy($newModifiedBy)
	{
		if (!empty($newModifiedBy))
		{
			$this->modifiedBy = $newModifiedBy;
		}
	}

	public function setListCourses($newListCourses)
	{
		if (!empty($newListCourses))
		{
			$this->listCourses = $newListCourses;
		}
	}

	public function setListModif($newListModif)
	{
		if (!empty($newListModif))
		{
			$this->listModif = $newListModif;
		}
	}

	public function setGroup($newGroup)
	{
		if (!empty($newGroup))
		{
			$this->group = $newGroup;
		}
	}

	public function setTeacherOwner($newTeacherOwner)
	{
		if (!empty($newTeacherOwner))
		{
			$this->teacherOwner = $newTeacherOwner;
		}
	}

	// others
	public function extractExams()
	{
		$examList = array();
		foreach ($this->listCourses as $tempCourse)
		{
			if ($tempCourse->getTypeOfCourse() == Examen)
			{
				$examList[] = $tempCourse;
			}
		}

		return $examList;
	}

	public function addCourse($newCourse)
	{
		if ($newCourse instanceof Cours)
		{
			$this->listCourses[] = $newCourse;
		}
		else
		{
			echo 'Erreur dans la méthode addCourse() de la classe EDT : l’argument donné n’est pas un cours.';
		}
	}

	public function removeCourse($courseToRemove)
	{
		$indice;

		if ($courseToRemove instanceof Cours)
		{
			$indice = array_search($courseToRemove, $this->listCourses);
			if ($indice !== false)
			{
				unset($this->listCourses[$indice]);
			}
			else
			{
				echo 'Le cours n’est pas dans l’emploi du temps.';
			}
		}
		else
		{
			echo 'Erreur dans la méthode removeCourse() de la classe EDT : l’argument donné n’est pas un cours.';
		}
	}

	public function emptyModifications()
	{
		$this->listModif = array();
	}
}
?>
