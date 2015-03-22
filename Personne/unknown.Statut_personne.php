<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

class Statut_personne
{
	// user defined constants
	const STUDENT = "Etudiant(e)";
	const SPEAKER = "Intervenant(e)";
	const TEACHER = "Enseignant(e)";
	const SECRETARY = "Secrétaire";
	const HEAD = "Responsable";
	const ADMINISTRATOR = "Administrateur/trice";
	const OTHER = "Autre";
	protected $value;

	function __construct($value)
	{
		$this->value = $value;
	}

	function toString()
	{
		if ($this->value == NULL)
		{
			return "Statut invalide";
		}
		else
		{
			return $this->value;
		}
	}
}
?>