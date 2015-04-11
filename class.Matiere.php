<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Personne.php');

class Matiere
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $sqlid = null;
	private $name = null;
	private $teachedBy = array();

	const TABLENAME = "gsubject";
	const SQLcolumns = "id serial PRIMARY KEY, name varchar(30) NOT NULL, id_speaker1 integer REFERENCES gperson(id), id_speaker2 integer REFERENCES gperson(id), id_speaker3 integer REFERENCES gperson(id), id_group integer REFERENCES ggroup(id), id_calendar integer REFERENCES gcalendar(id)";

	// --- OPERATIONS ---
	// constructor
	public function __construct($newName)
	{
		if (!is_string($newName))
		{
			$newName = "Pas de nom";
		}

		$this->name = $newName;
		$params = array();
		$params[] = $newName;

		$query = "INSERT INTO ".self::TABLENAME." (name) VALUES ($1);";

		$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);

		if (!$result)
		{
			echo("GaliDAV: Impossible de créer cette matière dans la base");
		}
		else
		{
			echo("GaliDAV: matière créée avec succès !"); 
		}
	}

	// getters
	public function getName()
	{
		return $this->name;
	}

	public function getTeachedBy()
	{
		return $this->teachedBy;
	}

	// setters
	public function setName($newName)
	{
		if (!empty($newName))
		{
			$this->name = $newName;
		}
	}

	public function setTeachedBy($newTeachedBy)
	{
		if (!empty($newTeachedBy))
		{
			$this->teachedBy[] = $newTeachedBy;
		}
	}

	// others
	public function isTeachedBy(Personne $P)
	{
		foreach($this->teachedBy as $person)
		{
			if ($person == $P)
			{
				return true;
			}
		}

		return false;
	}

	public function addTeacher(Personne $P)
	{	
		if (!($this->teachedBy[0] == null) && !($this->teachedBy[1] == null) && !($this->teachedBy[2] == null))
		{
			echo ('GaliDAV: 3 personnes enseignent déjà cette matière ! Remplacez-en un.');
		}
		else
		{
			if (!isTeachedBy($P))
			{
				$query = "SELECT id from ".self::TABLENAME." where name=".$this->name.";";
				$result1 = BaseDeDonnees::currentDB()->executeQuery($query);
				if(!$result1)
				{
					echo('GaliDAV: Aucune matière de ce nom');//weird if Matiere is instantiated ?
				}
				else
				{
					if($this->teachedBy[0] == null)
					{
						$query = "UPDATE ".self::TABLENAME." set id_speaker1=$1 where id=".$result1.";";
					}
					elseif($this->teachedBy[1] == null)
					{
						$query = "UPDATE ".self::TABLENAME." set id_speaker2=$1 where id=".$result1.";";
					}
					else
					{
						$query = "UPDATE ".self::TABLENAME." set id_speaker3=$1 where id=".$result1.";";
					}
					$params = array($P);
					$result2 = BaseDeDonnees::currentDB()->executeQuery($query, $params);
					$this->teachedBy[] = $P;
				}			
			}
			else
			{
				echo ('GaliDAV: cette personne enseigne déjà cette matière'); 
			}
		}
	}

	public function removeTeacher(Enseignant $E)
	{
		//TODO
	}

	public function loadTeacherFromRessource($ressource) //we must have the teacher id
	{
		$E = new Enseignant();
		$E->loadFromDB(intval($ressource));
		$this->addTeacher($E);
	}

	public function loadGroupFromRessource($ressource)
	{
		$G = new Groupe();
		//TODO
		
	}

	public function loadTimetableFromRessource($ressource)
	{
		$E = new EDT();
		//TODO
		
	}

	public function loadFromDB($id = null)
	{
		if ($id == null)
		{
			if ($this->sqlid != null)
			{
				$id = $this->sqlid;
			}
		}

		else
		{
			$query = "select * from ".self::TABLENAME." where id=$1;";
			$params = array($id);
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$result = pg_fetch_assoc($result);
		}

		$this->sqlid = $result['id'];
		$this->name = $result['name'];
		
		$this->teachedBy = null;

		if($result['id_speaker1'])
		{
			$this->loadTeacherFromRessource($result['id_speaker1']);
			if($result['id_speaker2'])
			{
				$this->loadTeacherFromRessource($result['id_speaker2']);
				if($result['id_speaker3'])
				{
					$this->loadTeacherFromRessource($result['id_speaker3']);
				}
			}
		}
	}
	
	public function loadFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$this->sqlid = $ressource['id'];
			$this->name = $ressource['name'];
			
			$this->teachedBy=null;
			if($ressource['id_speaker1'])
			{
				$this->loadTeacherFromRessource($ressource['id_speaker1']);
				if($ressource['id_speaker2'])
				{
					$this->loadTeacherFromRessource($ressource['id_speaker2']);
					if($ressource['id_speaker3'])
					{
						$this->loadTeacherFromRessource($ressource['id_speaker3']);
					}
				}
			}
		}
	}
	
	public function removeFromDB()
	{
		//TODO
		
	}
}
?>
