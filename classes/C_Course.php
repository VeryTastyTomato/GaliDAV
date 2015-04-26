<?php
/**
 * \file    C_Course.php
 * \brief   Defines the class Course.
 * \details Represents a course. A course in GaliDAV database doesn’t correspond to a collection item (event) in DAViCal database.
	In fact, a collection item has repetition rules that could be translated in several courses in GaliDAV database.
	On the other hand, a GaliDAV course can be shared by.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('types/T_Courses.php');
require_once('C_Timetable.php');
require_once('C_Subject.php');

class Course
{
	// --- ATTRIBUTES ---
	private $sqlId       = NULL;
	private $number      = NULL;
	private $begin;
	private $end;
	private $room        = NULL;
	private $coursesType = NULL;
	private $subject     = NULL;

	const TABLENAME           = "gcourse";
	const SQLcolumns          = "id serial PRIMARY KEY, name VARCHAR(30) NOT NULL, room VARCHAR(30), begins_at TIMESTAMP WITHOUT TIME ZONE NOT NULL, ends_at TIMESTAMP WITHOUT TIME ZONE NOT NULL, id_subject INTEGER REFERENCES gsubject(id), type INTEGER";
	const belongsToTABLENAME  = "gcourse_belongs_to";
	const belongsToSQLcolumns = "id_course INTEGER REFERENCES gcourse(id), id_calendar INTEGER REFERENCES gcalendar(id), CONSTRAINT gcourse_belongs_to_pk PRIMARY KEY(id_course, id_calendar)";

	/* TODO : Make the links with davical and name davical events differently depending on the collection (timetable) they belong to
	*/

	// --- OPERATIONS ---
	/**
	 * \brief Course’s constructor
	 * \param $newSubject The subject of the course.
	 * \param $newBegin   ???
	 * \param $newEnd     ???
	*/
	public function __construct(Subject $newSubject, $newBegin, $newEnd)
	{
		if (!is_int($begin))
		{
			$begin = time();
		}

		if (!is_int($end))
		{
			$end = time();
		}

		$this->subject = $newSubject;
		$this->begin   = $newBegin;
		$this->end     = $newEnd;
	}

	// getters
	/**
	 * \brief  Getter for the attribute $number.
	 * \return The \e integer value of $number.
	*/
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * \brief  Getter for the attribute $begin.
	 * \return The value of $begin.
	*/
	public function getBegin()
	{
		return $this->begin;
	}

	/**
	 * \brief  Getter for the attribute $begin.
	 * \return The string value of $begin.
	*/
	public function getBeginString()
	{
		return date('d/m/Y H:i', $this->begin);
	}

	/**
	 * \brief  Getter for the attribute $end.
	 * \return The value of $end.
	*/
	public function getEnd()
	{
		return $this->end;
	}

	/**
	 * \brief  Getter for the attribute $end.
	 * \return The string value of $end.
	*/
	public function getEndString()
	{
		return date('d/m/Y H:i', $this->end);
	}

	/**
	 * \brief  Getter for the attribute $room.
	 * \return The string value of $room.
	*/
	public function getRoom()
	{
		return $this->room;
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
	 * \brief  Getter for the attribute $coursesType.
	 * \return The string value of $coursesType.
	*/
	public function getCoursesTypeString()
	{
		switch ($this->coursesType)
		{
			case (CM):
				return "CM";
			case (TD):
				return "TD";
			case (TP):
				return "TP";
			case (EXAMEN):
				return "Partiel";
			case (CONFERENCE):
				return "Conférence";
			case (RATTRAPAGE):
				return "Rattrapage";
			default:
				return "Type inconnu";
		}
	}

	/**
	 * \brief  Getter for the attribute $subject.
	 * \return The value of $subject.
	*/
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * \brief  Getter for the attribute $sqlId.
	 * \return The integer value of $sqlId.
	*/
	public function getSqlId()
	{
		return $this->sqlId;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $number.
	 * \param  $newNumber Contains the new value of $number.
	*/
	public function setNumber($newNumber)
	{
		if (is_int($newNumber))
		{
			$this->number = $newNumber;
		}
	}

	/**
	 * \brief  Setter for the attribute $begin.
	 * \param  $newBegin Contains the new value of $begin.
	*/
	public function setBegin($newBegin)
	{
		if (!empty($newBegin))
		{
			$this->begin = $newBegin;
		}
	}

	/**
	 * \brief  Setter for the attribute $end.
	 * \param  $newEnd Contains the new value of $end.
	*/
	public function setEnd($newEnd)
	{
		if (!empty($newEnd))
		{
			$this->end = $newEnd;
		}
	}

	/**
	 * \brief  Setter for the attribute $room.
	 * \param  $newRoom Contains the new value of $room.
	*/
	public function setRoom($newRoom)
	{
		if (is_string($newRoom))
		{
			$this->room = $newRoom;
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
	 * \brief  Setter for the attribute $subject.
	 * \param  $newSubject Contains the new value of $subject.
	*/
	public function setSubject($newSubject)
	{
		if ($newSubject instanceof Subject)
		{
			$this->subject = $newSubject;
		}
	}

	// others
	/**
	 * \brief Integrates this course into the given timetable.
	 * \param $aTimetable The timetable in which the course will be integrated.
	*/
	public function integrateInTimetable(Timetable $aTimetable)
	{
		$aTimetable->addCourse($this);
	}


	/**
	 * \brief Removes the course from database.
	*/
	public function removeFromDB()
	{
	}

	/**
	 * \brief  Converts data about the course in HTML format.
	 * \return \e String containing data about the course.
	*/
	public function toHTML()
	{
		$result = "<p>Matière:&emsp; &emsp; " . $this->subject->getName() . "<br/>Type de cours:&emsp; &emsp;" . $this->coursesType . "&emsp; &emsp;&emsp; &emsp;Numero:&emsp; &emsp; " . $this->number . "<br/>Horaires:&emsp; du " . $this->getBeginString() . " au " . $this->getEndString() . "<br/>Salle: &emsp; &emsp; " . $this->room . "</p>";

		return $result;
	}
}
?>
