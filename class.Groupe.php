<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Classe.php');
require_once('class.EDT.php');
require_once('class.Personne.php');

class Groupe
{
	// --- ATTRIBUTES --- // Flora: attributes shouldn’t be private since they are used by inheriting classes
	protected $name = NULL;
	protected $isAClass = NULL;
	protected $timetable = NULL;
	protected $sqlid = NULL;
	protected $listOfStudents = array();
	protected $listOfLinkedGroups = array(); // Flora: a Classe object shouldn’t be linked to other Classe objects

	const TABLENAME = "ggroup";
	const SQLcolumns = "id serial PRIMARY KEY, name varchar(30) UNIQUE NOT NULL, is_class boolean not NULL DEFAULT false, id_current_timetable integer REFERENCES gcalendar(id),id_validated_timetable integer REFERENCES gcalendar(id)";

	const composedOfTABLENAME = "ggroup_composed_of";
	const composedOfSQLcolumns = "id_person integer REFERENCES gperson(id), id_group integer REFERENCES ggroup(id), constraint ggroup_composed_of_pk PRIMARY KEY(id_person,id_group)";

	const linkedToTABLENAME = "ggroup_linked_to";
	const linkedToSQLcolumns = "id_group integer REFERENCES ggroup(id), id_class integer REFERENCES ggroup(id), constraint ggroup_linked_to_pk PRIMARY KEY(id_group,id_class)";

	// --- OPERATIONS ---
	// constructor
	public function __construct($newName = NULL, $newIsAClass = FALSE)
	{
		if ($newName != NULL)
		{
			CreateGroupAccount($newName, session_salted_sha1($newName));//The password is the same as the group name
			$this->name      = $newName;
			$this->isAClass  = $newIsAClass;
			$query           = "insert into " . self::TABLENAME . " (name,is_class) VALUES ($1,$newIsAClass);";
			$params[]        = $newName;
			$result          = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$query           = "select id from " . self::TABLENAME . " where name=$1;";
			$result          = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$result          = pg_fetch_assoc($result);
			$this->sqlid     = $result['id'];
			if($newIsAClass)
				$this->timetable = new EDT($this);
			else 
				$this->timetable = new EDTClasse($this);
		}
	}

	// getters
	public function getListOfStudents()
	{
		return $this->listOfStudents;
	}

	public function getListOfLinkedGroups()
	{
		return $this->listOfLinkedGroups;
	}

