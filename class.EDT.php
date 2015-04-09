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
	protected $sqlid = null;
	protected $modifiedBy = false;
	protected $listCourses = array();
	protected $listModif = array();
	protected $group = null;
	protected $teacherOwner = null; // if it’s a teacher’s timetable, else it’s value is null
	protected $subject = null; // Flora: For subject calendars: useful?

	const TABLENAME = "gcalendar";
	const SQLcolumns = "id serial PRIMARY KEY, id_collection bigint unique, is_class_calendar boolean default false, is_validated_calendar boolean default false, is_being_modified_by integer REFERENCES guser(id_person), date_creation timestamp default 'now'";
	/*Flora : 
	An EDT or calendar in the GaliDAV database can be a calendar of a class, a group, a subject or a teacher, since agendav doesn't implements a hierarchy of calendrs. Moreover, a class is linked to a current calendar and a validated calendar. Groups,subjects and teachers dont require a validated calendar.
	
	It is expected that every change to a current calendar affects all the calendars that are linked to it.
	See the class Groupe and its table named linkedTo.
	
	User changes are possible on class and subject current calendars. The system is in charge of updating all calendars related
	*/

		
	// --- OPERATIONS ---
	// constructor
	public function __construct($Object = null,$validated=false)
	{
		if(is_a($Object, "Groupe") or is_a($Object, "Matiere") or is_a($Object, "Enseignant")){
			$query="insert into ". self::TABLENAME.";";
			BaseDeDonnees::currentDB()->executeQuery($query);
			$query = "select id from ". self::TABLENAME." order by date_creation desc;";
			$result = BaseDeDonnees::currentDB()->executeQuery($query);
			$result = pg_fetch_assoc($result);
			$this->sqlid=$result['id'];
			
			if (is_a($Object, "Groupe"))
			{
				$G=$Object;
			
				if($G->getIsAClass()){
					$query="update ". self::TABLENAME." set is_class_calendar=true where id=".$this->sqlid.";";
					if(!BaseDeDonnees::currentDB()->executeQuery($query))
					{
						echo("GaliDAV Error: Update on table ".self::TABLENAME." failed.<br/>(Query: $query )");
					}
					
					if($validated){
						$query="update ". self::TABLENAME." set is_validated_calendar=true where id=".$this->sqlid.";";
						if(!BaseDeDonnees::currentDB()->executeQuery($query))
						{
							echo("GaliDAV Error: Update on table ".self::TABLENAME." failed.<br/>(Query: $query )");
						}
					}
				}else
				{
					$validated=false; //Only Classes have validated calendars (->PDF)
				}
				if($validated)
				{
					$query="update ".Groupe::TABLENAME." set id_validated_timetable=".$this->sqlid." where id=".$G->getId().";";
				}
				else
				{
					$query="update ".Groupe::TABLENAME." set id_current_timetable=".$this->sqlid." where id=".$G->getId().";";
				}
				if(!BaseDeDonnees::currentDB()->executeQuery($query))
				{
					echo("GaliDAV Error: Update on table ".Groupe::TABLENAME." failed.<br/>(Query: $query )");
				}
			}
			else if (is_a($Object, "Matiere"))
			{
				//TODO attributs + requêtesSQL
				
				$M=$Object;
			}
			else if (is_a($Object, "Enseignant"))
			{
				$E=$Object;
				$query="update ". Utilisateur::TABLENAME." set id_calendar=".$this->sqlid.";";
					if(!BaseDeDonnees::currentDB()->executeQuery($query))
					{
						echo("GaliDAV Error: Update on table ".Utilisateur::TABLENAME." failed.<br/>(Query: $query )");
					}
			}
		}
	}

	// getters
	public function getId()
	{
		return $this->sqlid;
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
	
	public function containsCourse(Cours $C)
	{
		foreach ($this->listCourses as $oneCourse)
		{
			if ($oneCourse == $C)
			{
				return true;
			}
		}
		return false;
	}
	
	public function hasModification(Modification $M)
	{
		foreach ($this->listModif as $oneModif)
		{
			if ($oneModif == $M)
			{
				return true;
			}
		}
		return false;
	}

	// setters
	protected function setId($newIdTimetable)
	{
		if (is_int($newIdTimetable))
		{
			$this->sqlid = $newIdTimetable;
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
		if(!$this->containsCourse($newCourse)){
			$this->listCourses[] = $newCourse;
			//TODO SQL query
			
		}
	}

	public function removeCourse(Cours $courseToRemove)
	{
		if(!$this->containsCourse($newCourse))
		{
			//TODO SQL queries
			
			unset($this->listCourses[array_search($courseToRemove, $this->listCourses)]);
		}
	}

	public function addModification(Modification $M)
	{
		if(!hasModification($M))
		{
			//TODO SQL queries
			$this->listModif[]=$M;
			
		}
	}
	
	
	//This method shouldnt be called outside this class because there's no reason that only one modification of timetable to be removed
	protected function removeModification(Modification $M)
	{
		if(!hasModification($M))
		{
			//TODO SQL queries
			
			unset($this->listModif[array_search($M, $this->listModif)]);	
		}
	
	}
	public function clearModifications()
	{
		//TODO SqlQueries
		$this->listModif = array();
	}
	
	public function loadCourseFromRessource($ressource){
		$C=new Cours();
		//TODO
	}
	public function loadModificationFromRessource($ressource){
		$M=new Modification();
		//TODO
	}
	
	public function loadFromDB()
	{
		//TODO
	}
	
	public function loadFromRessource()
	{
		//TODO
		
	}
	
	public function removeFromDB()
	{
		//TODO
		
	}
}
?>
