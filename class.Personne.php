<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was generated for PHP 5');
}

require_once('Personne/unknown.Statut_personne.php');
require_once('class.BaseDeDonnees.php');
//Les opérations sur une Personne sont automatiquement reportées dans la BDD
class Personne
{
	// --- ASSOCIATIONS ---
	protected $status = array();

	// --- ATTRIBUTES ---
	protected $sqlid = null;
	protected $familyName = null;
	protected $firstName = null;
	protected $emailAddress1 = null;
	protected $emailAddress2 = null;
	const TABLENAME = "gperson";
	const SQLcolumns = "id serial PRIMARY KEY, familyname varchar(30) NOT NULL, firstname varchar(30) NOT NULL, emailaddress1 varchar(60), emailaddress2 varchar(60), date_creation timestamp";

	// --- OPERATIONS ---
	// builder
	public function __construct($newFamilyName=null, $newFirstName=null, $email1 = null)
	{
		if($newFamilyName=null or $newFirstName=null)
		{
			$this->familyName = $newFamilyName;
			$this->firstName = $newFirstName;
			$params = array();
			$params[] = $newFamilyName;
			$params[] = $newFirstName;
			$params[] = "'now'";
			$query = "";
			if ($email1 == null)
			{
				$query = "INSERT INTO ".self::TABLENAME." (familyName, firstName,date_creation) VALUES ($1, $2,$3)";
			}
			else
			{
				$this->emailAddress1 = $email1;
				$params[] = $email1;
				$query = "INSERT INTO ".self::TABLENAME." (familyName,firstName,date_creation,emailAddress1) VALUES ($1, $2, $3, $4)";
			}

			$result = BaseDeDonnees::currentDB()->executeQuery($query,$params);

			if (!$result)
			{
				echo("GaliDAV: Impossible de créer cette personne dans la base");
			}
			else
			{
				$query = "SELECT id from ".self::TABLENAME." order by date_creation desc ";
				$result = BaseDeDonnees::currentDB()->executeQuery($query);
				$tmp = pg_fetch_assoc($result);
				$this->sqlid = $tmp['id'];
			}
		}
	}

	// getters
	public function getFamilyName()
	{
		return $this->familyName;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function getEmailAddress1()
	{
		return $this->emailAddress1;
	}

	public function getEmailAddress2()
	{
		return $this->emailAddress2;
	}
	
	public function getAllStatus()
	{
		return $this->status;
	}

	// setters
	public function setFamilyName($newFamilyName)
	{
		if (!empty($newFamilyName))
		{
			$query = "UPDATE ".self::TABLENAME." set familyName=$1;";
			$params[] = $newFamilyName;
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->familyName = $newFamilyName;
			}
			else
			{
				echo ('GaliDAV: Impossible de modifier le nom de famille de cette personne');
			}
		}
	}

	public function setFirstName($newFirstName)
	{
		if (!empty($newFirstName))
		{
			$query = "UPDATE ".self::TABLENAME." set firstName=$1;";
			$params[] = $newFirstName;
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			if ($result)
			{
				$this->firstName = $newFirstName;
			}
		}
	}

	public function setEmailAddress1($newEmailAddress1)
	{
		if (!empty($newEmailAddress1))
		{
			if (filter_var($newEmailAddress1, FILTER_VALIDATE_EMAIL))
			{
				$query = "UPDATE ".self::TABLENAME." set emailaddress1=$1;";
				$params[] = $newEmailAddress1;
				$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
				if ($result)
				{
					$this->emailAddress1 = $newEmailAddress1;
				}
			}
			else
			{
				echo 'Wrong address';
			}
		}
	}

	public function setEmailAddress2($newEmailAddress2)
	{
		if (!empty($newEmailAddress2))
		{
			if (filter_var($newEmailAddress2, FILTER_VALIDATE_EMAIL))
			{
				$query = "UPDATE ".self::TABLENAME." set emailaddress2=$1;";
				$params[] = $newEmailAddress2;
				$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);

				if ($result)
				{
					$this->emailAddress2 = $newEmailAddress2;
				}
			}
			else
			{
				echo 'Wrong address';
			}
		}
	}

	public function setAllStatus($arrayOfStatus)
	{
		foreach ($this->status as $oneStatus)
		{
			$this->removeStatus($oneStatus);
		}

		foreach ($arrayOfStatus as $oneStatusbis)
		{
			$this->addStatus($oneStatusbis);
		}

		$this->status = $arrayOfStatus;
	}

	public function addStatus(Statut_personne $s)
	{
		if (!$this->hasStatus($s))
		{
			$params[] = $this->sqlid;
			$params[] = $s->toInt();
			$query = "INSERT INTO ".Statut_personne::TABLENAME." (id_person,status) VALUES ($1, $2)";
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->status[] = $s;
			}
		}
	}

	public function removeStatus(Statut_personne $s)
	{
		if ($this->hasStatus($s))
		{
			$query = "DELETE FROM ".Statut_personne::TABLENAME." where id_person=".$this->sqlid." and status=".$s->toInt().";";

			if (BaseDeDonnees::currentDB()->executeQuery($query, $params))
			{
				$indice = 0;
				foreach ($this->status as $oneStatus)
				{
					if ($oneStatus == $s)
					{
						unset($this->status[$indice]);
						break;
					}

					$indice = $indice + 1;
				}
			}
		}
	}

	public function hasStatus(Statut_personne $s)
	{
		foreach ($this->status as $oneStatus)
		{
			if ($oneStatus == $s)
			{
				return true;
			}
		}

		return false;
	}
	
