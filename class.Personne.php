<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was generated for PHP 5');
}

require_once('Personne/unknown.Statut_personne.php');

class Personne
{
	// --- ASSOCIATIONS ---
	protected $statuts = array();

	// --- ATTRIBUTES ---
	private $familyName = null;
	private $firstName = null;
	private $emailAddress1 = null;
	private $emailAddress2 = null;

	// --- OPERATIONS ---
	// builder
	public function __construct($newFamilyName, $newFirstName)
	{
		$this->familyName = $newFamilyName;
		$this->firstName = $newFirstName;
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

	public function hasStatus(Statut_personne $s)
	{
		foreach ($this->statuts as $oneStatus)
		{
			if ($oneStatus == $s)
			{
				return true;
			}
		}

		return false;
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
		//  todo: add a regular expression to check the parameter’s pattern
		if (!empty($newEmailAddress1))
		{
			$this->emailAddress1 = $newEmailAddress1;
		}
	}

	public function setEmailAddress2($newEmailAddress2)
	{
		//  todo: add a regular expression to check the parameter’s pattern
		if (!empty($newEmailAddress2))
		{
			$this->emailAddress2 = $newEmailAddress2;
		}
	}

	public function addStatus($s)
	{
		if ($s instanceof Statut_personne)
		{
			if (!$this->hasStatus($s))
			{
				$this->statuts[]=$s;
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

				foreach ($this->statuts as $oneStatus)
				{
					if ($oneStatus == $s)
					{
						unset($this->statuts[$indice]);
						break;
					}

					$indice = $indice + 1;
				}
			}
		}
	}

	// Flora: TO COMPLETE après que Simon ait fait les enums
	public function hasStatus(Statut_personne $s)
	{
		foreach ($this->statuts as $oneStatus)
		{
			if ($oneStatus == $S)
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

		if ($this->statuts != NULL)
		{
			$result = $result . "<p>Statuts:&emsp; ";

			foreach ($this->statuts as $s)
			{
				$result = $result . "- $s ";
			}

			$result = $result . "</p>";
		}

		return $result;
	}
}
?>
