<?php
/**
 * \file    C_ElemOfClassesModel.php
 * \brief   Defines the class ElemOfClassesModel.
 * \details Represents an element of a class’ model.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('types/T_Courses.php');
require_once('C_ClassesModel.php');
require_once('C_Subject.php');

class ElemOfClassesModel
{
	// --- ATTRIBUTES ---
	private $subject     = NULL;
	private $coursesType = NULL;
	private $numHours    = NULL;


	// --- OPERATIONS ---
	/**
	 * \brief ElemOfClassesModel’s constructor
	 * \param $newSubject     The subject of the element.
	 * \param $newCoursesType The type of the course.
	 * \param $newNumHours    The number of hours of the subject.
	*/
	public function __construct($newSubject, $newCoursesType, $newNumHours)
	{
		$this->subject      = $newSubject;
		$this->coursesType  = $newCoursesType;
		$this->numHours     = $newNumHours;
	}

	// getters
	/**
	 * \brief  Getter for the attribute $subject.
	 * \return The value of $subject.
	*/
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * \brief  Getter for the attribute $coursesType.
	 * \return The value of $coursesType.
	*/
	public function getCoursesType()
	{
		return $this->coursesType;
	}

	/**
	 * \brief  Getter for the attribute $numHours.
	 * \return The value of $numHours.
	*/
	public function getNumHours()
	{
		return $this->numHours;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $subject.
	 * \param  $newSubject Contains the new value of $subject.
	*/
	public function setSubject($newSubject)
	{
		if ($newSubject instanceof Subject)
		{
			$this->subject = $newSubject;
		}
		else
		{
			echo 'Erreur dans la méthode setSubject() de la classe ElemOfClassesModel : l’argument donné n’est pas une matière.';
		}
	}

	/**
	 * \brief  Setter for the attribute $coursesType.
	 * \param  $newCoursesType Contains the new value of $coursesType.
	*/
	public function setCoursesType($newCoursesType)
	{
		if (!empty($newCoursesType))
		{
			$this->coursesType = $newCoursesType;
		}
	}

	/**
	 * \brief  Setter for the attribute $numHours.
	 * \param  $newNumHours Contains the new value of $numHours.
	*/
	public function setNumHours($newNumHours)
	{
		if (!empty($newNumHours))
		{
			$this->numHours = $newNumHours;
		}
	}
}
?>
