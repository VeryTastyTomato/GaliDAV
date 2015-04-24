<?php
/**
 * \file    C_Subject.php
 * \brief   Defines the class Subject.
 * \details Represents a subject.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_Person.php');

class Subject
{
	// --- ATTRIBUTES ---
	private $sqlId     = NULL;
	private $name      = NULL;
	private $teachedBy = array();
	private $group     = NULL;
	private $timetable = NULL;

	const TABLENAME  = "gsubject";
	const SQLcolumns = "id serial PRIMARY KEY, name VARCHAR(30) NOT NULL UNIQUE, id_speaker1 INTEGER REFERENCES gperson(id), id_speaker2 INTEGER REFERENCES gperson(id), id_speaker3 INTEGER REFERENCES gperson(id), id_group INTEGER REFERENCES ggroup(id), id_calendar INTEGER REFERENCES gcalendar(id)";

	// --- OPERATIONS ---
	/**
	 * \brief Subject’s constructor
	 * \param $newName  \e String containing the subject’s name.
	 * \param $newGroup Contains the group of the subject.
	*/
	public function __construct($newName = NULL, $newGroup = NULL)
	{
		if (!is_string($newName))
		{
			$newName = "Pas de nom";
		}

		$this->name = $newName;
		$params     = array($newName);
		$params[]   = $newGroup->getId();
		$query      = "INSERT INTO " . self::TABLENAME . " (name, id_group) VALUES ($1, $2);";
		$result     = Database::currentDB()->executeQuery($query, $params);

		if (!$result)
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
		}
		else
		{
			$result = pg_fetch_assoc($result);
			$params = array($newName);
			$query  = "SELECT id FROM " . self::TABLENAME . " WHERE name = $1;";

			if (!Database::currentDB()->executeQuery($query,$params))
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS_);
			}
			else
			{
				$this->group  = $newGroup;
				$this->sqlId  = $result['id'];
				$newTimetable = new Timetable($this);
				$this->timetable = $newTimetable;
			}
		}
	}

	// getters
	/**
	 * \brief  Getter for the attribute $sqlId.
	 * \return The \e integer value of $sqlId.
	*/
	public function getSqlId()
	{
		return $this->sqlId;
	}

	/**
	 * \brief  Getter for the attribute $name.
	 * \return The \e string value of $name.
	*/
	public function getName()
	{
		return $this->name;
	}

	/**
	 * \brief  Getter for the attribute $teachedBy.
	 * \return The value of $teachedBy.
	*/
	public function getTeachedBy()
	{
		return $this->teachedBy;
	}

	/**
	 * \brief  Getter for the attribute $timetable.
	 * \return The value of $timetable.
	*/
	public function getTimetable()
	{
		return $this->timetable;
	}

	/**
	 * \brief  Getter for the attribute $group.
	 * \return The value of $group.
	*/
	public function getGroup()
	{
		return $this->group;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $name.
	 * \param  $newName Contains the new value of $name.
	*/
	private function setName($newName)
	{
		if (is_string($newName))
		{
			$query  = "UPDATE " . self::TABLENAME . " SET name = $1 WHERE id = " . $this->sqlId . ";";
			$params = array($newName);

			if (Database::currentDB()->executeQuery($query, $params))
			{
				$this->name = $newName;
			}
			else
			{
				Database::currentDB()->showError();
			}
		}
	}

	/**
	 * \brief  Setter for the attribute $teachedBy.
	 * \param  $newTeachedBy Contains the new value of $teachedBy.
	*/
	public function setTeachedBy($newTeachedBy)
	{
		if (!empty($newTeachedBy))
		{
			$this->teachedBy[] = $newTeachedBy;
		}
	}

	// others
	/**
	 * \brief  Checks if the course is teached by the given person.
	 * \return TRUE if the given person teaches this course, FALSE otherwise.
	*/
	public function isTeachedBy(Person $aPerson)
	{
		foreach ($this->teachedBy as $onePerson)
		{
			if ($onePerson == $aPerson)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * \brief  Adds the given teacher to the course.
	 * \param  $newTeacher The teacher to add.
	*/
	public function addTeacher(Person $newTeacher)
	{
		if (sizeof($this->teachedBy) >= 3 and isset($this->teachedBy[0]) and isset($this->teachedBy[1]) and isset($this->teachedBy[2]))
		{
			echo ('GaliDAV : 3 personnes enseignent déjà cette matière ! Remplacez-en un.');
		}
		else
		{
			if (!$this->isTeachedBy($newTeacher))
			{
				$query   = "SELECT id FROM " . self::TABLENAME . " WHERE name = '" . $this->name . "';";
				$result1 = Database::currentDB()->executeQuery($query);

				if (!$result1)
				{
					Database::currentDB()->showError('Aucune matière de ce nom');
				}
				else
				{
					$result1 = pg_fetch_assoc($result1);

					if (!isset($this->teachedBy[0]))
					{
						$query = "UPDATE " . self::TABLENAME . " SET id_speaker1 = $1 WHERE id = " . $result1['id'] . ";";
					}
					else if (!isset($this->teachedBy[1]))
					{
						$query = "UPDATE " . self::TABLENAME . " SET id_speaker2 = $1 WHERE id = " . $result1['id'] . ";";
					}
					else
					{
						$query = "UPDATE " . self::TABLENAME . " SET id_speaker3 = $1 WHERE id = " . $result1['id'] . ";";
					}

					$params  = array($newTeacher->getSqlId());
					$result2 = Database::currentDB()->executeQuery($query, $params);

					if ($result2)
					{
						$this->timetable->shareWith($newTeacher);
					}
				}
			}
			else
			{
				echo ('GaliDAV : cette personne enseigne déjà cette matière');
			}
		}
	}

	/**
	 * \brief  Removes the given teacher to the course.
	 * \param  $teacherToRemove The teacher to remove.
	*/
	public function removeTeacher(Person $teacherToRemove)
	{
		if (!$this->isTeachedBy($teacherToRemove)) 
		{
			echo ('L\'enseignant renseigné n\'enseigne pas cette matière');
		}
		else
		{
			if ($this->teachedBy[2] == $teacherToRemove)
			{
				$query = "UPDATE " . self::TABLENAME . " SET id_speaker3 = NULL WHERE id = " . $this->sqlId . ";";

				if (Database::currentDB()->executeQuery($query))
				{
					unset($this->teachedBy[2]);
				}
				else
				{
					Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}
			}

			if ($this->teachedBy[1] == $teacherToRemove)
			{
				$query = "UPDATE " . self::TABLENAME . " SET id_speaker2 = NULL WHERE id = " . $this->sqlId . ";";

				if (Database::currentDB()->executeQuery($query))
				{
					unset($this->teachedBy[1]);
				}
				else
				{
					Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}
			}

			if ($this->teachedBy[0] == $teacherToRemove)
			{
				$query = "UPDATE " . self::TABLENAME . " SET id_speaker1 = NULL WHERE id = " . $this->sqlId . ";";

				if (Database::currentDB()->executeQuery($query))
				{
					unset($this->teachedBy[0]);
				}
				else
				{
					Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}
			}
		}
	}

	/**
	 * \brief  Loads the subject from database.
	 * \param  $id The SQL id on the database.
	*/
	public function loadFromDB($id = NULL)
	{
		if ($id == NULL)
		{
			if ($this->sqlId != NULL)
			{
				$id = $this->sqlId;
			}
		}

		if ($id == NULL)
		{
			$query  = "SELECT * FROM " . self::TABLENAME . ";";
			$result = Database::currentDB()->executeQuery($query);
		}
		else
		{
			$query  = "SELECT * FROM " . self::TABLENAME . " WHERE id = $1;";
			$params = array($id);
			$result = Database::currentDB()->executeQuery($query, $params);
		}

		$result = pg_fetch_assoc($result);
		$this->loadFromRessource($result);
	}

	/**
	 * \brief Loads all data from the given ressource (???).
	 * \param $ressource The ressource from which data will be loaded.
	*/
	public function loadFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$this->sqlId     = $ressource['id'];
			$this->name      = $ressource['name'];
			$this->teachedBy = NULL;

			if ($ressource['id_speaker1'])
			{
				$newTeacher = new Teacher();
				$newTeacher->loadFromDB(intval($ressource['id_speaker1']));
				$this->addTeacher($newTeacher);

				if ($ressource['id_speaker2'])
				{
					$newTeacher = new Teacher();
					$newTeacher->loadFromDB(intval($ressource['id_speaker2']));
					$this->addTeacher($newTeacher);

					if ($ressource['id_speaker3'])
					{
						$newTeacher = new Teacher();
						$newTeacher->loadFromDB(intval($ressource['id_speaker3']));
						$this->addTeacher($newTeacher);
					}
				}
			}

			if ($result['id_group'])
			{
				$this->group = new Group();
				$this->group->loadFromDB(intval($ressource['id_group']));
			}

			if ($result['id_calendar'])
			{
				$this->timetable = new Timetable();
				$this->timetable->loadFromDB(intval($ressource['id_calendar']));
			}
		}
	}

	/**
	 * \brief Removes the subject from database.
	*/
	public function removeFromDB()
	{
		$this->timetable->removeFromDB(); // first we delete the associated calendar
		$query = "DELETE * FROM " . self::TABLENAME . " WHERE id = " . $this->sqlId . ";";

		if (!Database::currentDB()->executeQuery($query))
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
		}
	}
}
?>
