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

class Utilisateur extends Personne
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	protected $login = null;
	protected $passwd = null;

	const TABLENAME = "guser";
	const SQLcolumns = "id_person serial PRIMARY KEY REFERENCES gperson(id), login varchar(30) NOT NULL, id_principal integer UNIQUE, password varchar, last_connection timestamp"; //Ce n'est pas ici, qu'on touche au paramètre id_principal

	// --- OPERATIONS ---
	// constructeur
	// Flora NOTE: Ailleurs devra être défini l'accès au CAS
	// Flora PERSO: Rappel l'appel au constructeur de la classe mère n'est jamais implicite
	public function __construct($familyName = null, $firstName = null, $login = null, $passwd = null, $email1 = null)
	{
		parent::__construct($familyName, $firstName, $email1);
		if ($login != null and $passwd != null)
		{
			$this->login = $login;
			$this->passwd = $passwd; //Il faut chiffrer le mot de passe pour le sauvegarder

			$fullname = $familyName." ".$firstName;
			CreateUserAccount($login, $fullname, $passwd, $email1);
			$params2[] = $this->sqlid;
			$params2[] = $login;
			$query = "INSERT INTO ".self::TABLENAME." (id_person, login) VALUES ($1, $2)";
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params2);

			if (!$result)
			{
				echo("GaliDAV: Impossible de créer cet utilisateur dans la base");
			}

			$this->setPassword($passwd);
			
			//Flora: NOTICE, ai  déplacé la communication avec la BD de Davical ici. Pour l'instant, la partie ci-dessous rame
			/*$BDD=new BaseDeDonnees("davical_app","davical");
			if(!$BDD->connect())echo("pas de connexion vrs davical");
			else{
				$params[]=$login;
				$query="select user_no from dav_principal where username=$1;";
				$result=$BDD->executeQuery($query,$params);
				$BDD->close();
				if($result)
				{
					$userno=pg_fetch_assoc($result)['user_no'];
					$U=new Utilisateur($familyName, $firstName, $login, $passwd,$email);
					$query="update ".Utilisateur::TABLENAME." set id_principal=$userno where login=$1;";
					if(BaseDeDonnees::currentDB()->executeQuery($query,$params))
					{
						$params2[]=$this->sqlid;
						$params2[]=$login;
						$query="INSERT INTO ".self::TABLENAME." (id_person, login) VALUES ($1, $2)";
						$result=BaseDeDonnees::currentDB()->executeQuery($query,$params2);
						if(!$result)echo("GaliDAV: Impossible de créer cet utilisateur dans la base");
					}
				}
			}*/
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
		$query = "delete from ".Statut_personne::TABLENAME." where id_person=".$p->sqlid.";";
		BaseDeDonnees::currentDB()->executeQuery($query);
		$query = "delete from ".parent::TABLENAME." where id=".$p->sqlid.";";
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
		$params[] = ($givenPassword);
		$params[] = $this->login;
		$query = "update ".self::TABLENAME." set password=crypt('$1',gen_salt('bf')) where login=$2;";
		BaseDeDonnees::currentDB()->executeQuery($query, $params);
	}

	public function logIn()
	{
	}

	public function logOut()
	{
	}
	
	public function loadFromDB($login = null, $notuseful = null)
	{
		if ($login == null)
		{
			if ($this->login != null)
			{
				$login = $this->login;
			}
		}

		if ($login == null)
		{
			$query = "select * from ".self::TABLENAME.";";
			$result = BaseDeDonnees::currentDB()->executeQuery($query);
		}
		else
		{
			$query = "select * from ".self::TABLENAME." where login=$1;";
			$params[] = $login;
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params[]);
		}

		$this->sqlid = $result['id_person'];
		$this->login = $result['login'];
		$this->passwd = $result['password']; // Corriger...
		$query = "DELETE FROM ".self::TABLENAME." where id_person=$1;";
		$params = array($this->sqlid);
		$result = BaseDeDonnees::currentDB()->executeQuery($query, $params[]);

		parent::loadFromDB();
		//TODO valeurs des statuts
	}

	public function removeFromDB()
	{
	/*
		$BDD = new BaseDeDonnees("davical_app", "davical");
		if (!$BDD->connect())
		{
			echo("pas de connexion vrs davical");
		}
		else
		{
			$params[] = $login;
			$query = "remove from dav_principal where username=$1;";
			$BDD->executeQuery($query, $params);
			$BDD->close();
			$query = "delete from ".self::TABLENAME." where id_person=".$this->sqlid.";";
			BaseDeDonnees::currentDB()->executeQuery($query);
			parent::removeFromDB();
		}*/
		parent::removeFromDB();
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
		$result = "<b>ID: &emsp;&emsp;" . $this->login . "</b><br/>";
		$result = $result.parent::toHTML();

		return $result;
	}
}
?>
