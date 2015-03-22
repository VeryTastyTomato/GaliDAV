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
	private $typeCours = null;
	private $subject = null; // Etienne : la matière a sa place dans les attributs non ?<-Flora : OUi, c'est d'ailleurs une association vers la classe Matière

	// --- OPERATIONS ---
	// getters
	public function getNumber()
	{
		return $this->number;
	}

	public function getBegin()
	{
		return $this->begin;
	}

	public function getEnd()
	{
		return $this->end;
	}

	public function getRoom()
	{
		return $this->room;
	}

	public function getSubject()
	{
		return $this->subject;
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

	// others
	public function remove()
	{
		// Etienne : accès à la BDD pour la delete ?
	}

	public function Cours(Matiere $m, $begin, $end)
	{
		// Etienne : c'est un constructeur ça ?
		// Ibrar : il semblerait, le cas échéant il y a des méthodes standards pour ça
		//Flora: Non, un constructeur c'est __construct()
	}

	public function integrateInTimetable(EDT $timetable)
	{
	}
}
?>
