<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('Responsable/unknown.Type_responsable.php');
require_once('class.Classe.php');
require_once('class.Utilisateur.php');

class Responsable extends Utilisateur
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---
	// Flora NOTE: Etant donné que tous les responsables ont les mêmes droits de modifications, le type
	// est pour l'instant non réellement utile mais gardons le pour des évolutions futures.
	private $type = null;

	// --- OPERATIONS ---
	public function __construct($nom, $prenom, $identifiant, $mdp)
	{
		parent::__construct($nom, $prenom, $identifiant, $mdp);
		// $this->add_status(); // Flora TODO: indiquer le statut Responsable
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
}
?>
