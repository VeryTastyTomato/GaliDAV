<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Personne.php');
require_once('class.EDT.php');

class Utilisateur extends Personne
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	protected $id = null;
	private $passwd = null;

	// --- OPERATIONS ---
	// builder
	// Flora NOTE: Ailleurs devra être défini l'accès au CAS
	// Flora PERSO: Rappel l'appel au constructeur de la classe mère n'est jamais implicite
	public function __construct($familyName, $firstName, $id, $passwd)
	{
		parent::__construct($familyName, $firstName);
		$this->id = $id;
		$this->passwd = $passwd;
	}

	// Accesseurs
	public function getId()
	{
		return $this->id;
	}

	public function isPassword($givenPassword)
	{
		// return $givenPassword == $passwd; code incorrect
	}

	// Flora NOTE: La fonction ci-dessous peut ne pas être utile finalement
	static public function convertPersonToUser(Personne $p, $id, $passwd)
	{
		$u = __construct($p->familyName, $P->firstName, $id, $passwd);
		$p = $u;

		return $u;
	}

	public function logIn()
	{
	}

	public function logOut()
	{
	}

	public function readTimetable(EDT $e)
	{
		$returnValue = false;

		// Flora NOTE: Si c" un RESP,ADMIN,SECRETAIRE OK. Si c'est un enseignant, vérifier que c'est le bon edt
		// S'il y a un souci par rapport à l'accès à l'edt renvoyer une erreur

	return $returnValue;
	}

	// Affichage texte
	public function toHTML()
	{
		$result = "<b>ID: &emsp;&emsp;" . $this->id . "</b><br/>";
		$result = $result . parent::toHTML();

		return $result;
	}
}
?>
