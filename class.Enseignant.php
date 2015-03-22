<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Utilisateur.php');
require_once('class.EDT.php');

class Enseignant extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	private $edt_personnel = null;

	// --- OPERATIONS ---
	public function __construct($nom,$prenom,$identifiant,$mdp)
	{
		parent::__construct($nom,$prenom,$identifiant,$mdp);
		// $this->add_status(); // Flora TODO: indiquer le statut Enseignant
		$this->edt_personnel = new EDT();
	}

	public function get_edt_personnel()
	{
		return $this->edt_personnel;
	}

	public function lireEDTpersonnel()
	{
		parent::lireEDT($this->edt_personnel);

		return parent::lireEDT($this->edt_personnel);
	}
}
?>
