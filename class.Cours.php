<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('Cours/unknown.Type_cours.php');
require_once('class.EDT.php');
require_once('class.Matiere.php');

class Cours
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $sqlid=null;
	private $number = null;
	private $begin;
	private $end;
	private $room = null;
	private $typeOfCourse = null;
	private $subject = null;
	
	const TABLENAME = "gcourse";
	const SQLcolumns = "id serial PRIMARY KEY, name varchar(30) NOT NULL, room varchar(30), begin timestamp without timezone NOT NULL, end timestamp without timezone NOT NULL, id_subject integer REFERENCES gsubject(id), type integer";
	const belongsToTABLENAME = "gcourse_belongs_to";
	const SQLcolumns = "id_course integer REFERENCES gcourse(id), id_calendar integer REFERENCES gcalendar(id), constraint gcourse_belongs_to_pk PRIMARY KEY(id_course,id_calendar)";
	
	/* Flora: A Course in GaliDAV DataBase doesnt correspond to a collection_item (event) in Davical DB.
		In fact, a collection item has repetition rules that could be translated in several courses in GaliDAV database.
		On the other hand, a GaliDAV course can be shared by
	*/

	// --- OPERATIONS ---
	// constructor
	public function __construct(Matiere $m, $begin, $end)
	{
		if (!is_int($begin))
		{
			$begin = time();
		}

		if (!is_int($end))
		{
			$end = time();
		}

		$this->subject = $m;
		$this->begin = $begin;
		$this->end = $end;
	}

	// getters
	public function getNumber()
	{
		return $this->number;
	}

	public function getBegin()
	{
		return $this->begin;
	}

	public function getBegin_string()
	{
		return date('d/m/Y H:i', $this->begin);
	}

	public function getEnd()
	{
		return $this->end;
	}

	public function getEnd_string()
	{
		return date('d/m/Y H:i',$this->end);
	}

	public function getRoom()
	{
		return $this->room;
	}

	public function getTypeOfCourse()
	{
		return $this->getTypeOfCourse;
	}

	public function getTypeOfCourse_string()
	{
		switch($this->typeOfCourse)
		{
			case(CM):
				return "CM";
			case(TD):
				return "TD";
			case(TP):
				return "TP";
			case(Examen):
				return "Partiel";
			case(Conférence):
				return "Conférence";
			case(Rattrapage):
				return "Rattrapage";
			default:
				return "Type inconnu";
		}
	}

	public function getSubject()
	{
		return $this->subject;
	}
	
	public function getSqlid()
	{
		return $this->sqlid;
	}	

	// setters
	public function setNumber($newNumber)
	{
		if (!empty($newNumber))
		{
			$this->number = $newNumber;
		}
	}

	public function setBegin($newBegin)
	{
		if (!empty($newBegin))
		{
			$this->begin = $newBegin;
		}
	}

	public function setEnd($newEnd)
	{
		if (!empty($newEnd))
		{
			$this->end = $newEnd;
		}
	}

	public function setRoom($newRoom)
	{
		if (!empty($newRoom))
		{
			$this->room = $newRoom;
		}
	}

	public function setTypeOfCourse($newType)
	{
		if (!empty($newType))
		{
			$this->typeOfCourse = $newType;
		}
	}

	public function setSubject($newSubject)
	{
		if (!empty($newSubject))
		{
			$this->subject = $newSubject;
		}
	}

	// others
	public function integrateInTimetable(EDT $timetable)
	{
		$timetable->addCourse($this);
	}

	public function remove()
	{
		// Etienne : accès à la BDD pour la delete ?
	}

	// -- Affichage texte --
	public function toHTML()
	{
		$result = "<p>Matière:&emsp; &emsp; " . $this->subject->getName() . "<br/>Type de cours:&emsp; &emsp;". $this->typeOfCourse."&emsp; &emsp;&emsp; &emsp;Numero:&emsp; &emsp; " . $this->number . "<br/>Horaires:&emsp; du ".$this->getBegin_string()." au ".$this->getEnd_string()."<br/>Salle: &emsp; &emsp; ".$this->room."</p>";

		return $result;
	}
}
?>
