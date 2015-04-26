<?php
/**
 * \file    C_Head.php
 * \brief   Defines the class Head.
 * \details Represents a head, who is also a teacher.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('types/T_Head.php');
require_once('C_Group.php');
require_once('C_Class.php');
require_once('C_User.php');
require_once('C_Teacher.php');
require_once('C_ElemOfClassesModel.php');

class Head extends Teacher
{
	// --- ATTRIBUTES ---
	private $type = NULL;

	// --- OPERATIONS ---
	/**
	 * \brief Head’s constructor
	 * \param $newFamilyName    \e String containing the family name.
	 * \param $newFirstName     \e String containing the first name.
	 * \param $newId            \e Contains the id.
	 * \param $newPassword      \e String containing the password.
	*/
	public function __construct($newFamilyName, $newFirstName, $newId, $newPassword)
	{
		parent::__construct($newFamilyName, $newFirstName, $newId, $newPassword);
		$this->addStatus(new PersonStatus(PersonStatus::HEAD));
		//$this->addStatus(new PersonStatus(PersonStatus::TEACHER));
	}

	/**
	 * \brief   Modify a timetable.
	 * \details It can add or remove a course.
	 * \param   $aTimetable The timetable which will be modified.
	 * \param   $aCourse    The course that will be added or removed.
	 * \param   $operation  \e String containing the type of modification.
	*/
	public function modifyTimetable(Timetable $aTimetable, Course $aCourse, $operation)
	{
		if ($operation == 'add')
		{
			$aTimetable->addCourse($aCourse);
		}
		else if ($operation == 'remove')
		{
			$aTimetable->removeCourse($aCourse);
		}
		else
		{
			echo 'Opération invalide';
		}
	}

	/**
	 * \brief  Add a new group.
	 * \param  $name \e String containing the name of the group.
	 * \return The newly created group.
	*/
	public function addGroup($name)
	{
		new Group($name, FALSE);
	}

	/**
	 * \brief   Modify a group’s members.
	 * \details It can add or remove a student.
	 * \param   $aGroup    The group which will be modified.
	 * \param   $aStudent  The student that will be added or removed.
	 * \param   $operation \e String containing the type of modification.
	*/
	public function modifyGroupMembers(Group $aGroup, Person $aStudent, $operation)
	{
		if ($operation == 'add')
		{
			$aGroup->addStudent($aStudent);
		}
		else if ($operation == 'remove')
		{
			$aGroup->removeStudent($aStudent);
		}
		else
		{
			echo 'Opération invalide';
		}
	}

	/**
	 * \brief   Modify a group’s linked classes members.
	 * \details It can add or remove a student.
	 * \param   $aClass    The class which will be modified.
	 * \param   $aStudent  The student that will be added or removed.
	 * \param   $operation \e String containing the type of modification.
	*/
	public function modifyGroupLinkedClasses(C_Class $aClass, Person $aStudent, $operation)
	{
		if ($operation == 'add')
		{
			$aClass->addStudent($aStudent);
		}
		else if ($operation == 'remove')
		{
			$aClass->removeStudent($aStudent);
		}
		else
		{
			echo 'Opération invalide';
		}
	}

	/**
	 * \brief Compares the given timetables.
	 * \param $timetablesList The list of timetables to compare.
	 * \param $begin ???
	 * \param $end   ???
	*/
	public function compareTimetable($timetablesList, $begin, $end)
	{
		$returnValue = NULL;

		return $returnValue;
	}

	/**
	 * \brief Validates the given timetable.
	 * \param $aTimetable The timetable to validate.
	*/
	public function validateTimetable(Timetable $aTimetable)
	{
		$aTimetable->emptyModifications();
	}

	/**
	 * \brief   Modify a class’ courses model.
	 * \details It can add or remove an element of classes model.
	 * \param   $aClass    The class which will be modified.
	 * \param   $anElem    The element of classes model that will be added or removed.
	 * \param   $operation \e String containing the type of modification.
	*/
	public function modifyClassCoursesModel(C_Class $aClass, ClassesModel $anElem, $operation)
	{
		if ($operation == 'add')
		{
			$aClass->getCoursesModel->addElemOfClassesModel($anElem);
		}
		else if ($operation == 'remove')
		{
			$aClass->getCoursesModel->removeElemOfClassesModel($anElem);
		}
		else
		{
			echo 'Opération invalide';
		}
	}
}
?>