public function loadFromDB($id = null, $can_be_user=true)
	{
		if($id == null)
		{
			if ($this->sqlid != null)
			{
				$id = $this->sqlid;
			}
		}

		if($id == null)
		{
			if($can_be_user){
				$query = "select * from ".Personne::TABLENAME.";";
			}
			else
			{
				$query = "select * from ".Personne::TABLENAME." where id not in (select id_person from ".Utilisateur::TABLENAME.");";
			}
			$result = BaseDeDonnees::currentDB()->executeQuery($query);
		}
		else
		{
			if($can_be_user){
				$query = "select * from ".Personne::TABLENAME." where id=$1;";
			}
			else
			{
				$query = "select * from ".Personne::TABLENAME." where id=$1 and not exists (select * from ".Utilisateur::TABLENAME." where id_person=$1);";
			}
			$params=array($id);
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$result=pg_fetch_assoc($result);
		}
		$this->sqlid = $result['id'];
		$this->familyName = $result['familyname'];
		$this->firstName = $result['firstname'];
		$this->emailAddress1 = $result['emailaddress1'];
		$this->emailAddress2 = $result['emailaddress2'];
		//TODO valeurs des statuts
	}
	
	public function loadFromRessource($ressource)
	{
		if(is_array($ressource))
		{
			$this->sqlid = $ressource['id'];
			$this->familyName = $ressource['familyname'];
			$this->firstName = $ressource['firstname'];
			$this->emailAddress1 = $ressource['emailaddress1'];
			$this->emailAddress2 = $ressource['emailaddress2'];
		}

	
		//Flora: Remarque la valeurs des statuts nest pas chargée

	}
	public function loadStatusFromRessource($ressource)
	{
		if(is_array($ressource))
		{
			$this->addStatus(intval($ressource['status']));
		}
	}
	
	public function removeFromDB()
	{
		$params=array($this->sqlid);
		$query = "delete from ".Statut_personne::TABLENAME." where id_person=$1;";
		BaseDeDonnees::currentDB()->executeQuery($query,$params);
		$query = "select * from ".Utilisateur::TABLENAME." where id_person=$1;";
		$ressource=BaseDeDonnees::currentDB()->executeQuery($query,$params);
		if($ressource){
			$result=pg_fetch_assoc($ressource);
			$query = "delete from ".Utilisateur::TABLENAME." where id_person=$1;";
			BaseDeDonnees::currentDB()->executeQuery($query,$params);
			$BDD = new BaseDeDonnees("davical_app", "davical");
			if (!$BDD->connect())
			{
				echo("pas de connexion vrs davical");
			}
			else
			{
				$params=array($result['login']);
				$query = "delete from dav_principal where username=$1;";
				$BDD->executeQuery($query, $params);
				$BDD->close();
			}
		}
		$query = "delete from ".Personne::TABLENAME." where id=$1;";
		$params=array($this->sqlid);
		BaseDeDonnees::currentDB()->executeQuery($query,$params);
	}

	// -- Affichage texte --
	public function toHTML()
	{
		$result = "<p>Nom:&emsp;&emsp; " . $this->familyName . "<br/>Prenom:&emsp; &emsp; " . $this->firstName . "</p>";
		if ($this->getEmailAddress1() != NULL)
		{
			$result = $result . "<p>Adresse mail1 :&emsp; <i>" . $this->emailAddress1 . "</i>";

			if ($this->getEmailAddress2())
			{
				$result = $result . "<br/>Adresse mail2 :&emsp; <i>" . $this->emailAddress2 . "</i>";
			}

			$result = $result . "</p>";
		}

		if ($this->status != NULL)
		{
			$result = $result . "<p>Statuts:&emsp; ";
			foreach ($this->status as $s)
			{
				$result = $result . "- ".$s->toString()." ";
			}
			$result = $result . "</p>";
		}
		return $result;
	}
}
?>
