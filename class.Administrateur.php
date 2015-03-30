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
	// builder
	public function __construct($familyName, $firstName, $id, $passwd)
	{
		parent::__construct($familyName, $firstName, $id, $passwd);
		$this->addStatus(new Statut_personne(Statut_personne::ADMINISTRATOR));
	}

	// others
	public function addUser($familyName, $firstName, $id, $passwd)
	{
		return new Utilisateur($familyName, $firstName, $id, $passwd);
	}

	public function convertPersonToUser(Personne $p)
	{
		return Utilisateur::convertPersonToUser($p);
	}

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

	// Flora: On veut supprimer le compte utilisateur mais pas la personne
	public function deleteUser(Utilisateur $u)
	{
		$p = new Person($u->getFamilyName(), $u->getFirstName());
		$p->setEmailAddress1($u->getEmailAddress1());
		$p->setEmailAddress2($u->getEmailAddress2());
		$u = $p;

		return $u;
		// Flora TODO Adapter l'entrée de la BDD
	}

	public function deletePerson(Personne $p)
	{
		$p->__destroy();
		$p = NULL;
		// Flora TODO: Tester et voir s'il n'ya pas plus approprié
		// + Supprimer de la BDD
	}

	public function addClass(String $name)
	{
		return new Classe($name);
	}

	// Flora TODO: Utiliser les fonctions de la classe Classe, fille de Groupe (ajouter/supprimer un étudiant en l'occurence)
	public function modifyClass(Classe $c, $operation)
	{
	}
}
?>
