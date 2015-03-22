<?php

error_reporting(E_ALL);


if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}


require_once('Responsable/unknown.Type_responsable.php');


require_once('class.Classe.php');


require_once('class.Utilisateur.php');

class Responsable
    extends Utilisateur
{
   

    // --- ATTRIBUTES ---
    //Flora NOTE: Etant donné que tous les responsables ont les mêmes droits de modifications, le type
    //		est pour l'instant non réellement utile mais gardons le pour des évolutions futures.
    $type=null;

    // --- OPERATIONS ---
     	public function __construct($name,$surname,$id,$pass){
    	parent::__construct($name,$surname,$id,$pass);
    	$this->add_status(new Statut_personne(Statut_personne::HEAD)); 
    }
    
     //Flora TODO: Utiliser les méthodes de la classe EDT pour compléter cette fonction
    public function modifyTimeTable( EDT $E,  Cours $C, $Operation)
    {
        $returnValue = null;

        return $returnValue;
    }

    public function addGroup( String $Nom)
    {
      	new Groupe($Nom,false);
    }

     //Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer un étudiant en l'occurence)
    public function modifyGroup_Members( Personne $Etu, $operation)
    {
        $returnValue = null;

        return $returnValue;
    }

 
      //Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer une classe rattachée en l'occurence)
    public function modifyGroup_LinkedClasses( Classe $C, $operation)
    {
        $returnValue = null;


        return $returnValue;
    }


     //Flora NOTE: On va devoir faire appel aux commandes 'bas niveau' du serveur caldav
    public function compareTimeTables($ListeEDT, $Debut, $Fin)
    {
        $returnValue = null;

  

        return $returnValue;
    }

 
      //Flora TODO: Utiliser les fonctions de la classe EDT (valider l'ensemble des modifs en l'occurrrence)
    public function validateTimeTable( EDT $E)
    {
  
    }


	//Flora TODO: implémenter des accesseurs pour la maquette dans la classe Classe
	public function modifyClass_CoursesModel(Classe $C,Matiere $M, Type_cours $type, $nb_heures){
		//A completer
	
	}
} /* end of class Responsable */

?>
