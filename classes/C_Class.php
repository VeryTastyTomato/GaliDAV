<?php
/**
 * \file    C_Class.php
 * \brief   Defines the class C_Class.
 * \details Represents a class, which inherits from a group.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_Timetable.php');
require_once('C_Group.php');
require_once('C_ClassesModel.php');
require_once('C_Person.php');
require_once('C_Head.php');

class C_Class extends Group
{
	// --- ATTRIBUTES ---
	private $coursesModel;

	// --- OPERATIONS ---
	/**
	 * \brief C_Class’s constructor
	 * \param $newName The name of the class.
	*/
	public function __construct($newName)
	{
		parent::__construct($newName, TRUE);
	}

	// getters
	/**
	 * \brief  Getter for the attribute $coursesModel.
	 * \return The value of $coursesModel.
	*/
	public function getCoursesModel()
	{
		return $this->coursesModel;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $coursesModel.
	 * \param  $newCoursesModel Contains the new value of $coursesModel.
	*/
	public function setCoursesModel($newCoursesModel)
	{
		$this->coursesModel = $newCoursesModel;
	}

	// others
	/**
	 * \brief Gets the timetable linked with class.
	*/
	public function getTimetableOfClass()
	{
		$returnValue = NULL;

		return $returnValue;
	}

	/**
	 * \brief  Loads data from the database.
	 * \param  $id The SQL id on the database.
	 * \param  $canBeClass \e Boolean indicating if the group is a class. Here it is always set at TRUE.
	*/
	public function loadFromDB ($id = NULL, $canBeClass = TRUE)
	{
		parent::loadFromDB($id);
		// TODO -load CourseModel
		// -implement loadFromDB in Maquette
	}
}
?>
