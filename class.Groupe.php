<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Classe.php');
require_once('class.EDT.php');
require_once('class.Personne.php');

/*flora: TODO  -Ecriture dans la BDD dans chaque setter
		-loadFromBDD()
		*/

class Groupe
{
	
	// --- ATTRIBUTES ---//Flora: Attributes shouldn't be private since they are used by inheriting classes
	protected $name = null;
	protected $isAClass = null;
	protected $timetable = null;
	protected $sqlid = null;
	protected $listOfStudents = array();
	protected $listOfLinkedGroups=array(); //Flora: A Classe object shouldn't be linked to other Classe objects
	const TABLENAME = "ggroup";
	const SQLcolumns = "id serial PRIMARY KEY, name varchar(30) UNIQUE NOT NULL, is_class boolean not null DEFAULT false, id_current_timetable integer REFERENCES gcalendar(id),id_validated_timetable integer REFERENCES gcalendar(id)";

	const composedOfTABLENAME = "ggroup_composed_of";
	const composedOfSQLcolumns = "id_person integer REFERENCES gperson(id), id_group integer REFERENCES ggroup(id), constraint ggroup_composed_of_pk PRIMARY KEY(id_person,id_group)";

	const linkedToTABLENAME = "ggroup_linked_to";
	const linkedToSQLcolumns = "id_group integer REFERENCES ggroup(id), id_class integer REFERENCES ggroup(id), constraint ggroup_linked_to_pk PRIMARY KEY(id_group,id_class)";

	// --- OPERATIONS ---
	// constructor
	public function __construct($newName = null, $newIsAClass = false)
	{
		if ($newName != null)
		{
			$this->name = $newName;
			$this->isAClass = $newIsAClass;
			$query="insert into ". self::TABLENAME." (name,is_class) VALUES ($1,$newIsAClass);"
			$params[] == $newName;
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$query = "select id from ". self::TABLENAME." where name=$1;"
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$result = pg_fetch_assoc($result);
			$this->sqlid=$result['id'];
			$this->timetable=new EDT($this);
		}
	}

	// getters
	public function getListOfStudents()
	{
		return $this->listOfStudents;
	}

	public function containsStudent(Personne $S){
		foreach ($this->listOfStudents as $oneStudent)
		{
			if ($oneStudent == $S)
			{
				return true;
			}
		}
		return false;
	}
	
	public function getName()
	{
		return $this->name;
	}

	public function getIsAClass()
	{
		return $this->isAClass;
	}
	
	public getId()
	{
		return $this->sqlid;
	}

	public function getTimetable()
	{
		$returnValue = null;

		return $returnValue;
	}
	
	// setters
	public function setListOfStudents($newListOfStudents)
	{
		foreach ($this->listOfStudents as $oneStudent)
		{
			$this->removeStudent($oneStudent);
		}
		foreach ($newListOfStudents as $aStudent)
		{
			$this->addStudent($aStudent);
		}
	}
	
	//Flora: this method is declared protected because the name of a group shouldn't change in time (or at least, groups should have different names)
	protected function setName($newName)
	{
		if (is_string($newName))
		{
			$query = "UPDATE ".self::TABLENAME." set name=$1 where id=".$this->sqlid.";";
			$params[] = $newName;
			
			if (BaseDeDonnees::currentDB()->executeQuery($query, $params))
			{
				$this->name = $newName;
			}
			else
			{
				echo("GaliDAV Error: Update on table ".self::TABLENAME." failed.<br/>(Query: $query )");
			}
		}
	}

	//Flora: this method is declared private because the attribute associated shouldn't change in time (eg: A group wont suddenly become a class). 
	private function setIsAClass($newIsAClass)
	{
		if (is_boolean($newIsAClass))
		{
			$query = "UPDATE ".self::TABLENAME." set is_class=".$newIsAClass." where id=".$this->sqlid.";";			
			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{
				$this->isAClass = $newIsAClass;
			}
			else
			{
				echo("GaliDAV Error: Update on table ".self::TABLENAME." failed.<br/>(Query: $query )");
			}
		}
	}

	// others
	

	public function addStudent(Personne $newStudent)
	{
		//Flora : TODO less prioritary -> check the person has a student. Not a real problem for the moment.
		if (!$this->containsStudent($newStudent)){
		
			$params[] = $newStudent->sqlid;
			$params[] = $this->sqlid;
			$query = "INSERT INTO ".self::composedOfTABLENAME." (id_person,id_group) VALUES ($1, $2);";
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->listOfStudents[] = $newStudent;
			}
			else {
				echo("GaliDAV Error: Insertion in table ".self::composedOfTABLENAME." failed.<br/>(Query: $query )");
			}			
		}
		
	}

	public function removeStudent(Personne $studentToRemove)
	{
		if ($this->containsStudent($studentToRemove))
		{
			$query = "DELETE FROM ".self::composedOfTABLENAME." where id_person=".$studentToRemove->getSqlid()." and id_group=".$this->sqlid.";";

			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{	
				//Flora: We have already checked the array contains the student to remove
				unset($this->listOfStudents[array_search($studentToRemove, $this->listOfStudents)]);
			}
			else 
			{
				echo("GaliDAV Error: Deletion in table ".self::composedOfTABLENAME." failed.<br/>(Query: $query )");
			}
		}
	}

}
?>
