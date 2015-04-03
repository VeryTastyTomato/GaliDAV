<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Personne.php');

class Matiere
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $name = null;
	private $teachedBy = array();
	
	const TABLENAME="gsubject";
	const SQLcolumns="id serial PRIMARY KEY, name varchar(30) NOT NULL, id_speaker1 serial REFERENCES gperson(id), id_speaker2 serial REFERENCES gperson(id), id_speaker3 serial REFERENCES gperson(id), id_group serial REFERENCES ggroup(id), id_calendar serial REFERENCES gcalendar(id)";
	
	public function __construct($n){
		if(!is_string($n))
		{
			$n="Pas de nom";
		}
		$this->name=$n;	
	}

	// --- OPERATIONS ---
	// getters
	public function getName()
	{
		return $this->name;
	}

	public function getTeachedBy()
	{
		return $this->teachedBy;
	}

	public function isTeachedBy(Personne $P)
	{
		foreach($this->teachedBy as $person)
		{
			if($person==$P)return true;
		}
		return false;
	}
	// setters
	public function setName($newName)
	{
		if (!empty($newName))
		{
			$this->name = $newName;
		}
	}

	public function setTeachedBy($newTeachedBy)
	{
		if (!empty($newTeachedBy))
		{
			$this->name = $newTeachedBy;
		}
	}
	
	public function addTeacher(Personne $P)
	{
		if(!isTeachedBy($P))
		{
			$this->teachedBy[]=$P;
		}
	
	}
}
?>
