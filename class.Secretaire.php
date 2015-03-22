<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Utilisateur.php');
require_once('class.Matiere.php');
require_once('Cours/unknown.Type_cours.php');
require_once('class.Groupe.php');
require_once('class.Classe.php');

class Secretaire extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	public function __construct($nom, $prenom, $identifiant, $mdp)
	{
		parent::__construct($nom, $prenom, $identifiant, $mdp);
		// $this->add_status(); // Flora TODO: indiquer le statut Secrétaire
	}

	// Flora TODO: Utiliser les méthodes de la classe EDT pour compléter cette fonction
	public function modifierEDT(EDT $E, Cours $C, $Operation)
	{
		$returnValue = null;

		return $returnValue;
	}

	public function ajouterGroupe(String $Nom)
	{
		new Groupe($Nom, false);
	}

	// Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer un étudiant en l'occurence)
	public function modifierGroupe_Membres(Personne $Etu, $operation)
	{
		$returnValue = null;

		return $returnValue;
	}

	// Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer un étudiant en l'occurence)
	public function modifierGroupe_ClassesRattachees(Classe $C, $operation)
	{
		$returnValue = null;

		return $returnValue;
	}

	// Flora NOTE: On va devoir faire appel aux commandes 'bas niveau' du serveur caldav
	public function comparerEDT($ListeEDT, $Debut, $Fin)
	{
		$returnValue = null;

		return $returnValue;
	}

	// Flora TODO: Utiliser les fonctions de la classe EDT (valider l'ensemble des modifs en l'occurrrence)
	public function validerEDT(EDT $E)
	{
	}

	// Flora TODO: implémenter des accesseurs pour la maquette dans la classe Classe
	public function modifierMaquetteClasse(Classe $C, Matiere $M, Type_cours $type, $nb_heures)
	{
	}
}
?>