	public function containsStudent(Personne $S)
	{
		foreach ($this->listOfStudents as $oneStudent)
		{
			if ($oneStudent == $S)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	public function isLinkedTo(Group $G)
	{
		foreach ($this->listOfLinkedGroups as $oneGroup)
		{
			if ($oneGroup == $G)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getIsAClass()
	{
		return $this->isAClass;
	}

	public function getId()
	{
		return $this->sqlid;
	}

	public function getTimetable()
	{
		return $this->timetable;
	}

	// setters
	public function setListOfStudents($newListOfStudents = NULL)
	{
		foreach ($this->listOfStudents as $oneStudent)
		{
			$this->removeStudent($oneStudent);
		}

		if (is_array($newListOfStudents))
		{
			foreach ($newListOfStudents as $aStudent)
			{
				$this->addStudent($aStudent);
			}
		}
	}

	public function setListOfLinkedGroups($newListOfGroups = NULL)
	{
		foreach ($this->listOfLinkedGroups as $oneGroup)
		{
			$this->removeLinkedGroup($oneGroup);
		}

		if (is_array($newListOfGroups))
		{
			foreach ($newListOfGroupq as $aGroup)
			{
				$this->addLinkedGroup($aGroup);
			}
		}
	}

	// Flora: this method is declared protected because the name of a group shouldn’t change in time (or at least, groups should have different names)
	protected function setName($newName)
	{
		if (is_string($newName))
		{
			$query    = "UPDATE " . self::TABLENAME . " set name=$1 where id=" . $this->sqlid . ";";
			$params[] = $newName;

			if (BaseDeDonnees::currentDB()->executeQuery($query, $params))
			{
				$this->name = $newName;
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}
		}
	}

	// Flora: this method is declared private because the attribute associated shouldn’t change in time (eg: a group won’t suddenly become a class)
	private function setIsAClass($newIsAClass)
	{
		if (is_boolean($newIsAClass))
		{
			$query = "UPDATE " . self::TABLENAME . " set is_class=" . $newIsAClass . " where id=" . $this->sqlid . ";";

			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{
				$this->isAClass = $newIsAClass;
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}
		}
	}

	// others
	public function addStudent(Personne $newStudent)
	{
		// Flora : TODO less prioritary -> check the person has a student. Not a real problem for the moment.
		if (!$this->containsStudent($newStudent))
		{
			$params[] = $newStudent->sqlid;
			$params[] = $this->sqlid;
			$query    = "INSERT INTO " . self::composedOfTABLENAME . " (id_person,id_group) VALUES ($1, $2);";
			$result   = BaseDeDonnees::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->listOfStudents[] = $newStudent;
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}
		}
	}

	public function removeStudent(Personne $studentToRemove)
	{
		if ($this->containsStudent($studentToRemove))
		{
			$query = "DELETE FROM " . self::composedOfTABLENAME . " where id_person=" . $studentToRemove->getSqlid() . " and id_group=" . $this->sqlid . ";";

			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{
				// Flora: we have already checked the array contains the student to remove
				unset($this->listOfStudents[array_search($studentToRemove, $this->listOfStudents)]);
			}
			else
			{
				BaseDeDonnees::currentDB()->show_error();
			}
		}
	}

	public function addLinkedGroup(Groupe $G)
	{
		if (!$this->isLinkedTo($G))
		{
			$params[] = $G->sqlid;
			$params[] = $this->sqlid;
			$query    = "select * from " . self::linkedToTABLENAME . " where (id_class=$1 and id_group=$2) or (id_class=$1 and id_group=$2);";

			if (BaseDeDonnees::currentDB()->executeQuery($query, $params))
			{
				$this->listOfLinkedGroups[] = $G;
				// there’s nothing more to do since the DB seems to contain a link between the 2 groups
				// G should already have $this in its listOfLinkedGroups array.
			}
			else
			{
				if ($this->isAClass)
				{
					$query = "INSERT INTO " . self::linkedToTABLENAME . " (id_class,id_group) VALUES ($2, $1);";
				}
				else
				{
					$query = "INSERT INTO " . self::linkedToTABLENAME . " (id_class,id_group) VALUES ($1, $2);";
				}

				$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);

				if ($result)
				{
					$this->listOfLinkedGroups[] = $G;
					$G->addLinkedGroup($this);
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
			}
		}
	}

	public function removeLinkedGroup(Groupe $G)
	{
		if ($this->isLinkedTo($G))
		{
			$query = "DELETE FROM " . self::linkedToTABLENAME . " where (id_class=$1 and id_group=$2) or (id_class=$1 and id_group=$2);";
			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{
				// Flora: we have already checked the array contains the group to remove
				unset($this->listOfLinkedGroups[array_search($G, $this->listOfLinkedGroups)]);
			}
			else
			{
				// No error shown because it could happen the entry has already been removed by the group $G.
			}

			$G->removeLinkedGroup($this);
		}
	}

	public function loadFromDB($id = NULL, $can_be_class = TRUE)//$id can be an integer(id) or a string (name)
	{
		if ($id == NULL) // if we do not want to load a particular group
		{
			if ($this->sqlid != NULL) // check if the current group object is defined
			{
				$id = $this->sqlid; // if yes, we want to “reload” data about this object from the database (UPDATE)
			}
		}

		if ($id == NULL) // if no, the first group object of the DB, will be chosen to be loaded
		{
			if ($can_be_class)
			{
				$query = "select * from " . self::TABLENAME . ";";
			}
			else
			{
				$query = "select * from " . self::TABLENAME . " where is_class=false";
			}

			$result = BaseDeDonnees::currentDB()->executeQuery($query);
		}
		else // from here, we load data about the group that has $id as sqlid
		{
			if(is_int($id)){
				if ($can_be_class) // we load any group that matches the criteria
				{
					$query = "select * from " . self::TABLENAME . " where id=$1;";
				}
				else // we load only basic group (not class) that matches the criteria
				{
					$query = "select * from " . self::TABLENAME . " where id=$1 and is_class=false;";
				}

				
			}
			else if(is_string($id))
			{
				if ($can_be_class) // we load any group that matches the criteria
				{
					$query = "select * from " . self::TABLENAME . " where name=$1;";
				}
				else // we load only basic group (not class) that matches the criteria
				{
					$query = "select * from " . self::TABLENAME . " where name=$1 and is_class=false;";
				}
			}
			$params = array($id);
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
		}

	if($result){
		$result = pg_fetch_assoc($result); // $result is now an array containing values for each SQLcolumn of the group table
		$this->loadFromRessource($result);
		return true;
	}else
		return false;
	}

	public function loadFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			// We change the value of attributes
			$this->sqlid    = $ressource['id'];
			$this->name     = $ressource['name'];
			$this->isAClass = $ressource['is_class'];

			if (is_int($ressource['id_current_timetable']))
			{
				$this->timetable = new EDT();
				$this->timetable->loadFromDB(intval($ressource['id_current_timetable']));
			}

			// we load each element of the arraylist of students (students are people registered in people table)
			$this->ListOfStudents = NULL;
			$query                = "select * from " . self::composedOfTABLENAME . " where id_group=" . $this->sqlid . ";";
			$result               = BaseDeDonnees::currentDB()->executeQuery($query);
			$ressource            = pg_fetch_assoc($result);

			while ($ressource)
			{
				$this->loadStudentFromRessource($ressource);
				$ressource = pg_fetch_assoc($result);
			}

			// we load each element of the arraylist of linked groups (which are groups registerd in group table)
			$this->ListOfLinkedGroups = NULL;
			$query                    = "select * from " . self::linkedToTABLENAME . " where id_group=" . $this->sqlid . ";";
			$result                   = BaseDeDonnees::currentDB()->executeQuery($query);
			$ressource                = pg_fetch_assoc($result);

			while ($ressource)
			{
				$this->loadLinkedGroupFromRessource($ressource);
				$ressource = pg_fetch_assoc($result);
			}
		}
	}

	// this method expects a ressource resulting of a select query on composedOf table
	public function loadStudentFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$P = new Personne();
			$P->loadFromDB(intval($ressource['id_person']));
			$this->addStudent($P);
		}
	}

	// this method expects a ressource resulting of a select query on linkedTo table
	public function loadLinkedGroupFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$G = new Groupe();
			$G->loadFromDB(intval($ressource['id_group']));
			$this->addLinkedGroup($G);
		}
	}

	// Flora: beware, this method may imply many irreversible changes in dataBase
	// after this method, all Groupe instances should be reloaded from DB, to stay reliable
	public function removeFromDB()
	{
		$this->setListOfStudents(); // remove all students from the group (DB)
		$this->setListOfLinkedGroups(); // remove all links with other groups/classes (DB)
		$params = array(intval($this->sqlid));
		$this->timetable->removeFromDB();
		
		$query  = "select id from " . Matiere::TABLENAME . " where id_group=$1;";
		$result=BaseDeDonnees::currentDB()->executeQuery($query, $params);
		if($result){
			$array=pg_fetch_assoc($result);
			while($array!=null){
				$array=$array['id'];
				$S=new Matiere();
				if($S->loadFromDB($array['id']))
					$S->removeFromDB();
				$array=pg_fetch_assoc($result);
			}
		}
		
		$query  = "delete from " . self::TABLENAME . " where id=$1;";
		if (BaseDeDonnees::currentDB()->executeQuery($query, $params))
		{			
			$BDD = new BaseDeDonnees("davical_app", "davical");
			if (!$BDD->connect())
			{
				echo("pas de connexion vrs davical");
			}
			else
			{
				$params = array($this->name);
				$query2 = "delete from dav_principal where username=$1;";
				$BDD->executeQuery($query2, $params);
				$BDD->close();
			}
		
		}
		else
		{
			BaseDeDonnees::currentDB()->show_error();
		}
	}
}
?>
