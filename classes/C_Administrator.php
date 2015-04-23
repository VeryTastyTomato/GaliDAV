<?php
/**
 * \file    C_Administrator.php
 * \brief   Defines the class Administrator which inherits the class Head.
 * \details An administrator can add or remove users and groups. He can also change a user’s status.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_User.php');
require_once('C_Head.php');

class Administrator extends Head
{
	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	/**
	 * \brief   Administrator’s constructor.
	 * \details The parameters are the same as the ones for a user.
	 * \param   $newFamilyName    \e String containing the family name.
	 * \param   $newFirstName     \e String containing the first name.
	 * \param   $newLogin         \e String containing the login.
	 * \param   $newPassword      \e String containing the password.
	 * \param   $newEmailAddress1 \e String containing the email address 1.
	 * \param   $newEmailAddress2 \e String containing the email address 2.
	*/
	public function __construct($newFamilyName, $newFirstName, $newLogin, $newPassword, $newEmailAddress1 = NULL, $newEmailAddress2 = NULL)
	{
		parent::__construct($newFamilyName, $newFirstName, $newLogin, $newPassword, $newEmailAddress1, $newEmailAddress2);

		$this->addStatus(new PersonStatus(PersonStatus::ADMINISTRATOR));
		// $this->addStatus(new PersonStatus(PersonStatus::HEAD));
		// $this->addStatus(new PersonStatus(PersonStatus::TEACHER));
		/*
		$db = new Database("davical_app", "davical");
		$params[] = privilege_to_bits(array('all'));
		$params[] = $login;
		$query = "UPDATE dav_principal SET default_privileges = $1 WHERE username = $2;";
		$result = $db->executeQuery($query, $params);
		$db->close();

		if (!$result)
		{
			echo("GaliDAV error: write access error on davical database");
		}
		*/
	}

	// others
	/**
	 * \brief  Adds a user.
	 * \param  $newFamilyName    \e String containing the family name.
	 * \param  $newFirstName     \e String containing the first name.
	 * \param  $newLogin         \e String containing the login.
	 * \param  $newPassword      \e String containing the password.
	 * \param  $newEmailAddress1 \e String containing the email address 1.
	 * \return An instance of User initialized with the given parameters.
	*/
	public function addUser($newFamilyName, $newFirstName, $newLogin, $newPassword, $newEmailAddress1 = NULL)
	{
		return new User($newFamilyName, $newFirstName, $newLogin, $newPassword, $newEmailAddress1);
	}

	/*
	public function convertPersonToUser(Person $aPerson)
	{
	return User::convertPersonToUser($aPerson);
	}
	*/

	/**
	 * \brief Adds a user using the CAS database.
	*/
	public function addCASUser($unknownData)
	{
		$returnValue = NULL;

		return $returnValue;
	}

	/**
	 * \brief   Changes a user’s status.
	 * \details It can add or remove a status for the given user.
	 * \param   $aUser     The user whose status will be modified.
	 * \param   $aStatus   The status concerned by the change.
	 * \param   $operation \e String containing the type of change.
	*/
	public function changeUserStatus(User $aUser, PersonStatus $aStatus, $operation)
	{
		if ('add' == $operation)
		{
			$aUser->addStatus($aStatus);
		}
		else if ('remove' == $operation)
		{
			$aUser->removeStatus($aStatus);
		}
	}

	/**
	 * \brief   Deletes a user.
	 * \details Preserves the person and the references of the user.
	 * \param   $aUser The user to delete.
	 * \return  A User object containing an instance of Person.
	*/
	public function deleteUser(User $aUser)
	{
		// first, the user is removed from dav_principal of davical and guser of galidav
		$params[] = $aUser->login;
		$query    = "REMOVE FROM dav_principal WHERE username = $1;";
		$oneDatabase->executeQuery($query, $params);
		$oneDatabase->close();
		$query = "DELETE FROM " . User::TABLENAME . " WHERE login = $1;";
		Database::currentDB()->executeQuery($query, $params);

		// Flora: TODO Manage the status: a person who cannot access the database can’t be an admin/secretary/head. What about teacher?

		// Then, the object is replaced by a similar object, instance of the class Person rather than User
		$aPerson = new Person($aUser->getFamilyName(), $aUser->getFirstName());
		$aPerson->setEmailAddress1($aUser->getEmailAddress1());
		$aPerson->setEmailAddress2($aUser->getEmailAddress2());
		$aUser = $aPerson;

		return $aUser;
	}

	/**
	 * \brief   Deletes a person.
	 * \details Deletes completely a person, i.e. the object and the data in the database.
	 * \param   $aPerson The person to delete completely.
	*/
	public function deletePerson(Person $aPerson)
	{
		$aPerson->removeFromDB();
		$aPerson->__destroy();
		$aPerson = NULL;
		// Flora TODO: Tester et voir s'il n'y a pas plus approprié
	}

	/**
	 * \brief  Adds a class.
	 * \param  $name \e String containing the name of the class.
	 * \return The added class.
	*/
	public function addClass($name)
	{
		return new C_Class($name);
	}

	/**
	 * \brief   Modify a class.
	 * \details It can add or remove a student.
	 * \param   $aClass    The class which will be modified.
	 * \param   $aStudent  The student that will be added or removed.
	 * \param   $operation \e String containing the type of modification.
	*/
	public function modifyClass(C_Class $aClass, Person $aStudent, $operation)
	{
		if ('add' == $operation)
		{
			$aClass->addStudent($aStudent);
		}
		else if ('remove' == $operation)
		{
			$aClass->removeStudent($aStudent);
		}
		else
		{
			echo 'Erreur dans la méthode modifyClass() de la classe Administrateur : opération invalide.';
		}
	}
}
?>
