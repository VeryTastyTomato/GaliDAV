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
	private $number = null;
	private $begin;
	private $end;
	private $room = null;
	private $typeOfCourse = null;
	private $subject = null; 
	
	// --- OPERATIONS ---
	// builders
	public function __construct(Matiere $m, $begin, $end)
	{
		if(!is_int($begin)){
			$begin=time();
		}
		if(!is_int($end)){
			$end=time();
		}
		
		$this->subject=$m;
		$this->begin=$begin;
		$this->end=$end;
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
		return date('d/m/Y H:i',$this->begin);
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

	public function getSubject()
	{
		return $this->subject;
	}
	public function getTypeOfCourse(){
		return $this->getTypeOfCourse;
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

	public function setSubject($newSubject)
	{
		if (!empty($newSubject))
		{
			$this->subject = $newSubject;
		}
	}
	public function setTypeOfCourse($type){
		$this->typeOfCourse=$type;
	}

	// others
	public function remove()
	{
		// Etienne : accès à la BDD pour la delete ?
	}

	public function integrateInTimetable(EDT $timetable)
	{
	}
	
	public function getTypeOfCourse_string(){
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
	
	// -- Affichage texte --
	public function toHTML()
	{
		$result = "<p>Matière:&emsp; &emsp; " . $this->subject->getName() . "<br/>Type de cours:&emsp; &emsp;". $this->typeOfCourse."&emsp; &emsp;&emsp; &emsp;Numero:&emsp; &emsp; " . $this->number . "<br/>Horaires:&emsp; du ".$this->getBegin_string()." au ".$this->getEnd_string()."<br/>Salle: &emsp; &emsp; ".$this->room."</p>";
		return $result;
	}
}
?>
