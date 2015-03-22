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
	protected $ID = null;
	private $Password = null;

	// --- OPERATIONS ---
	// Constructeurs
	// Flora NOTE: Ailleurs devra être défini l'accès au CAS
	// Flora PERSO: Rappel l'appel au constructeur de la classe mère n'est jamais implicite
	public function __construct($nom, $prenom, $identifiant, $mdp)
	{
		parent::__construct($nom, $prenom);
		$this->ID = $identifiant;
		$this->Password = $mdp;
	}

	// Accesseurs
	public get_ID()
	{
		return $this->ID;
	}

	public is_Password($mdp)
	{
		return $Password == $mdp;
	}

	// Flora NOTE: La fonction ci-dessous peut ne pas être utile finalement
	static public function convertPersonToUser(Personne $P, $identifiant, $mdp)
	{
		$U = __construct(P->nom, P->prenom, $identifiant, $mdp);
		$P = $U;

		return $U;
	}

	public function logIn()
	{
	}

	public function logOut()
	{
	}

	public function readTimetable(EDT $E)
	{
		$returnValue = false;

		// Flora NOTE: Si c" un RESP,ADMIN,SECRETAIRE OK. Si c'est un enseignant, vérifier que c'est le bon edt
		// S'il y a un souci par rapport à l'accès à l'edt renvoyer une erreur

	return $returnValue;
	}

	// Affichage texte
	public function to_html()
	{
		$result = "<b>ID: &emsp;&emsp;" . $this->ID . "</b><br/>";
		$result = $result . parent::to_html();

		return $result;
	}
}
?>
