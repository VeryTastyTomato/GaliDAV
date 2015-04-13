<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Personne.php');
require_once('class.EDT.php');
require_once('test_davical_operations.php');
require_once('class.BaseDeDonnees.php');
require_once('AWLUtilities.php');
class Utilisateur extends Personne
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	protected $login = NULL;
	protected $passwd = NULL;

	const TABLENAME = "guser";
	const SQLcolumns = "id_person serial PRIMARY KEY REFERENCES gperson(id), login varchar(30) UNIQUE NOT NULL, id_principal integer UNIQUE, password varchar(30), last_connection timestamp"; // Ce n'est pas ici qu'on touche au paramètre id_principal

	// --- OPERATIONS ---
	// constructor
	// Flora NOTE: Ailleurs devra être défini l'accès au CAS
	// Flora PERSO: Rappel l'appel au constructeur de la classe mère n'est jamais implicite
	public function __construct($familyName = NULL, $firstName = NULL, $login = NULL, $passwd = NULL, $email1 = NULL)
	{
		parent::__construct($familyName, $firstName, $email1);

		if ($login != NULL and $passwd != NULL)
		{
			$this->login  = $login;
			$this->passwd = $passwd;
			$hash_passwd=session_salted_sha1($passwd); // Il faut chiffrer le mot de passe pour le sauvegarder
			$fullname     = $familyName . " " . $firstName;
			CreateUserAccount($login, $fullname, $hash_passwd, $email1);
			$params2[] = $this->sqlid;
			$params2[] = $login;
			$query     = "INSERT INTO " . self::TABLENAME . " (id_person, login) VALUES ($1, $2);";
			$result    = BaseDeDonnees::currentDB()->executeQuery($query, $params2);

			if (!$result)
			{
				echo ("GaliDAV: Impossible de créer cet utilisateur dans la base");
			}

			$this->setPassword($passwd);
		}
	}

	// getters
	public function getLogin()
	{
		return $this->login;
	}

	public function getPasswd()
	{
		return $this->passwd;
	}

	// static functions
	// Flora NOTE: La fonction ci-dessous peut ne pas être utile finalement
	static public function convertPersonToUser(Personne $p, $login, $passwd)
	{
		$query = "delete from " . Statut_personne::TABLENAME . " where id_person=" . $p->sqlid . ";";
		BaseDeDonnees::currentDB()->executeQuery($query);
		$query = "delete from " . parent::TABLENAME . " where id=" . $p->sqlid . ";";
		BaseDeDonnees::currentDB()->executeQuery($query);
		$u = new Utilisateur($p->familyName, $p->firstName, $login, $passwd);
		$u->setEmailAddress1($p->getEmailAddress1());
		$u->setEmailAddress2($p->getEmailAddress2());
		$u->setAllStatus($p->getAllStatus());
		$p = $u;

		return $u;
	}

	// others
	public function isPassword($givenPassword)
	{
		return $givenPassword == $this->passwd;
	}

	protected function setPassword($givenPassword)
	{
		$params[] = session_salted_sha1($givenPassword);
		$params[] = $this->login;
		
		$query    = "update " . self::TABLENAME . " set password=$1 where login=$2;";
		if(!BaseDeDonnees::currentDB()->executeQuery($query, $params)){
			BaseDeDonnees::currentDB()->show_error();
		}
		else{
			$this->password=$givenPassword;
		}
	}

	public function logIn()
	{
	}

	public function logOut()
	{
	}

	public function loadFromDB($loginOrId = NULL, $notuseful = NULL)
	{
		if ($loginOrId == NULL)
		{
			if ($this->login != NULL)
			{
				$login = $this->login;
			}
		}

		if (!is_string($loginOrId) and !is_int($loginOrId)) // si le login ou l'id passé en paramètre est NULL et que l'objet est indéfini
		{
			$query  = "select * from " . self::TABLENAME . ";";
			$result = BaseDeDonnees::currentDB()->executeQuery($query);
		}
		else
		{
			if (is_string($loginOrId)) //If its a login
			{
				$query    = "select * from " . self::TABLENAME . " where login=$1;";
				$params[] = $loginOrId;
				$result   = BaseDeDonnees::currentDB()->executeQuery($query, $params[]);
			}
			else // else, it is an id
			{
				$query  = "select * from " . self::TABLENAME . " where id_person=" . $loginOrId . ";";
				$result = BaseDeDonnees::currentDB()->executeQuery($query);
			}
		}

		if ($result)
		{
			$result = pg_fetch_assoc($result);
		}
		else
		{
			return FALSE; // we did not find a matching $result in the database
		}

		$this->sqlid  = $result['id_person'];
		$this->login  = $result['login'];
		$this->passwd = $result['password']; // Corriger...

		return parent::loadFromDB();
	}

	public function removeFromDB()
	{
		parent::removeFromDB();
	}

	//Etienne: Elle doit retourner quoi cette méthode ? Seulement si l'user peut lire l'edt ou elle doit aussi l'afficher si l'user peut le lire ?
	//Flora: Vu comment, on est parti, on va dire un booléen.
	public function readTimetable(EDT $e)
	{
		$returnValue = FALSE;
		// Flora NOTE: Si c’est un RESP, ADMIN, SECRETAIRE OK. Si c'est un enseignant, vérifier que c'est le bon edt.
		// S'il y a un souci par rapport à l'accès à l'edt renvoyer une erreur
		// TODO Complete

		if(($this->hasStatus(4)) or (($this->hasStatus(5))or ($this->hasStatus(6)))) //$e is a secretary, head or admin
		{
			$returnValue = TRUE;
		}

		elseif($this->hasStatus(3)) //$e is a teacher
		{
			if($this->getPersonalTimetable() == $e) //it's the right timetable
			{
				$returnValue = TRUE;
			}
			else
			{
				echo ('Cet EDT ne vous appartient pas');
			}
		}

		else
		{
			echo ('Vous ne pouvez pas accéder à cet EDT');
		}
		return $returnValue;
	}

	// Affichage texte
	public function toHTML()
	{
		$result = "<b>ID: &emsp;&emsp;" . $this->login . "</b><br/>";
		$result = $result . parent::toHTML();

		return $result;
	}
}
?>
