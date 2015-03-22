<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Cours.php');
require_once('class.Modification.php');
require_once('class.Utilisateur.php');

class EDT
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $id_edt = null;

	// Attribut teacher_owner pour savoir si c'est un EDT de groupe/classe (null), ou EDT d'enseignant (celui-ci sera accessible depuis cet attribut)
	private $teacher_owner = null;

	// --- OPERATIONS ---

	public function getId_EdT()
	{
		return $this->id_edt;
	}

	// Etienne : accesseur ajouté - pour Flora
	public function getTeacher()
	{
		return $this->teacher_owner;
	}

	public function extractExams()
	{
		$returnValue = null;

		return $returnValue;
	}
}
?>
