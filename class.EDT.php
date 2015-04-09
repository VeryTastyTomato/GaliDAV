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
	protected $subject = null; // Flora: For subject calendars: useful?

	const TABLENAME = "gcalendar";
	const SQLcolumns = "id serial PRIMARY KEY, id_collection bigint unique, is_class_calendar boolean, is_validated_calendar boolean default false, is_being_modified_by integer REFERENCES guser(id_person)";
	/*Flora : 
	An EDT or calendar in the GaliDAV database can be a calendar of a class, a group or a subject, since agendav doesn't implements a hierarchy of calendrs. Moreover, a class is linked to a current calendar and a validated calendar. Groups and subjects dont require a validated calendar.
	
	It is expected that every change to a current calendar affects all the calendars that are linked to it.
	See the class Groupe and its table named linkedTo.
	*/

/* TODO -containsCourse
		-hasModification
		-loadCourseFromRessource
		-loadModificationFromRessource
		
		-loadFromDB
		-loadFromRessource
		-removeFromDB
*/
		
	// --- OPERATIONS ---
	// constructor
	public function __construct($Object = null)
	{
		if (is_a($Object, "Groupe"))
		{
			//TODO attributs + requêtes SQL
		}
		else if (is_a($Object, "Matiere"))
		{
			//TODO attributs + requêtesSQL
		}
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
	protected function setIdTimetable($newIdTimetable)
	{
		if (!empty($newIdTimetable))
		{
			$this->idTimetable = $newIdTimetable;
			//TODO low priority: SQL query
		}
	}

	public function setModifiedBy(Personne $newModifiedBy=null)
	{
		if (!empty($newModifiedBy))
		{
			$this->modifiedBy = $newModifiedBy;
			//TODO SQL query
		}
		//TODO a different SQL query //The timetable isn't being modified
	}

	public function setListCourses($newListCourses=null)
	{
		//TODO
	}

	public function setListModif(Modification $newListModif=null)
	{
		//TODO
	}

	public function setGroup(Groupe $newGroup)
	{
		$this->group = $newGroup;
		//TODO SQL query
	}

	public function setTeacherOwner(Enseignant $newTeacherOwner=null)
	{
		if (!empty($newTeacherOwner))
		{
			$this->teacherOwner = $newTeacherOwner;
			//TODO SQL query
		}
		//TODO SQL query
	}

	// others
	public function extractExams()
	{
	
		$examList = array();
		foreach ($this->listCourses as $tempCourse)
		{
			if ($tempCourse->getTypeOfCourse() == Examen)//TODO : Modify
			{
				$examList[] = $tempCourse;
			}
		}

		return $examList;
	}

	public function addCourse(Cours $newCourse)
	{
			$this->listCourses[] = $newCourse;
			//TODO SQL query
	}

	public function removeCourse(Cours $courseToRemove)
	{
	
		//TODO SQL queries
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

	public function clearModifications()
	{
		$this->listModif = array();
		//TODO SqlQueries
	}
}
?>
