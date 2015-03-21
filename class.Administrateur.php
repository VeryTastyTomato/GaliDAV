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
	public function __construct($nom, $prenom, $identifiant, $mdp)
	{
		parent::__construct($nom, $prenom, $identifiant, $mdp);
		//$this->add_status(); //Flora TODO: indiquer le statut Administrateur
	}

	public function ajouterUtilisateur($nom, $prenom, $identifiant, $mdp)
	{
		return new Utilisateur($nom, $prenom, $identifiant, $mdp);
	}

	public function ajouterUtilisateur(Personne $P)
	{
		return Utilisateur::convertPersonToUser($P);
	}

	public function ajouterUtilisateurCAS($UnkownData)
    {
		$returnValue = null;

		return $returnValue;
	}

	public function changerStatutUtilisateur(Utilisateur $U, Statut_personne $S, $operation)
	{
		if ($operation == 'add')
		{
			$U->add_status($S);
		}
		else if ($operation=='remove')
		{
			$U->remove_status($S);
		}
	}

	//Flora: On veut supprimer le compte utilisateur mais pas la personne
	public function supprimerUtilisateur(Utilisateur $U)
	{
		$P = new Person($U->get_nom(), $U->get_prenom);
		$P->set_mail1($U->get_mail1());
		$P->set_mail2($U->get_mail2());
		$U = $P;

		return $U;
		//Flora TODO Adapter l'entrée de la BDD
	}

	public function supprimerPersonne(Personne $P)
	{
		$U->__destroy();
		$U=NULL;
		//Flora TODO: Tester et voir s'il n'ya pas plus approprié
		// + Supprimer de la BDD
	}

	public function ajouterClasse(String $Nom)
	{	
		return new Classe($Nom);
	}

	//Flora TODO: Utiliser les fonctions de la classe Classe,fille de Groupe (ajouter/supprimer un étudiant en l'occurence)
	public function modifierClasse(Classe $C, $operation)
	{
	}
}
?>
