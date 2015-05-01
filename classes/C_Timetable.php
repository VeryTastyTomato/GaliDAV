<?php
/**
 * \file    C_Timetable.php
 * \brief   Defines the class Timetable.
 * \details A timetable or calendar in the GaliDAV database can be a calendar of a class, a group, a subject or a teacher, since AgenDAV doesn’t implement a hierarchy of calendars. Moreover, a class is linked to a current calendar and a validated calendar. Groups, subjects and teachers don’t require a validated calendar.
            It is expected that every change to a current calendar affects all the calendars that are linked to it.
            See the class Groupe and its table named linkedTo.
            User changes are possible on class and subject current calendars. The system is in charge of updating all calendars related.
            Note: There’s no SQL reference to a group id or a subject id in this table since there’s already one in group table and subject table.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_Course.php');
require_once('C_Modification.php');
require_once('C_User.php');
//require_once('shared_calendars.php');

class Timetable
{
	// --- ATTRIBUTES ---
	// Flora: Attributes shouldn’t be private since they are used by inheriting classes
	protected $sqlId        = NULL;
	protected $modifiedBy   = NULL;
	protected $coursesList  = array();
	protected $modifList    = array();
	protected $group        = NULL;
	protected $teacherOwner = NULL; // if it’s a teacher’s timetable, else it’s value is NULL
	protected $subject      = NULL;
	protected $validated    = FALSE;
	protected $idCollection = NULL;

	const TABLENAME = "gcalendar";
	const SQLcolumns = "id serial PRIMARY KEY, id_collection BIGINT UNIQUE, id_teacher INTEGER REFERENCES guser(id_person), is_class_calendar BOOLEAN DEFAULT FALSE, is_validated_calendar BOOLEAN DEFAULT FALSE, is_being_modified_by INTEGER REFERENCES guser(id_person), date_creation TIMESTAMP DEFAULT 'now'";

	// --- OPERATIONS ---
	/**
	 * \brief Timetable’s constructor
	 * \param $object    Contains either a group, a subject or a teacher.
	 * \param $validated \e Boolean indicating if the timetable is validated or not.
	*/
	public function __construct($object = NULL, $validated = FALSE)
	{
		if (($object instanceof Group) or ($object instanceof Subject) or ($object instanceof Teacher))
		{
			$this->validated = FALSE;
			$query           = "INSERT INTO " . self::TABLENAME . " DEFAULT VALUES;";

			if (!Database::currentDB()->executeQuery($query))
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}

			$query  = "SELECT id FROM " . self::TABLENAME . " WHERE id_collection IS NULL;";
			$result = Database::currentDB()->executeQuery($query);

			if ($result) 
			{
				$result      = pg_fetch_assoc($result);
				$this->sqlId = $result['id'];
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe : " . __CLASS__);
			}

			if ($object instanceof Group)
			{
				$aGroup = $object;

				if ($aGroup->getIsAClass())
				{
					$query = "UPDATE " . self::TABLENAME . " SET is_class_calendar = TRUE WHERE id = " . $this->sqlId . ";";

					if (!Database::currentDB()->executeQuery($query))
					{
						Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
					}

					if ($validated)
					{
						$this->validated = TRUE;
						$query           = "UPDATE " . self::TABLENAME . " SET is_validated_calendar = TRUE WHERE id = " . $this->sqlId . ";";

						if (!Database::currentDB()->executeQuery($query))
						{
							Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
						}
					}
				}
				else
				{
					$validated = FALSE; // only classes have validated calendars
				}

				if ($validated)
				{
					$query = "UPDATE " . Group::TABLENAME . " SET id_validated_timetable = " . $this->sqlId . " WHERE id = " . $aGroup->getSqlId() . ";";
				}
				else
				{
					$query = "UPDATE " . Group::TABLENAME . " SET id_current_timetable = " . $this->sqlId . " WHERE id = " . $aGroup->getSqlId() . ";";
				}

				if (Database::currentDB()->executeQuery($query))
				{
					$anIdCollection = (int)CreateCalendar($aGroup->getName(), $aGroup->getName() . " EDT");
					$this->setIdCollection($anIdCollection);
					$this->group = $aGroup;
				}
				else
				{
					Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}
			}
			else if ($object instanceof Subject)
			{
				$aSubject = $object;
				$query    = "UPDATE " . Subject::TABLENAME . " SET id_calendar = " . $this->sqlId . " WHERE id = " . $aSubject->getSqlId() . ";";

				if (Database::currentDB()->executeQuery($query))
				{
					$anIdCollection = (int)CreateCalendar($aSubject->getGroup()->getName(), $aSubject->getName() . " " . $aSubject->getGroup()->getName());
					$this->setIdCollection($anIdCollection);
					$this->subject = $aSubject;
				}
				else
				{	
					Database::currentDB()->showError("ligne numéro" . __LINE__ . " classe :" . __CLASS__);
				}
			}
			else if ($object instanceof Teacher)
			{
				$aTeacher = $object;
				$query    = "UPDATE " . self::TABLENAME . " SET id_teacher = " . $aTeacher->getSqlId() . " WHERE id = " . $this->sqlId . ";";

				if (Database::currentDB()->executeQuery($query))
				{
					$anIdCollection = (int)CreateCalendar($aTeacher->getLogin(), $aTeacher->getFullName() . " EDT");
					$this->setIdCollection($anIdCollection);
					$this->teacherOwner = $aTeacher;
				}
				else
				{
					Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}
			}

			$this->autoShare();
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
	 * \brief  Getter for the attribute $modifiedBy.
	 * \return The person, who modified the timetable, contained in $modifiedBy.
	*/
	public function getModifiedBy()
	{
		return $this->modifiedBy;
	}

	/**
	 * \brief  Getter for the attribute $coursesList.
	 * \return The list of courses contained in of $coursesList.
	*/
	public function getCoursesList()
	{
		return $this->coursesList;
	}

	/**
	 * \brief  Getter for the attribute $modifList.
	 * \return The list of modification contained in of $modifList.
	*/
	public function getModifList()
	{
		return $this->modifList;
	}

	/**
	 * \brief  Getter for the attribute $group.
	 * \return The group contained in $group.
	*/
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * \brief  Getter for the attribute $subject.
	 * \return The subject contained in $subject.
	*/
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * \brief  Getter for the attribute $teacherOwner.
	 * \return The teacher, who own this timetable, contained in $teacherOwner.
	*/
	public function getTeacherOwner()
	{
		return $this->teacherOwner;
	}

	/**
	 * \brief  Getter for the attribute $idCollection.
	 * \return The \e integer value of $idCollection.
	*/
	public function getIdCollection()
	{
		return $this->idCollection;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $sqlId.
	 * \param  $newSqlId Contains the new value of $sqlId.
	*/
	protected function setSqlId($newSqlId)
	{
		if (is_int($newSqlId))
		{
			$query = "UPDATE " . self::TABLENAME . " SET id = " . $newSqlId . " WHERE id = " . $this->sqlId . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->sqlId = $newSqlId;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
	}

	/**
	 * \brief  Setter for the attribute $idCollection.
	 * \param  $newIdCollection Contains the new value of $idCollection.
	*/
	protected function setIdCollection($newIdCollection)
	{
		if (is_int($newIdCollection))
		{
			$query = "UPDATE " . self::TABLENAME . " SET id_collection = " . $newIdCollection . " WHERE id = " . $this->sqlId . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->idCollection = $newIdCollection;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
	}

	/**
	 * \brief  Setter for the attribute $modifiedBy.
	 * \param  $newModifiedBy Contains the new value of $modifiedBy.
	*/
	public function setModifiedBy(Person $newModifiedBy = NULL)
	{
		if ($newModifiedBy instanceof Person)
		{
			$query = "UPDATE " . self::TABLENAME . " SET is_being_modified_by = " . $newModifiedBy->getSqlId() . " WHERE id = " . $this->sqlId . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->modifiedBy = $newModifiedBy;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
		else
		{
			$query = "UPDATE " . self::TABLENAME . " SET is_being_modified_by = NULL WHERE id = " . $this->sqlId . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->modifiedBy = NULL;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
	}

	/**
	 * \brief  Setter for the attribute $coursesList.
	 * \param  $newCoursesList Contains the new value of $coursesList.
	*/
	public function setCoursesList($newCoursesList = NULL)
	{
		foreach ($this->coursesList as $oneCourse)
		{
			$this->removeCourse($oneCourse);
		}

		if (is_array($newCoursesList))
		{
			foreach ($newCoursesList as $aCourse)
			{
				$this->addCourse($aCourse);
			}
		}
	}

	/**
	 * \brief  Setter for the attribute $modifList.
	 * \param  $newModifList Contains the new value of $modifList.
	*/
	public function setModifList(Modification $newModifList = NULL)
	{
		foreach ($this->modifList as $oneModif)
		{
			$this->removeModification($oneModif);
		}

		if (is_array($newModifList))
		{
			foreach ($newModifLists as $aModif)
			{
				$this->addModification($aModif);
			}
		}
	}

	// This method shouldn’t be outside this class and its children since the attribute shouldn’t change after loading/creating the object
	/**
	 * \brief  Setter for the attribute $group.
	 * \param  $newGroup Contains the new value of $group.
	*/
	protected function setGroup(Group $newGroup = NULL)
	{
		if ($newGroup instanceof Group)
		{
			if ($this->validated)
			{
				$query = "UPDATE " . Group::TABLENAME . " SET id_validated_calendar = " . $this->sqlId . " WHERE id = " . $newGroup->sqlId() . ";";
			}
			else
			{
				$query = "UPDATE " . Group::TABLENAME . " SET id_current_calendar = " . $this->sqlId . " WHERE id = " . $newGroup->sqlId() . ";";

				if (Database::currentDB()->executeQuery($query))
				{
					$this->group = $newGroup;
				}
				else
				{
					Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}

				$this->setSubject();
				$this->setTeacherOwner();
			}
		}
		else
		{
			if ($this->validated)
			{
				$query = "UPDATE " . Group::TABLENAME . " SET id_validated_calendar = NULL WHERE id = " . $newGroup->sqlId() . ";";
			}
			else
			{
				$query = "UPDATE " . Group::TABLENAME . " SET id_current_calendar = NULL WHERE id = " . $newGroup->sqlId() . ";";

				if (Database::currentDB()->executeQuery($query))
				{
					$this->group = NULL;
				}
				else
				{
					Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}
			}
		}
	}

	// This method shouldn’t be outside this class since the attribute shouldn’t change after loading/creating the object
	/**
	 * \brief  Setter for the attribute $subject.
	 * \param  $newSubject Contains the new value of $subject.
	*/
	private function setSubject(Subject $newSubject = NULL)
	{
		if ($newSubject instanceof Subject)
		{
			$query = "UPDATE " . Subject::TABLENAME . " SET id_calendar = " . $this->sqlId . " WHERE id = " . $newSubject->sqlId() . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->subject = $newSubject;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}

			$this->setGroup();
			$this->setTeacherOwner();
		}
		else
		{
			$query = "UPDATE " . Subject::TABLENAME . " SET id_calendar = NULL WHERE id = " . $newSubject->sqlId() . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->subject = NULL;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
	}

	// This method shouldn’t be outside this class since the attribute shouldn’t change after loading/creating the object
	/**
	 * \brief  Setter for the attribute $teacherOwner.
	 * \param  $newTeacherOwner Contains the new value of $teacherOwner.
	*/
	private function setTeacherOwner(Teacher $newTeacherOwner = NULL)
	{
		if ($newTeacherOwner instanceof Teacher)
		{
			$query = "UPDATE " . self::TABLENAME . " SET id_teacher = " . $newTeacherOwner->getSqlId() . " WHERE id = " . $this->sqlId . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->teacherOwner = $newTeacherOwner;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}

			$this->setSubject();
			$this->setGroup();
		}
		else
		{
			$query = "UPDATE " . self::TABLENAME . " SET id_teacher = NULL WHERE id = " . $this->sqlId . ";";
			if (Database::currentDB()->executeQuery($query))
			{
				$this->teacherOwner = NULL;
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
	}

	// others
	/**
	 * \brief   Extracts exams from courses’ list.
	 * \return  The list of exams.
	*/
	public function extractExams()
	{
		$examList = array();

		foreach ($this->coursesList as $tempCourse)
		{
			if ($tempCourse->getTypeOfCourse() == EXAMEN)
			{
				$examList[] = $tempCourse;
			}
		}

		return $examList;
	}

	/**
	 * \brief  Indicates if the timetable contains the given course.
	 * \param  $aCourse The course to search in the timetable.
	 * \return TRUE if the timetable contains the given course, ELSE otherwise.
	*/
	public function containsCourse(Cours $aCourse)
	{
		foreach ($this->coursesList as $oneCourse)
		{
			if ($oneCourse == $aCourse)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * \brief  Indicates if the timetable has the given modification.
	 * \param  $aModif The modif to search in the timetable.
	 * \return TRUE if the timetable has the given modification, ELSE otherwise.
	*/
	public function hasModification(Modification $aModif)
	{
		foreach ($this->modifList as $oneModif)
		{
			if ($oneModif == $aModif)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * \brief  Adds a course in the list of courses.
	 * \param  $newCourse The course to add.
	*/
	public function addCourse(Course $newCourse) // TODO adapt davical dB en créant des évènements de même nom/horaires et salle pour tous les EDT concernés
	{
		if (!$this->containsCourse($newCourse))
		{
			$query = "INSERT " . Course::belongsToTABLENAME . " (id_course, id_calendar) VALUES(" . $newCourse->getSqlId() . "," . $this->sqlId . ") ;";

			if (Database::currentDB()->executeQuery($query))
			{
				$this->coursesList[] = $newCourse;
				$aSubject            = $newCourse->getSubject();

				// the two next blocs add the new course to all calendars related to this one
				if (!empty($aSubject))
				{
					$aSubject->getTimetable()->addCourse($newCourse); // ADD course to calendar of the course’s subject

					foreach ($aSubject->getTeachedBy() as $oneSpeaker) // for all speakers of this course
					{
						$aTeacher = new Teacher();

						if ($aTeacher->loadFromDB($oneSpeaker->getSqlId())) // we check that $onespeaker is a user
						{
							$aTeacher->getTimetable()->addCourse($newCourse); // ADD course to teacher’s calendar
						}
					}
				}

				if (!empty($this->group)) // ADD course in all linked groups calendars
				{
					$aGroup = $this->group;

					foreach ($aGroup->getListOfLinkedGroups() as $oneGroup)
					{
						$aTimetable = $oneGroup->getTimeTable();

						if (!empty($aTimetable))
						{
							$aTimetable->addCourse($newCourse);
						}
					}
				}
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
	}

	/**
	 * \brief  Removes a course in the list of courses.
	 * \param  $courseToRemove The course to remove.
	*/
	public function removeCourse(Course $courseToRemove)
	{
		$aSubject = $courseToRemove();

		if ($this->containsCourse($courseToRemove))
		{
			$query = "DELETE FROM " . Course::belongsToTABLENAME . " WHERE id_course = " . $courseToRemove->getSqlId() . " AND id_calendar = " . $this->sqlId . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				unset($this->coursesList[array_search($courseToRemove, $this->coursesList)]);

				// The two next blocs remove the course from all calendars related to this one
				if (!empty($aSubject))
				{
					$aSubject->getTimetable()->removeCourse($courseToRemove); // REMOVE course from calendar of the course’s subject

					foreach ($aSubject->getTeachedBy() as $oneSpeaker) // for all speakers of this course
					{
						$aTeacher = new Teacher();

						if ($aTeacher->loadFromDB($oneSpeaker->getSqlId())) // We check that $oneSpeaker is a user
						{
							$aTeacher->getTimetable()->removeCourse($courseToRemove); // REMOVE course from teacher’s calendar
						}
					}
				}

				if (!empty($this->group)) // REMOVE course from all linked groups calendars
				{
					$aGroup = $this->group;

					foreach ($aGroup->getListOfLinkedGroups() as $oneGroup)
					{
						$aTeacher = $oneGroup->getTimeTable();

						if (!empty($aTeacher))
						{
							$aTeacher->removeCourse($courseToRemove);
						}
					}
				}
			}
			else
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
			}
		}
	}

	/**
	 * \brief  Adds a modification in the list of modifications.
	 * \param  $newModification The modification to add.
	*/
	public function addModification(Modification $newModification)
	{
		if (!hasModification($newModification))
		{
			$this->modifList[] = $newModification;
			// No need for a SQL query, the modification should already have been registered in the DB
		}
	}

	// This method shouldn’t be called outside this class because there’s no reason that only one modification of timetable to be removed
	/**
	 * \brief  Removes a modification in the list of modifications.
	 * \param  $modificationToRemove The modification to remove.
	*/
	protected function removeModification(Modification $modificationToRemove)
	{
		if (!hasModification($modificationToRemove))
		{
			$modificationToRemove->removeFromDB();
			unset($this->modifList[array_search($modificationToRemove, $this->modifList)]);
		}
	}

	/**
	 * \brief  Clears all modifications.
	*/
	public function clearModifications()
	{
		foreach ($this->modifList as $oneModif)
		{
			$oneModif->removeFromDB();
		}

		$this->modifList = array();
	}

	/**
	 * \brief  Loads a course from the given ressource.
	 * \param  $ressource The ressource from which a course will be loaded.
	*/
	public function loadCourseFromRessource($ressource)
	{
		$newCourse = new Cours();
		$newCourse->loadFromDB(int_val($ressource['id_course']));
		$this->addCourse($newCourse);
	}

	// This method expects an array describing a ressource from a select query on modification table
	/**
	 * \brief  Loads a modification from the given ressource.
	 * \param  $ressource The ressource from which a modification will be loaded.
	*/
	public function loadModificationFromRessource($ressource)
	{
		$newModification = new Modification();
		$newModification->setDate($ressource['date']);
		$newUser = new Utilisateur();
		$newUser->loadFromDB(int_val($ressource['id_user']));
		$newModification->setModifiedBy($newUser);
		$newCourse = new Cours();
		$newCourse->loadFromDB(int_val($ressource['id_course']));
		$newModification->setCourseModified($newCourse);
		$this->addModification($newModification);
	}

	/**
	 * \brief  Loads data from the database.
	 * \param  $id The SQL id of the timetable to load.
	 * \param  $onlyClassCalendar \e Boolean ???
	 * \return TRUE if data loaded successfully, FALSE otherwise.
	*/
	public function loadFromDB($id = NULL, $onlyClassCalendar = FALSE)
	{
		if ($id == NULL) // if we do not want to load a particular timetable
		{
			if ($this->sqlId != NULL) // check if the current timetable object is defined
			{
				$id = $this->sqlId; // if yes, we want to “reload” data about this object from the database (UPDATE)
			}
		}

		if ($id == NULL) // if no, the first timetable object of the DB, will be chosen to be loaded
		{
			if (!$onlyClassCalendar)
			{
				$query = "SELECT * FROM " . self::TABLENAME . ";";
			}
			else
			{
				$query = "SELECT * FROM " . self::TABLENAME . " WHERE is_class_calendar = TRUE;";
			}

			$result = Database::currentDB()->executeQuery($query);
		}
		else // (if yes) from here, we load data about the timetable that has $id as $sqlId
		{
			if ($onlyClassCalendar) // we load any timetable that matches the criteria
			{
				$query = "SELECT * FROM " . self::TABLENAME . " WHERE id = $1;";
			}
			else // we load only classes timetable that matches the criteria
			{
				$query = "SELECT * FROM " . self::TABLENAME . " WHERE id = $1 AND is_class_calendar = TRUE;";
			}

			$params = array($id);
			$result = Database::currentDB()->executeQuery($query, $params);
		}

		if ($result)
		{
			$ressource = pg_fetch_assoc($result); // ressource is now an array containing values for each SQLcolumn of the timetable table
			$this->loadFromRessource($ressource);

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * \brief Loads all data from the given ressource.
	 * \param $ressource The ressource from which data will be loaded.
	*/
	public function loadFromRessource($ressource)
	{
		// we change values of attributes
		$this->sqlId = $ressource['id'];
		$newUser     = new User();
		$newUser->loadFromDB(int_val($ressource['is_being_modified_by']));
		$this->modifiedBy = $newUser;

		if ($ressource['id_teacher'])
		{
			$newUser = new User();
			$newUser->loadFromDB(int_val($ressource['id_teacher']));
			$this->teacher = $newUser;
		}
		else
		{
			$this->teacher = NULL;
		}

		$params = array($this->sqlId);

		if ($ressource['is_validated_calendar'])
		{
			$this->validated = TRUE;
			$query           = "SELECT id FROM " . Group::TABLENAME . " WHERE id_validated_calendar = $1;";
		}
		else
		{
			$this->validated = FALSE;
			$query           = "SELECT id FROM " . Group::TABLENAME . " WHERE id_current_calendar = $1;";
		}

		if ($result2 = Database::currentDB()->executeQuery($query, $params))
		{
			$result2  = pg_fetch_assoc($result2);
			$newGroup = new Group();
			$newGroup->loadFromDB(int_val($result2['id']));
			$this->group = $newGroup;
		}
		else
		{
			$this->group = NULL;
		}

		$query = "SELECT id FROM " . Subject::TABLENAME . " WHERE id_calendar = $1;";

		if ($result2 = Database::currentDB()->executeQuery($query, $params))
		{
			$result2    = pg_fetch_assoc($result2);
			$newSubject = new Subject();
			$newSubject->loadFromDB(int_val($result2['id']));
			$this->subject = $newSubject;
		}
		else
		{
			$this->subject = NULL;
		}
	}

	/**
	 * \brief Removes the timetable from database.
	*/
	public function removeFromDB()
	{
		$this->setModifList();
		$this->setTeacherOwner();
		$this->setSubject();
		$query = "DELETE * FROM " . self::TABLENAME . " WHERE id = " . $this->sqlId . ";";

		if (Database::currentDB()->executeQuery($query))
		{
		}
		else
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
		}

		$DB = new Database("davical_app", "davical");

		if (!$DB->connect())
		{
			echo ("Pas de connexion vers davical.");
		}
		else
		{
			$query = "DELETE FROM calendar_item WHERE collection_id = " . $this->idCollection . ";";
			$DB->executeQuery($query, $params);
			$query = "DELETE FROM collection WHERE collection_id = " . $this->idCollection . ";";
			$DB->executeQuery($query, $params);
		}
	}

	/**
	 * \brief Shares the timetable with the given user.
	 * \param $aUser The user to share timetable with.
	 * \param $write \e Boolean indicating if the user will have the right to write on the timetable.
	*/
	public function shareWith(User $aUser, $write = FALSE)
	{
		$DB = new Database("agendav");

		if (!$DB->connect())
		{
			echo ("Pas de connexion vers agendav");
		}
		else
		{
			if($this->group)
			{
				$params[] = $this->group->getName();
				$params[] = $this->group->getName() . " EDT";
				$params[] = $aUser->getLogin();
			}
			else if($this->subject)
			{
				$params[] = $this->subject->getGroup()->getName();
				$params[] = $this->subject->getName() . " " . $this->subject->getGroup()->getName();
				$params[] = $aUser->getLogin();
			}
			else if($this->teacherOwner)
			{
				$params[] = $this->teacherOwner->getLogin();
				$params[] = $this->teacherOwner->getFullName() . " EDT";
				$params[] = $aUser->getLogin();
			}

			$query = "SELECT user_from FROM shared WHERE user_from = $1 AND (calendar = $2 AND user_which = $3);";
			$result = $DB->executeQuery($query, $params);

			if (!$result or !pg_fetch_assoc($result))// WEIRD but we can have a ressource as a result even when the table is empty -_-
			{
				$query = "INSERT INTO shareD (user_from, user_which, calendar, options, write_access) VALUES ($1, $3, $2, 'N;', $4);";
				$params[] = (bool)$write;

				if (!$BDD->executeQuery($query,$params))
				{
					$BDD->showError("ligne n°" . __LINE__ . " classe :" . __CLASS__);
				}
				else
				{
				echo("Déjà partagé");
				}
			}
		}
	}

	/**
	 * \brief ???
	*/
	public function autoShare()
	{

		// Shares a group or subject calendar with all secretaries & heads of department (writing privilege)
		if ($this->group or $this->subject)
		{
			$newStatus = new PersonStatus(PersonStatus::HEAD);
			$head = $newStatus->toInt();

			$newStatus = new PersonStatus(PersonStatus::SECRETARY);
			$secretary = $newStatus->toInt();

			$query = "SELECT id_person FROM guser AS G WHERE G.id_person IN (SELECT id_person FROM " . PersonStatus::TABLENAME . " WHERE status = " . $head . " OR status = " . $secretary . ");";
			$result = Database::currentDB()->executeQuery($query);

			if ($result)
			{
				$userId = pg_fetch_assoc($result);

				while ($userId != NULL)
				{
					$newUser = new User();
					$newUser->loadFromDB(intval($userId['id_person']));

					if ($newUser)
					{
						$this->shareWith($newUser, TRUE);
						echo ($newUser->toHTML());
					}

					$userId = pg_fetch_assoc($result);
				}
			}
			else
			{
				Database::currentDB()->showError();
			}
		}

		//Shares a subject calendar with teachers in charge (no writing privilege)
		if ($this->subject)
		{
			for ($i = 1 ; $i <= 3 ; $i++)
			{
				$query  = "SELECT id_person FROM guser AS G WHERE G.id_person IN (SELECT id_speaker" . $i . " FROM " . Subject::TABLENAME . " WHERE id = " . $this->subject->getSqlId() . ");";
				$result = Database::currentDB()->executeQuery($query);

				if ($result)
				{
					$userId = pg_fetch_assoc($result);

					while ($userId != NULL)
					{
						$newUser = new User();
						$newUser->loadFromDB(intval($userId['id_person']));

						if ($newUser)
						{
							$this->shareWith($newUser, FALSE);
						}

						$userId = pg_fetch_assoc($result);
					}
				}
			}
		}
		//Shares a teacher calendar with all secretaries (reading privilege?)
		else if($this->teacherOwner)
		{
			$newStatus = new PersonStatus(PersonStatus::SECRETARY);
			$secretary = $newStatus->toInt();
			$query     = "SELECT id_person FROM guser AS G WHERE G.id_person IN (SELECT id_person FROM " . PersonStatus::TABLENAME . " WHERE status = " . $secretary . ");";
			$result    = Database::currentDB()->executeQuery($query);

			if ($result)
			{
				$userId = pg_fetch_assoc($result);

				while ($userId != NULL)
				{
					$newUser = new User();
					$newUser->loadFromDB(intval($userId['id_person']));

					if ($newUser)
					{
						$this->shareWith($newUser, TRUE);
					}

					$userId = pg_fetch_assoc($result);
				}
			}		
		}
	}

	/**
	 * \brief ???
	*/
	public static function autoShareAllCalendars()
	{
		$query  = "SELECT id FROM " . self::TABLENAME . ";";
		$result = Database::currentDB()->executeQuery($query);

		if ($result)
		{
			$id = pg_fetch_assoc($result);

			while ($id != NULL)
			{
				$newCourse = new Timetable();
				$newCourse->loadFromDB($id['id']);
				$newCourse->autoShare();
				$id = pg_fetch_assoc($result);
			}
		}
	}
}
?>
