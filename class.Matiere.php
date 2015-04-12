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
	private $sqlid = NULL;
	private $name = NULL;
	private $teachedBy = array();
	private $group = NULL;
	private $timetable = NULL; // may be we’ll use severals calendars for one subject? (1 calendar for CMs, 1 for TDs…) to settle
	// Flora: No, calendars are managed in davical. There’s one calendar for one subject + we do not care in this class about davical calendars

	const TABLENAME = "gsubject";
	const SQLcolumns = "id serial PRIMARY KEY, name varchar(30) NOT NULL UNIQUE, id_speaker1 integer REFERENCES gperson(id), id_speaker2 integer REFERENCES gperson(id), id_speaker3 integer REFERENCES gperson(id), id_group integer REFERENCES ggroup(id), id_calendar integer REFERENCES gcalendar(id)";

	// --- OPERATIONS ---
	// constructor
	public function __construct($newName=NULL,$newGroup=NULL)
	{
		if (!is_string($newName))
		{
			$newName = "Pas de nom";
		}

		$this->name = $newName;
		$params     = array($newName);
		$params[]=$newGroup->getID();
		$query      = "INSERT INTO " . self::TABLENAME . " (name,id_group) VALUES ($1,$2);";
		$result     = BaseDeDonnees::currentDB()->executeQuery($query, $params);	
		if (!$result)
		{
			BaseDeDonnees::currentDB()->show_error("ligne n°".__LINE__." class:".__CLASS_);
		}
		else
		{
			$result     = pg_fetch_assoc($result);
			$params     = array($newName);
			$query      = "select id from " . self::TABLENAME . " where name=$1;";
			if(!BaseDeDonnees::currentDB()->executeQuery($query,$params))
				BaseDeDonnees::currentDB()->show_error("ligne n°".__LINE__." class:".__CLASS_f);
			else{	
				$this->group=$newGroup;
				$this->sqlid     = $result['id'];
				$E = new EDT($this);
				$this->timetable = $E;
			}
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
	public function getTimetable()
	{
		return $this->timetable;
	}
	public function getGroup()
	{
		return $this->group;
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
		foreach ($this->teachedBy as $person)
		{
			if ($person == $P)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	public function addTeacher(Personne $P)
	{
	//TODO partager le calendrier matière avec l'ensignant si c un user
	
		//if (!($this->teachedBy[0] == NULL) && !($this->teachedBy[1] == NULL) && !($this->teachedBy[2] == NULL))
		if(sizeof($this->teachedBy)>=3 and isset($this->teachedBy[0]) and isset($this->teachedBy[1]) and isset($this->teachedBy[0]))
		{
			echo ('GaliDAV: 3 personnes enseignent déjà cette matière ! Remplacez-en un.');
		}
		else
		{
			if (!$this->isTeachedBy($P))
			{
				$query   = "SELECT id from " . self::TABLENAME . " where name='" . $this->name . "';";
				$result1 = BaseDeDonnees::currentDB()->executeQuery($query);

				if (!$result1)
				{
					BaseDeDonnees::currentDB()->show_error('Aucune matière de ce nom'); // weird if Matiere is instantiated?
				}
				else
				{
					$result1=pg_fetch_assoc($result1);
					if (!isset($this->teachedBy[0]))
					{
						$query = "UPDATE " . self::TABLENAME . " set id_speaker1=$1 where id=" . $result1['id'] . ";";
					}
					else if (!isset($this->teachedBy[1]))
					{
						$query = "UPDATE " . self::TABLENAME . " set id_speaker2=$1 where id=" . $result1['id'] . ";";
					}
					else
					{
						$query = "UPDATE " . self::TABLENAME . " set id_speaker3=$1 where id=" . $result1['id'] . ";";
					}

					$params            = array($P->getSqlid());
					$result2           = BaseDeDonnees::currentDB()->executeQuery($query, $params);
					$this->teachedBy[] = $P;
				}
			}
			else
			{
				echo ('GaliDAV: cette personne enseigne déjà cette matière');
			}
		}
	}

	public function removeTeacher(Personne $E)
	{
		if (!$this->isTeachedBy($E)) 
		{
			echo ('L\'enseignant renseigné n\'enseigne pas cette matière');
		}
		else
		{
			if ($this->teachedBy[2] == $E)
			{
				$query = "UPDATE " . self::TABLENAME . " set id_speaker3=NULL where id=" . $this->sqlid . ";";

				if (BaseDeDonnees::currentDB()->executeQuery($query))
				{
					unset($this->teachedBy[2]);
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
			}

			if ($this->teachedBy[1] == $E)
			{
				$query = "UPDATE " . self::TABLENAME . " set id_speaker2=NULL where id=" . $this->sqlid . ";";

				if (BaseDeDonnees::currentDB()->executeQuery($query))
				{
					unset($this->teachedBy[1]);
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
			}

			if ($this->teachedBy[0] == $E)
			{
				$query = "UPDATE " . self::TABLENAME . " set id_speaker1=NULL where id=" . $this->sqlid . ";";

				if (BaseDeDonnees::currentDB()->executeQuery($query))
				{
					unset($this->teachedBy[0]);
				}
				else
				{
					BaseDeDonnees::currentDB()->show_error();
				}
			}
		}
	}

	/*This method doesn’t exist anymore, due to a high difficulty. We load directly the teacher in "loadFromDB" and "loadFromRessource" methods
	public function loadTeacherFromRessource($ressource)
	{
	if(!empty($ressource['speaker1']))
	$E = new Enseignant();
	$E->loadFromDB(intval($ressource));
	$this->addTeacher($E);
	}*/
	// no group attribute for "Matiere", so?
	// Flora: yes, nut no need for this method

	public function loadGroupFromRessource($ressource)
	{
		$G = new Groupe();
		// TODO
	}

	// don’t know if it’s useful since the calendar is loaded easily in "loadFromRessource"
	// Flora: no need for this method

	public function loadTimetableFromRessource($ressource)
	{
		$E = new EDT();
		// TODO
	}

	public function loadFromDB($id = NULL)
	{
		if ($id == NULL)
		{
			if ($this->sqlid != NULL)
			{
				$id = $this->sqlid;
			}
		}

		if ($id == NULL)
		{
			$query  = "select * from " . self::TABLENAME . ";";
			$result = BaseDeDonnees::currentDB()->executeQuery($query);
		}
		else
		{
			$query  = "select * from " . self::TABLENAME . " where id=$1;";
			$params = array($id);
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
		}

		$result = pg_fetch_assoc($result);
		$this->loadFromRessource($result);
	}

	public function loadFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$this->sqlid     = $ressource['id'];
			$this->name      = $ressource['name'];
			$this->teachedBy = NULL;

			if ($ressource['id_speaker1'])
			{
				$E = new Enseignant();
				$E->loadFromDB(intval($ressource['id_speaker1']));
				$this->addTeacher($E);

				if ($ressource['id_speaker2'])
				{
					$E = new Enseignant();
					$E->loadFromDB(intval($ressource['id_speaker2']));
					$this->addTeacher($E);

					if ($ressource['id_speaker3'])
					{
						$E = new Enseignant();
						$E->loadFromDB(intval($ressource['id_speaker3']));
						$this->addTeacher($E);
					}
				}
			}

			if ($result['id_group'])
			{
				$this->group = new Groupe();
				$this->group->loadFromDB(intval($ressource['id_group']));
			}

			if ($result['id_calendar'])
			{
				$this->timetable = new EDT();
				$this->timetable->loadFromDB(intval($ressource['id_calendar']));
			}
		}
	}

	public function removeFromDB()
	{
		$this->timetable->removeFromDB();//first we delete the associated calendar

		//Etienne : Pas de gestion de groupe vu qu'on a pas de champs destiné à la Matiere dans Groupe ?
		//Etienne : idem pour les enseignants

		$query = "delete * from " . self::TABLENAME . " where id=" . $this->sqlid . ";";
		if (BaseDeDonnees::currentDB()->executeQuery($query))
		{
		}
		else
		{
			BaseDeDonnees::currentDB()->show_error();
		}
	}
}
?>
