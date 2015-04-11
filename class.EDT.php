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
	protected $modifiedBy = null;
	protected $listCourses = array();
	protected $listModif = array();
	protected $group = null;
	protected $teacherOwner = null; // if it’s a teacher’s timetable, else it’s value is null
	protected $subject = null; // Flora: For subject calendars: useful?
	protected $validated=false;
	const TABLENAME = "gcalendar";
	const SQLcolumns = "id serial PRIMARY KEY, id_collection bigint unique, id_teacher integer REFERENCES guser(id_person), is_class_calendar boolean default false, is_validated_calendar boolean default false, is_being_modified_by integer REFERENCES guser(id_person), date_creation timestamp default 'now'";
	/*Flora : 
	An EDT or calendar in the GaliDAV database can be a calendar of a class, a group, a subject or a teacher, since agendav doesn't implements a hierarchy of calendrs. Moreover, a class is linked to a current calendar and a validated calendar. Groups,subjects and teachers dont require a validated calendar.
	
	It is expected that every change to a current calendar affects all the calendars that are linked to it.
	See the class Groupe and its table named linkedTo.
	
	User changes are possible on class and subject current calendars. The system is in charge of updating all calendars related
	Rq: There's no SQL reference to a group id or a subject id in this table since there's already one in group table and subject table
	*/

		
	// --- OPERATIONS ---
	// constructor
	public function __construct($Object = null,$validated=false)
	{
		if(is_a($Object, "Groupe") or is_a($Object, "Matiere") or is_a($Object, "Enseignant")){
			$this->validated=false;
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
						BaseDeDonnees::currentDB()->show_error();
					}
					
					if($validated){
						$this->validated=true;
						$query="update ". self::TABLENAME." set is_validated_calendar=true where id=".$this->sqlid.";";
						if(!BaseDeDonnees::currentDB()->executeQuery($query))
						{
							BaseDeDonnees::currentDB()->show_error();
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
				if(BaseDeDonnees::currentDB()->executeQuery($query))
				{
					$this->group=$G;
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
			}
			else if (is_a($Object, "Matiere"))
			{	
				$M=$Object;
				$query="update ". Matiere::TABLENAME." set id_calendar=".$this->sqlid.";";
				if(BaseDeDonnees::currentDB()->executeQuery($query))
				{
					$this->subject=$M;
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
			}
			else if (is_a($Object, "Enseignant"))
			{
				$E=$Object;
				$query="update ". self::TABLENAME." set id_teacher=".$E->getSqlid().";";
				if(BaseDeDonnees::currentDB()->executeQuery($query))
				{
					$this->group=$G;
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
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
	public function getSubject()
	{
		return $this->subject;
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
			$query="update ". self::TABLENAME." set id=".$newIdTimetable." where id=".$this->sqlid.";";
			if(BaseDeDonnees::currentDB()->executeQuery($query))
			{
				$this->sqlid = $newIdTimetable;
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}
		}
	}

	public function setModifiedBy(Personne $newModifiedBy=null)
	{
		if (!empty($newModifiedBy))
		{
			$query="update ". self::TABLENAME." set is_being_modified_by=".$newModifiedBy->getSqlid()." where id=".$this->sqlid.";";
			if(BaseDeDonnees::currentDB()->executeQuery($query))
			{
				$this->modifiedBy = $newModifiedBy;
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}
		}else{
			$query="update ". self::TABLENAME." set is_being_modified_by=null where id=".$this->sqlid.";";
			if(BaseDeDonnees::currentDB()->executeQuery($query))
			{
				$this->modifiedBy = null;
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}
		}
	}

	public function setListCourses($newListCourses=null)
	{
		foreach ($this->listCourses as $oneCourse)
		{
			$this->removeCourse($oneCourse);
		}
		if(is_array($newListCourses))
		{
			foreach ($newListCourses as $aCourse)
			{
				$this->addCourse($aCourse);
			}
		}
	}

	public function setListModif(Modification $newListModif=null)
	{
		foreach ($this->listModif as $oneModif)
		{
			$this->removeModification($oneModif);
		}
		if(is_array($newListModif))
		{
			foreach ($newListModifs as $aModif)
			{
				$this->addModification($aModif);
			}
		}
	}

	public function setGroup(Groupe $newGroup=null)
	{
		if(!empty($newGroup))
		{
			if($this->validated)
				$query = "UPDATE ".Groupe::TABLENAME." set id_validated_calendar=".$this->sqlid." where id=".$newGroup->Sqlid().";";
			else
				$query = "UPDATE ".Groupe::TABLENAME." set id_current_calendar=".$this->sqlid." where id=".$newGroup->Sqlid().";";
	
			
				if (BaseDeDonnees::currentDB()->executeQuery($query))
				{
					$this->group=$newGroup;
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
		}else{
			if($this->validated)
				$query = "UPDATE ".Groupe::TABLENAME." set id_validated_calendar=null where id=".$newGroup->Sqlid().";";
			else
				$query = "UPDATE ".Groupe::TABLENAME." set id_current_calendar=null where id=".$newGroup->Sqlid().";";
	
			
				if (BaseDeDonnees::currentDB()->executeQuery($query))
				{
					$this->group=null;
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
		
		}
	}

	public function setSubject(Matiere $newSubject=null)
	{
		if(!empty($newSubject))
		{
			$query = "UPDATE ".Matiere::TABLENAME." set id_calendar=".$this->sqlid." where id=".$newSubject->Sqlid().";";
			if (BaseDeDonnees::currentDB()->executeQuery($query))
				{
					$this->subject=$newSubject;
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
		}else{
			$query = "UPDATE ".Matiere::TABLENAME." set id_calendar=null where id=".$newSubject->Sqlid().";";
			if (BaseDeDonnees::currentDB()->executeQuery($query))
				{
					$this->subject=null;
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
		}
	}
	public function setTeacherOwner(Enseignant $newTeacherOwner=null)
	{
		if (!empty($newTeacherOwner))
		{
			$query = "UPDATE ".self::TABLENAME." set id_teacher=".$newTeacherOwner->getSqlid()." where id=".$this->sqlid.";";
			if (BaseDeDonnees::currentDB()->executeQuery($query))
					$this->teacherOwner=$newTeacherOwner;
			else
				BaseDeDonnees::currentDB()->show_error();
		}else{
			$query = "UPDATE ".self::TABLENAME." set id_teacher=null where id=".$this->sqlid.";";
			if (BaseDeDonnees::currentDB()->executeQuery($query))
					$this->teacherOwner=null;
			else
				BaseDeDonnees::currentDB()->show_error();
		}
	}

	// others
	public function extractExams()
	{
	
		$examList = array();
		foreach ($this->listCourses as $tempCourse)
		{
			if ($tempCourse->getTypeOfCourse() == EXAMEN)
			{
				$examList[] = $tempCourse;
			}
		}

		return $examList;
	}

	public function addCourse(Cours $newCourse)
	{
		if(!$this->containsCourse($newCourse)){
			$query="insert ".Cours::belongsToTABLENAME." (id_course,id_calendar) VALUES(".$newCourse->getSqlid().",".$this->sqlid.";";
			if(BaseDeDonnees::currentDB()->executeQuery($query))
			{
				$this->listCourses[] = $newCourse;
				//TODO add this course to all calendars related to this one
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}			
		}
	}

	public function removeCourse(Cours $courseToRemove)
	{
		if($this->containsCourse($newCourse))
		{
			$query="delete from ".Cours::belongsToTABLENAME." where id_course=".$newCourse->getSqlid()." and id_calendar=".$this->sqlid.";";
			if(BaseDeDonnees::currentDB()->executeQuery($query))
			{
				unset($this->listCourses[array_search($courseToRemove, $this->listCourses)]);
				//TODO remove this course from all calendars related to this one
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}			
		}
	}

	public function addModification(Modification $M)
	{
		if(!hasModification($M))
		{			
			$this->listModif[]=$M;
			//No need for a SQL query, the modification should already have been registered in the DB
		}
	}
	
	
	//This method shouldnt be called outside this class because there's no reason that only one modification of timetable to be removed
	protected function removeModification(Modification $M)
	{
		if(!hasModification($M))
		{
			$M->removeFromDB(); 
			unset($this->listModif[array_search($M, $this->listModif)]);
		}
	
	}
	public function clearModifications()
	{
		foreach($this->listModif as $oneModif)
		{
			$oneModif->removeFromDB();
		}
		$this->listModif = array();
	}
	
	public function loadCourseFromRessource($ressource){
		$C=new Cours();
		$C->loadFromDB(int_val($ressource['id_course']));
		$this->addCourse($C);
	}
	
	//This method expects an array describing a ressource from a select query on modification table
	public function loadModificationFromRessource($ressource){
		$M=new Modification();
		$M->setDate($ressource['date']);
		
		$U=new Utilisateur();
		$U->loadFromDB(int_val($ressource['id_user']));
		$M->setModifiedBy($U);
		
		$C=new Cours();
		$C->loadFromDB(int_val($ressource['id_course']));
		$M->setCourseModified($C);
		
		$this->addModification($M);
	}
	
	public function loadFromDB($id = null,$onlyclasscalendar=false)
	{
		if ($id == null) //if we do not want to load a particularEDT
		{
			if ($this->sqlid != null) //Check if the current EDT object is defined
			{
				$id = $this->sqlid; //if yes, we want to 'reload' data about this object from the database (UPDATE)
			}
		}

		if ($id == null)//if no, the first EDT object of the DB, will be chosen to be loaded
		{
			if (!$onlyclasscalendar)
			{
				$query = "select * from ".self::TABLENAME.";";
			}
			else
			{
				$query = "select * from ".self::TABLENAME." where is_class_calendar=true;";
			}

			$result = BaseDeDonnees::currentDB()->executeQuery($query);
		}
		else //(if yes) From here, we load data about the EDT that has $id as sqlid
		{
			if ($onlyclasscalendar)//We load any EDT that matches the criteria
			{
				$query = "select * from ".self::TABLENAME." where id=$1;";
			}
			else //We load only EDTclasse that matches the criteria
			{
				$query = "select * from ".self::TABLENAME." where id=$1 and is_class_calendar=true;";
			}

			$params = array($id);
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			
		}
		$ressource = pg_fetch_assoc($result); //$ressource is now an array containing values for each SQLcolumn of the EDT table
		$this->loadFromRessource($ressource);
		
	}
	
	public function loadFromRessource($ressource)
	{
		//We change values of attributes
		$this->sqlid = $ressource['id'];
		$U=new Utilisateur();
		$U->loadFromDB(int_val($ressource['is_being_modified_by']));
		$this->modifiedBy = $U;
		$U=new Utilisateur();
		$U->loadFromDB(int_val($ressource['id_teacher']));
		$this->teacher = $U;
		$params=array($this->sqlid);
		
		if($ressource['is_validated_calendar']){
			$this->validated=true;
			$query = "select id from ".Groupe::TABLENAME." where id_validated_calendar=$1;";
		}
		else{
			$this->validated=false;
			$query = "select id from ".Groupe::TABLENAME." where id_current_calendar=$1;";
		}
		if($result2=BaseDeDonnees::currentDB()->executeQuery($query, $params)){
			$result2 = pg_fetch_assoc($result2);
			$G=new Groupe();
			$G->loadFromDB(int_val($result2['id']));
			$this->group = $G;
		}
		$query = "select id from ".Matiere::TABLENAME." where id_calendar=$1;";
		if($result2=BaseDeDonnees::currentDB()->executeQuery($query, $params)){
			$result2 = pg_fetch_assoc($result2);
			$M=new Matiere();
			$M->loadFromDB(int_val($result2['id']));
			$this->subject = $M;
		}
		
	}
	
	public function removeFromDB()
	{
		$this->setListModif();
		$this->setTeacherOwner();
		$this->setSubject();
		$query = "delete * from ".self::TABLENAME." where id=".$this->sqlid.";";
		if(BaseDeDonnees::currentDB()->executeQuery($query)){
		
		}
		else{
			BaseDeDonnees::currentDB()->show_error();
		}
	}
}
?>
