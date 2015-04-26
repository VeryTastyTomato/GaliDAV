<?php
/**
 * \file    C_User.php
 * \brief   Defines the class User.
 * \details A user is a person who can use the application.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_Person.php');
require_once('C_Timetable.php');
require_once('C_Database.php');
require_once('test_davical_operations.php');
require_once('AWLUtilities.php');

class User extends Person
{
	// --- ATTRIBUTES ---
	protected $login = NULL;
	protected $password = NULL;

	const TABLENAME = "guser";
	const SQLcolumns = "id_person serial PRIMARY KEY REFERENCES gperson(id), login VARCHAR(30) UNIQUE NOT NULL, id_principal INTEGER UNIQUE, password VARCHAR, last_connection TIMESTAMP";

	// --- OPERATIONS ---
	/**
	 * \brief User’s constructor
	 * \param $newFamilyName    \e String containing the family name.
	 * \param $newFirstName     \e String containing the first name.
	 * \param $newLogin         \e String containing the login.
	 * \param $newPassword      \e String containing the password.
	 * \param $newEmailAddress1 \e String containing the email address 1.
	 * \param $newEmailAddress2 \e String containing the email address 2.
	*/
	public function __construct($newFamilyName = NULL, $newFirstName = NULL, $newLogin = NULL, $newPassword = NULL, $newEmailAddress1 = NULL, $newEmailAddress2 = NULL)
	{
		parent::__construct($newFamilyName, $newFirstName, $newEmailAddress1);

		if ($newLogin != NULL and $newPassword != NULL)
		{
			$this->login    = $newLogin;
			$this->password = $newPassword;
			$hashPassword   = session_salted_sha1($newPassword); // The password has to be crypted in order to save it.
			$fullName       = $newFamilyName . " " . $newFirstName;
			CreateUserAccount($newLogin, $fullName, $hashPassword, $newEmailAddress1);
			$params2[] = $this->sqlId;
			$params2[] = $newLogin;
			$query     = "INSERT INTO " . self::TABLENAME . " (id_person, login) VALUES ($1, $2);";
			$result    = Database::currentDB()->executeQuery($query, $params2);

			if (!$result)
			{
				echo ("GaliDAV: Impossible de créer cet utilisateur dans la base");
			}

			$this->setPassword($newPassword);
		}
	}

	// getters
	/**
	 * \brief  Getter for the attribute $login.
	 * \return The string value of $login.
	*/
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * \brief  Getter for the attribute $password.
	 * \return The string value of $password.
	*/
	public function getPassword()
	{
		return $this->password;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $password.
	 * \param  $newPassword Contains the new value of $password.
	*/
	protected function setPassword($newPassword)
	{
		$params[] = session_salted_sha1($newPassword);
		$params[] = $this->login;

		$query    = "UPDATE " . self::TABLENAME . " SET password = $1 WHERE login = $2;";

		if (!Database::currentDB()->executeQuery($query, $params))
		{
			Database::currentDB()->showError();
		}
		else
		{
			$this->password = $newPassword;
		}
	}

	// static functions
	// Flora NOTE: La fonction ci-dessous peut ne pas être utile finalement
	/**
	 * \brief  Converts the given person to a user.
	 * \param  $aPerson   The person that will be converted to a user.
	 * \param  $aLogin    The login which will be attributed to the given person.
	 * \param  $aPassword The password of the given person.
	 * \return The user created.
	*/
	static public function convertPersonToUser(Personne $aPerson, $aLogin, $aPassword)
	{
		$query = "DELETE FROM " . PersonStatus::TABLENAME . " WHERE id_person = " . $aPerson->sqlId . ";";
		Database::currentDB()->executeQuery($query);
		$query = "DELETE FROM " . parent::TABLENAME . " WHERE id = " . $aPerson->sqlId . ";";
		Database::currentDB()->executeQuery($query);
		$newUser = new User($aPerson->familyName, $aPerson->firstName, $aLogin, $aPassword);
		$newUser->setEmailAddress1($aPerson->getEmailAddress1());
		$newUser->setEmailAddress2($aPerson->getEmailAddress2());
		$newUser->setAllStatus($aPerson->getAllStatus());
		$aPerson = $newUser;

		return $newUser;
	}

	// others
	/**
	 * \brief  Checks if the given password matches the user’s one.
	 * \param  $givenPassword The password to check.
	 * \return TRUE if the passwords are the same, FALSE otherwise.
	*/
	public function isPassword($givenPassword)
	{
		return $givenPassword == $this->password;
	}

	public function logIn()
	{
	}

	public function logOut()
	{
	}

	/**
	 * \brief  Loads data from database.
	 * \param  $loginOrId ???
	 * \param  $notUseful ???
	 * \result TRUE if data loaded successfully, FALSE otherwise.
	*/
	public function loadFromDB($loginOrId = NULL, $notUseful = NULL)
	{
		if ($loginOrId == NULL)
		{
			if ($this->login != NULL)
			{
				$login = $this->login;
			}
		}

		if (!is_string($loginOrId) and !is_int($loginOrId)) // si le login ou l'id passé en paramètre est NULL et que l'objet est indéfini
		{
			$query  = "SELECT * FROM " . self::TABLENAME . ";";
			$result = Database::currentDB()->executeQuery($query);
		}
		else
		{
			if (is_string($loginOrId)) // If it is a login
			{
				$query    = "SELECT * FROM " . self::TABLENAME . " WHERE login = $1;";
				$params[] = $loginOrId;
				$result   = Database::currentDB()->executeQuery($query, $params);
			}
			else // else, it is an id
			{
				$query  = "SELECT * FROM " . self::TABLENAME . " WHERE id_person = " . $loginOrId . ";";
				$result = Database::currentDB()->executeQuery($query);
			}
		}

		if ($result)
		{
			$result = pg_fetch_assoc($result);
		}
		else
		{
			return FALSE; // we did not find a matching $result in the database
		}

		$this->sqlId    = $result['id_person'];
		$this->login    = $result['login'];
		$this->password = $result['password']; // Has to be fixed

		return parent::loadFromDB();
	}

	/**
	 * \brief  Removes the user from database.
	*/
	public function removeFromDB()
	{
		parent::removeFromDB();
	}

	/**
	 * \brief  Reads the given timetable.
	 * \param  $aTimetable The timetable to read.
	 * \return TRUE if successful, FALSE otherwise.
	*/
	public function readTimetable(Timetable $aTimetable)
	{
		$returnValue = FALSE;
		// Flora NOTE: Si c’est un RESP, ADMIN, SECRETAIRE OK. Si c'est un enseignant, vérifier que c'est le bon edt.
		// TODO Complete

		if (($this->hasStatus(4)) or (($this->hasStatus(5)) or ($this->hasStatus(6)))) // secretary, head or admin
		{
			$returnValue = TRUE;
		}
		else if ($this->hasStatus(3)) // teacher
		{
			if ($this->getPersonalTimetable() == $aTimetable) // it’s the correct timetable
			{
				$returnValue = TRUE;
			}
			else
			{
				echo ('Cet EDT ne vous appartient pas.');
			}
		}
		else
		{
			echo ('Vous ne pouvez pas accéder à cet EDT.');
		}

		return $returnValue;
	}

	/**
	 * \brief  Converts data about the user in HTML format.
	 * \return \e String containing data about the user.
	*/
	public function toHTML()
	{
		$result = "<b>ID: &emsp;&emsp;" . $this->login . "</b><br/>";
		$result = $result . parent::toHTML();

		return $result;
	}
}
?>
