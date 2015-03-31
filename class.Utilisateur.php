<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Personne.php');
require_once('class.EDT.php');
require_once('class.BaseDeDonnees.php');

class Utilisateur extends Personne
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	protected $id = null;
	private $passwd = null;
	const TABLENAME="guser";
	const SQLcolumns="id_person serial PRIMARY KEY REFERENCES gperson(id), login varchar(30) NOT NULL, id_principal integer UNIQUE, password varchar(30), last_connection timestamp"; //Ce n'est pas ici, qu'on touche au paramètre id_principal

	// --- OPERATIONS ---
	// builder
	// Flora NOTE: Ailleurs devra être défini l'accès au CAS
	// Flora PERSO: Rappel l'appel au constructeur de la classe mère n'est jamais implicite
	public function __construct($familyName, $firstName, $id, $passwd)
	{
		parent::__construct($familyName, $firstName);
		$this->id = $id;
		$this->passwd = $passwd; //Il faut chiffrer le mot de passe pour le sauvegarder
		
		$params[]=$this->sqlid;
		$params[]=$id;
		$query="INSERT INTO ".self::TABLENAME." (id_person, login) VALUES ($1, $2)";
		$result=BaseDeDonnees::currentDB()->executeQuery($query,$params);
		if(!$result)echo("GaliDAV: Impossible de créer cet utilisateur dans la base");
		
	}

	// Accesseurs
	public function getId()
	{
		return $this->id;
	}

	public function isPassword($givenPassword)
	{
		return $givenPassword == $this->passwd;
	}

	// Flora NOTE: La fonction ci-dessous peut ne pas être utile finalement
	static public function convertPersonToUser(Personne $p, $login, $passwd)
	{
		$query="delete from ".Statut_personne::TABLENAME." where id_person=".$p->sqlid.";";
		BaseDeDonnees::currentDB()->executeQuery($query);
		$query="delete from ".parent::TABLENAME." where id=".$p->sqlid.";";
		BaseDeDonnees::currentDB()->executeQuery($query);
		$u = new Utilisateur($p->familyName, $p->firstName, $login, $passwd);
		$u->setEmailAddress1($p->getEmailAddress1());
		$u->setEmailAddress2($p->getEmailAddress2());
		$u->setAllStatus($p->getAllStatus());
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
		$result = $result.parent::toHTML();

		return $result;
	}
}
?>
