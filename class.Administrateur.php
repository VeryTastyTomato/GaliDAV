<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Utilisateur.php');

class Administrateur extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	// constructor
	public function __construct($familyName, $firstName, $login, $passwd, $email = null)
	{
		parent::__construct($familyName, $firstName, $login, $passwd, $email);
		$this->addStatus(new Statut_personne(Statut_personne::ADMINISTRATOR));
		$this->addStatus(new Statut_personne(Statut_personne::HEAD));
		$this->addStatus(new Statut_personne(Statut_personne::TEACHER));
		/*$BDD=new BaseDeDonnees("davical_app","davical");
		$params[]=privilege_to_bits(array('all'));
		$params[]=$login;
		$query="update dav_principal set default_privileges=$1 where username=$2;";
		$result=$BDD->executeQuery($query,$params);
		$BDD->close();
		if(!$result)echo("GaliDAV: Erreur d'écriture dans la base davical");
		*/
	}

	// others
	public function addUser($familyName, $firstName, $login, $passwd, $email = null)
	{
		return new Utilisateur($familyName, $firstName, $login, $passwd, $email);
	}

/*
	public function convertPersonToUser(Personne $p)
	{
		return Utilisateur::convertPersonToUser($p);
	}
*/
	public function addUserCAS($unknownData)
	{
		$returnValue = null;

		return $returnValue;
	}

	public function changeUserStatus(Utilisateur $u, Statut_personne $s, $operation)
	{
		if ($operation == 'add')
		{
			$u->addStatus($s);
		}
		else if ($operation == 'remove')
		{
			$u->removeStatus($s);
		}
	}

	// Deletes an user but preserves the person and all his/her references
	public function deleteUser(Utilisateur $u)
	{
		//First, the user is removed from dav_principal of davical and guser of galidav
		$params[] = $u->login;
		$query = "remove from dav_principal where username=$1;";
		$BDD->executeQuery($query, $params);
		$BDD->close();
		$query = "delete from ".Utilisateur::TABLENAME." where login=$1;";
		BaseDeDonnees::currentDB()->executeQuery($query, $params);

		//Flora: TODO Manage the status : a person who cannot access the database can't be an admin/secretary/head. What about Teacher?

		//Then, the object is replaced by a similar object, instance of the class Personne rather than Utilisateur
		$p = new Person($u->getFamilyName(), $u->getFirstName());
		$p->setEmailAddress1($u->getEmailAddress1());
		$p->setEmailAddress2($u->getEmailAddress2());
		$u = $p;

		return $u;
	}

	//Deletes a person (the object and the entries in the database)
	public function deletePerson(Personne $p)
	{
		$p->removeFromDB();
		$p->__destroy();
		$p = null;
		// Flora TODO: Tester et voir s'il n'ya pas plus approprié
	}

	public function addClass(String $name)
	{
		return new Classe($name);
	}

	public function modifyClass(Classe $c, Personne $etu, $operation)
	{
		if ($operation == 'add')
		{
			$c->addStudent($etu);
		}
		else if ($operation == 'remove')
		{
			$c->removeStudent($etu);
		}
		else
		{
			echo 'Erreur dans la méthode modifyClass() de la classe Administrateur : opération invalide.';
		}
	}
}
?>
