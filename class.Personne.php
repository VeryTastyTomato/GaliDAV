<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was generated for PHP 5');
}

require_once('Personne/unknown.Statut_personne.php');
require_once('class.BaseDeDonnees.php');
class Personne
{
	// --- ASSOCIATIONS ---
	protected $status = array();

	// --- ATTRIBUTES ---
	protected $familyName = null;
	protected $firstName = null;
	protected $emailAddress1 = null;
	protected $emailAddress2 = null;
	const TABLENAME="GaliDAVPerson";
	const SQLcolumns="id int SERIAL PRIMARY KEY, familyName varchar2(30) NOT NULL,firstName varchar2(30) NOT NULL, emailAddress1 varchar2(50),emailAddress1 varchar2(60), emailAddress1 varchar2(60)";
	

	// --- OPERATIONS ---
	// builder
	public function __construct($newFamilyName, $newFirstName)
	{
		$this->familyName = $newFamilyName;
		$this->firstName = $newFirstName;
		
		$query="INSERT INTO ".self::TABLENAME." (familyName, firstName) VALUES (:familyName, :firstName)";
		$params=array();
		$params[':familyName']=$newFamilyName;
		$params[':firstName']=$newFamilyName;
		BaseDeDonnes::currentDB().executeQuery($query,$params);
		
	}
	public function __construct($newFamilyName, $newFirstName,$email1)
	{
		$this->familyName = $newFamilyName;
		$this->firstName = $newFirstName;
		$this->emailAddress1 = $email1;
		
		$query="INSERT INTO ".self::TABLENAME." (familyName, firstName,emailAddress1) VALUES (:familyName, :firstName, :email1)";
		$params=array();
		$params[':familyName']=$newFamilyName;
		$params[':firstName']=$newFamilyName;
		$params[':email1']=$email1;
		BaseDeDonnes::currentDB().executeQuery($query,$params);
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
	
	public function getAllStatus(){
		return $this->status;
	}

	// setters
	public function setFamilyName($newFamilyName)
	{
		if (!empty($newFamilyName))
		{
			$this->familyName = $newFamilyName;
		}
	}

	public function setFirstName($newFirstName)
	{
		if (!empty($newFirstName))
		{
			$this->firstName = $newFirstName;
		}
	}

	public function setEmailAddress1($newEmailAddress1)
	{
		if (!empty($newEmailAddress1))
		{
			if (filter_var($newEmailAddress1, FILTER_VALIDATE_EMAIL))
			{
				$this->emailAddress1 = $newEmailAddress1;
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
				$this->emailAddress1 = $newEmailAddress2;
			}
			else
			{
				echo 'Wrong address';
			}
		}
	}
	public function setAllStatus($arrayOfStatus){
		$this->status=$arrayOfStatus;
	}

	public function addStatus($s)
	{
		if ($s instanceof Statut_personne)
		{
			if (!$this->hasStatus($s))
			{
				$this->status[]=$s;
			}
		}
	}

	public function removeStatus($s)
	{
		if ($s instanceof Statut_personne)
		{
			if ($this->hasStatus($s))
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
