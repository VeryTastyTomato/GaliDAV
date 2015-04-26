<?php
/**
 * \file    C_ClassesTimetable.php
 * \brief   Defines the class ClassesTimetable.
 * \details Represents a class’ timetable.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_Timetable.php');

class ClassesTimetable extends Timetable
{
	// --- OPERATIONS ---
	/**
	 * \brief ClassesTimetable’s constructor
	 * \param $aClass    The timetable’s class.
	 * \param $validated \e Boolean indicating if the class’ timetable is validated or not.
	*/
	public function __construct(C_Class $aClass = NULL, $validated = FALSE)
	{
		parent::__construct($aClass, $validated);
	}

	// getters
	/**
	 * \brief  Getter for the attribute $group.
	 * \return The value of $group.
	*/
	public function getClass()
	{
		return parent::getGroup();
	}

	// setters
	/**
	 * \brief  Setter for the attribute $group.
	 * \param  $newClass Contains the new value of $group.
	*/
	protected function setClass(C_Class $newClass = NULL)
	{
		parent::setGroup($newClass);
	}

	// others
	/**
	 * \brief Generates a PDF of the class’ timetable.
	*/
	public function generatePDF()
	{
		// TODO
	}
}
?>
