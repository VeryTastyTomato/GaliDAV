<?php
/**
 * \file    C_Person.php
 * \brief   Defines the class Person.
 * \details Represents a person, who is not necessarily a user.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_PersonStatus.php');
require_once('C_Database.php');
require_once("test_davical_operations.php");

// Les opérations sur une Personne sont automatiquement reportées dans la BDD.

class Person
{
	// --- ATTRIBUTES ---
	protected $status        = array();
	protected $sqlId         = NULL;
	protected $familyName    = NULL;
	protected $firstName     = NULL;
	protected $emailAddress1 = NULL;
	protected $emailAddress2 = NULL;

	const TABLENAME  = "gperson";
	const SQLcolumns = "id serial PRIMARY KEY, familyname VARCHAR(30) NOT NULL, firstname VARCHAR(30) NOT NULL, emailaddress1 VARCHAR(60), emailaddress2 VARCHAR(60), date_creation TIMESTAMP DEFAULT 'now'";

	// --- OPERATIONS ---
	/**
	 * \brief Person’s constructor
	 * \param $newFamilyName    \e String containing the familiy name.
	 * \param $newFirstName    \e String containing the first name.
	 * \param $newEmailAddress1 \e String containing the email address 1.
	 * \param $newEmailAddress2 \e String containing the email address 2.
	*/
	public function __construct($newFamilyName = NULL, $newFirstName = NULL, $newEmailAddress1 = NULL, $newEmailAddress2 = NULL)
	{
		if ($newFamilyName != NULL and $newFirstName != NULL)
		{
			$this->familyName = $newFamilyName;
			$this->firstName  = $newFirstName;
			$params           = array();
			$params[]         = $newFamilyName;
			$params[]         = $newFirstName;
			$params[]         = "'now'";
			$query            = "";

			if ($newEmailAddress1 == NULL)
			{
				$query = "INSERT INTO " . self::TABLENAME . " (familyName, firstName, date_creation) VALUES ($1, $2, $3);";
			}
			else
			{
				$this->emailAddress1 = $newEmailAddress1;
				$params[]            = $newEmailAddress1;
				$query               = "INSERT INTO " . self::TABLENAME . " (familyName, firstName, date_creation, emailAddress1) VALUES ($1, $2, $3, $4);";
			}

			$result = Database::currentDB()->executeQuery($query, $params);

			if (!$result)
			{
				Database::currentDB()->showError("ligne n° " . __LINE__ . " //fonction : " . __CLASS__);
			}
			else
			{
				$query       = "SELECT id FROM " . self::TABLENAME . " ORDER BY date_creation DESC; ";
				$result      = Database::currentDB()->executeQuery($query);
				$tmp         = pg_fetch_assoc($result);
				$this->sqlid = $tmp['id'];
			}
		}
	}

	// getters
	/**
	 * \brief  Getter for the attribute $status.
	 * \return The array $status containing all status of the person.
	*/
	public function getAllStatus()
	{
		return $this->status;
	}

	/**
	 * \brief  Getter for the attribute $sqlId.
	 * \return The integer value of $sqlId.
	*/
	public function getSqlId()
	{
		return $this->sqlid;
	}

	/**
	 * \brief  Getter for the attribute $familyName.
	 * \return The string value of $familyName.
	*/
	public function getFamilyName()
	{
		return $this->familyName;
	}

	/**
	 * \brief  Getter for the attribute $firstName.
	 * \return The string value of $firstName.
	*/
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * \brief  Getter for the attribute $emailAddress1.
	 * \return The string value of $emailAddress1.
	*/
	public function getEmailAddress1()
	{
		return $this->emailAddress1;
	}

	/**
	 * \brief  Getter for the attribute $emailAddress2.
	 * \return The string value of $emailAddress2.
	*/
	public function getEmailAddress2()
	{
		return $this->emailAddress2;
	}

	// setters
	// Flora: this method is declared protected because the id of a person shouldn’t change in time (given by SQL)
	/**
	 * \brief Setter for the attribute $sqlId.
	 * \param $newSqlId Contains the new value of $sqlId.
	*/
	protected function setSqlid($newSqlId)
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
				Database::currentDB()->showError();
			}
		}
	}

	/**
	 * \brief Setter for the attribute $familyName.
	 * \param $newFamilyName Contains the new value of $familyName.
	*/
	public function setFamilyName($newFamilyName)
	{
		if (is_string($newFamilyName))
		{
			$query    = "UPDATE " . self::TABLENAME . " SET familyName = $1 WHERE id = " . $this->sqlId . ";";
			$params[] = $newFamilyName;
			$result   = Database::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->familyName = $newFamilyName;
			}
			else
			{
				Database::currentDB()->showError("ligne n° " . __LINE__ . " //fonction : " . __CLASS__);
			}
		}
	}

	/**
	 * \brief Setter for the attribute $firstName.
	 * \param $newFirstName Contains the new value of $firstName.
	*/
	public function setFirstName($newFirstName)
	{
		if (is_string($newFirstName))
		{
			$query    = "UPDATE " . self::TABLENAME . " SET firstName = $1 WHERE id = " . $this->sqlId . ";";
			$params[] = $newFirstName;
			$result   = Database::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->firstName = $newFirstName;
			}
		}
	}

	/**
	 * \brief Setter for the attribute $emailAddress1.
	 * \param $newEmailAddress1 Contains the new value of $emailAddress1.
	*/
	public function setEmailAddress1($newEmailAddress1)
	{
		if (is_string($newEmailAddress1))
		{
			if (filter_var($newEmailAddress1, FILTER_VALIDATE_EMAIL))
			{
				$query    = "UPDATE " . self::TABLENAME . " SET emailaddress1 = $1 WHERE id = " . $this->sqlId . ";";
				$params[] = $newEmailAddress1;
				$result   = Database::currentDB()->executeQuery($query, $params);

				if ($result)
				{
					$this->emailAddress1 = $newEmailAddress1;
				}
			}
			else
			{
				echo 'Invalid address';
			}
		}
	}

	/**
	 * \brief Setter for the attribute $emailAddress2.
	 * \param $newEmailAddress2 Contains the new value of $emailAddress2.
	*/
	public function setEmailAddress2($newEmailAddress2)
	{
		if (is_string($newEmailAddress2))
		{
			if (filter_var($newEmailAddress2, FILTER_VALIDATE_EMAIL))
			{
				$query    = "UPDATE " . self::TABLENAME . " SET emailaddress2 = $1 WHERE id = " . $this->sqlId . ";";
				$params[] = $newEmailAddress2;
				$result   = Database::currentDB()->executeQuery($query, $params);

				if ($result)
				{
					$this->emailAddress2 = $newEmailAddress2;
				}
			}
			else
			{
				echo 'Invalid address';
			}
		}
	}

	/**
	 * \brief Setter for the attribute $status.
	 * \param $arrayOfStatus Contains the new value of $status.
	*/
	public function setAllStatus($arrayOfStatus)
	{
		foreach ($this->status as $oneStatus)
		{
			$this->removeStatus($oneStatus);
		}

		foreach ($arrayOfStatus as $oneStatusbis)
		{
			$this->addStatus($oneStatusbis);
		}

		$this->status = $arrayOfStatus;
	}

	// others
	/**
	 * \brief  Concatenates the family name and the first name.
	 * \return \e String resulting from the concatenation.
	*/
	public function getFullName()
	{
		return $this->familyName . " " . $this->firstName;
	}

	/**
	 * \brief Adds a status.
	 * \param $newStatus The status to add.
	*/
	public function addStatus(PersonStatus $newStatus)
	{
		if (!$this->hasStatus($newStatus))
		{
			$params[] = $this->sqlId;
			$params[] = $newStatus->toInt();
			$query    = "INSERT INTO " . PersonStatus::TABLENAME . " (id_person, status) VALUES ($1, $2);";
			$result   = Database::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->status[] = $newStatus;
			}
			else
			{
				Databases::currentDB()->showError("ligne n° " . __LINE__ . " //fonction : " . __CLASS__);
			}
		}
	}

	/**
	 * \brief Removes a status.
	 * \param $statusToRemove The status to remove.
	*/
	public function removeStatus(PersonStatus $statusToRemove)
	{
		if ($this->hasStatus($statusToRemove))
		{
			$query = "DELETE FROM " . PersonStatus::TABLENAME . " WHERE id_person = " . $this->sqlId . " AND status = " . $statusToRemove->toInt() . ";";

			if (Database::currentDB()->executeQuery($query))
			{
				$index = 0;

				foreach ($this->status as $oneStatus)
				{
					if ($oneStatus == $statusToRemove)
					{
						unset($this->status[$index]);
						break;
					}
					$index = $index + 1;
				}
			}
			else
			{
				Database::currentDB()->showError("ligne n° " . __LINE__ . " //fonction : " . __CLASS__);
			}
		}
	}

	/**
	 * \brief  Checks if the person has the given status.
	 * \param  $aStatus The status that has to been searched in the person’s status.
	 * \return TRUE if the person has the given status, FALSE otherwise.
	*/
	public function hasStatus(PersonStatus $aStatus)
	{
		if (is_array($this->status))
		{
			foreach ($this->status as $oneStatus)
			{
				if ($oneStatus == $aStatus)
				{
					return TRUE;
				}
			}
		}
		else // ???
		{
			$this->status = array();
		}

		return FALSE;
	}

	/**
	 * \brief  Loads data from the database.
	 * \param  $id The SQL id of the database.
	 * \param  $canBeUser \e Boolean ???
	 * \return TRUE if data loaded successfully, FALSE otherwise.
	*/
	public function loadFromDB($id = NULL, $canBeUser = TRUE)
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
			if ($canBeUser)
			{
				$query = "SELECT * FROM " . Person::TABLENAME . ";";
			}
			else
			{
				$query = "SELECT * FROM " . Person::TABLENAME . " WHERE id NOT IN (SELECT id_person FROM " . User::TABLENAME . ");";
			}

			$result = Database::currentDB()->executeQuery($query);
		}
		else
		{
			if ($canBeUser)
			{
				$query = "SELECT * FROM " . Person::TABLENAME . " WHERE id = $1;";
			}
			else
			{
				$query = "SELECT * FROM " . Person::TABLENAME . " WHERE id = $1 AND NOT EXISTS (SELECT * FROM " . User::TABLENAME . " WHERE id_person = $1);";
			}

			$params = array($id);
			$result = Database::currentDB()->executeQuery($query, $params);
		}

		if ($result)
		{
			$result = pg_fetch_assoc($result);
			$this->loadFromRessource($result);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * \brief Loads all data from the given ressource (???).
	 * \param $ressource The ressource from which data will be loaded.
	*/
	public function loadFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$this->sqlId         = $ressource['id'];
			$this->familyName    = $ressource['familyname'];
			$this->firstName     = $ressource['firstname'];
			$this->emailAddress1 = $ressource['emailaddress1'];
			$this->emailAddress2 = $ressource['emailaddress2'];
		}

		$this->status = NULL;
		$query        = "SELECT * FROM " . PersonStatus::TABLENAME . " WHERE id_person = " . $this->sqlId . ";";
		$result       = Database::currentDB()->executeQuery($query);
		$ressource    = pg_fetch_assoc($result);

		while ($ressource)
		{
			$this->loadStatusFromRessource($ressource);
			$ressource = pg_fetch_assoc($result);
		}
	}

	/**
	 * \brief Loads status data from the given ressource.
	 * \param $ressource The ressource from which status data will be loaded.
	*/
	public function loadStatusFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$this->addStatus(new PersonStatus(intval($ressource['status'])));
		}
	}

	/**
	 * \brief Removes the person from database.
	*/
	public function removeFromDB()
	{
		$params    = array($this->sqlId);
		$query     = "SELECT * FROM " . User::TABLENAME . " WHERE id_person = $1;";
		$ressource = Database::currentDB()->executeQuery($query, $params);
		$query     = "UPDATE " . Subject::TABLENAME . " SET id_speaker1 = NULL WHERE id_speaker1 = $1";

		if (!Database::currentDB()->executeQuery($query, $params))
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
		}

		$query = "UPDATE " . Subject::TABLENAME . " SET id_speaker2 = NULL WHERE id_speaker2 = $1";

		if (!Database::currentDB()->executeQuery($query, $params))
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
		}

		$query = "UPDATE " . Subject::TABLENAME . " SET id_speaker3 = NULL WHERE id_speaker3 = $1";

		if (!Database::currentDB()->executeQuery($query, $params))
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
		}

		if ($ressource)
		{
			$result = pg_fetch_assoc($ressource);
			$query  = "DELETE FROM " . Timetable::TABLENAME . " WHERE id_teacher = $1;";

			if (!Database::currentDB()->executeQuery($query, $params))
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
			}

			$query = "DELETE FROM " . User::TABLENAME . " WHERE id_person = $1;";

			if (!Database::currentDB()->executeQuery($query, $params))
			{
				Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
			}

			$DB = new Database("davical_app", "davical");

			if (!$DB->connect())
			{
				echo ("Pas de connexion vers davical");
			}
			else
			{
				$userNo = getDAVPrincipalNoFromLogin($result['login']);
				$query  = "DELETE FROM calendar_item WHERE user_no = $userNo;";

				if (!$DB->executeQuery($query))
				{
					$DB->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
				}

				$query = "DELETE FROM collection WHERE user_no = $userNo;";

				if (!$DB->executeQuery($query))
				{
					$DB->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
				}

				$query = "DELETE FROM dav_principal WHERE user_no = $userNo;";

				if (!$DB->executeQuery($query))
				{
					$DB->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
				}

				$DB->close();
			}
		}

		$query = "DELETE FROM " . PersonStatus::TABLENAME . " WHERE id_person = $1;";

		if (!Database::currentDB()->executeQuery($query, $params))
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" .__CLASS__);
		}

		$query = "DELETE FROM " . Person::TABLENAME . " WHERE id = $1;";

		if (!Database::currentDB()->executeQuery($query, $params))
		{
			Database::currentDB()->showError("ligne n°" . __LINE__ . " class :" . __CLASS__);
		}
	}

	/**
	 * \brief  Converts data about the person in HTML format.
	 * \return \e String containing data about the person.
	*/
	public function toHTML()
	{
		$result = "<p>Nom:&emsp;&emsp; " . $this->familyName . "<br/>Prenom:&emsp; &emsp; " . $this->firstName . "</p>";

		if ($this->getEmailAddress1() != NULL)
		{
			$result = $result . "<p>Adresse mail 1 :&emsp; <i>" . $this->emailAddress1 . "</i>";

			if ($this->getEmailAddress2())
			{
				$result = $result . "<br/>Adresse mail 2 :&emsp; <i>" . $this->emailAddress2 . "</i>";
			}

			$result = $result . "</p>";
		}

		if ($this->status != NULL)
		{
			$result = $result . "<p>Statuts:&emsp; ";

			foreach ($this->status as $s)
			{
				$result = $result . "- " . $s->toString() . " ";
			}

			$result = $result . "</p>";
		}

		return $result;
	}
}
?>
