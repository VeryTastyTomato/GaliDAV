<?php
/**
 * \file    C_Teacher.php
 * \brief   Defines the class Teacher.
 * \details Represents a teacher, who is a type of user.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_User.php');
require_once('C_Timetable.php');

class Teacher extends User
{
	// --- ATTRIBUTES ---
	private $personalTimetable = NULL;

	// --- OPERATIONS ---
	/**
	 * \brief Teacher’s constructor
	 * \param $newFamilyName    \e String containing the family name.
	 * \param $newFirstName     \e String containing the first name.
	 * \param $newLogin         \e String containing the login.
	 * \param $newPassword      \e String containing the password.
	 * \param $newEmailAddress1 \e String containing the email address 1.
	*/
	public function __construct($newFamilyName = NULL, $newFirstName = NULL, $newLogin = NULL, $newPassword = NULL, $newEmailAddress1 = NULL)
	{
		parent::__construct($newFamilyName, $newFirstName, $newLogin, $newPassword);

		if ($newLogin != NULL and $newPassword != NULL)
		{
			$this->addStatus(new PersonStatus(PersonStatus::TEACHER));
			$this->personalTimetable = new Timetable($this);
		}
	}

	// getters
	/**
	 * \brief  Getter for the attribute $personalTimetable.
	 * \return The value of $personalTimetable.
	*/
	public function getPersonalTimetable()
	{
		return $this->personalTimetable;
	}

	// others
	/**
	 * \brief  Reads the teacher’s timetable.
	 * \return TRUE if successful, FALSE otherwise.
	*/
	public function readPersonalTimetable()
	{
		return parent::readTimetable($this->personalTimetable);
	}
}
?>
