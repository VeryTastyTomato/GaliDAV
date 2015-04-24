<?php
/**
 * \file    C_Modification.php
 * \brief   Defines the class Modification.
 * \details Represents a modificaton made in a timetable.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_Course.php');
require_once('C_User.php');

class Modification
{
	// --- ATTRIBUTES ---
	private $date;
	private $madeBy         = NULL;
	private $modifiedCourse = NULL;

	const TABLENAME  = "gmodification";
	const SQLcolumns = "id_course INTEGER REFERENCES gcourse(id), id_user INTEGER REFERENCES guser(id_person), date TIMESTAMP DEFAULT 'now'";

	// --- OPERATIONS ---
	/**
	 * \brief Modification’s constructor
	 * \param $newDate           Contains the modification’s date.
	 * \param $newMadeBy         Contains the author of the modification.
	 * \param $newModifiedCourse Contains the course on which the modifacation is applied.
	*/
	public function __constructor($newDate, $newMadeBy, $newModifiedCourse)
	{
		$this->date           = $newDate;
		$this->madeBy         = $newMadeBy;
		$this->modifiedCourse = $newModifiedCourse;
	}

	// getters
	/**
	 * \brief  Getter for the attribute $date.
	 * \return The value of $date.
	*/
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * \brief  Getter for the attribute $madeBy.
	 * \return The value of $madeBy.
	*/
	public function getMadeBy()
	{
		return $this->madeBy;
	}

	/**
	 * \brief  Getter for the attribute $modifiedCourse.
	 * \return The value of $modifiedCourse.
	*/
	public function getModifiedCourse()
	{
		return $this->modifiedCourse;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $date.
	 * \param  $newDate Contains the new value of $date.
	*/
	public function setDate($newDate)
	{
		if (!empty($newDate))
		{
			$this->date = $newDate;
		}
	}

	/**
	 * \brief  Setter for the attribute $madeBy.
	 * \param  $newMadeBy Contains the new value of $madeBy.
	*/
	public function setMadeBy($newMadeBy)
	{
		if (!empty($newMadeBy))
		{
			$this->madeBy = $newMadeBy;
		}
	}

	/**
	 * \brief  Setter for the attribute $modifiedCourse.
	 * \param  $newModifiedCourse Contains the new value of $modifiedCourse.
	*/
	public function setModifiedCourse($newModifiedCourse)
	{
		if (!empty($newModifiedCourse))
		{
			$this->modifiedCourse = $newModifiedCourse;
		}
	}

	/**
	 * \brief Removes the modification from database.
	*/
	public function removeFromDB()
	{
		// TODO
	}
}
?>
