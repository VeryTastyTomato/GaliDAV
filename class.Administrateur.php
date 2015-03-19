<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Administrateur.php
 *
 * $Id$
 *
 * This file is part of modèle.edt.galilée.
 *
 * Automatically generated on 18.03.2015, 17:39:37 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include Utilisateur
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Utilisateur.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD0-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD0-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD0-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD0-constants end

/**
 * Short description of class Administrateur
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Administrateur
    extends Utilisateur
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

 	public function __construct($nom,$prenom,$identifiant,$mdp){
    	parent::__construct($nom,$prenom,$identifiant,$mdp);
    	//$this->add_status(); //Flora TODO: indiquer le statut  Administrateur
    }
    /**
     * Short description of method ajouterUtilisateur
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return Utilisateur
     */
    public function ajouterUtilisateur($nom,$prenom,$identifiant,$mdp)
    {
        return new Utilisateur($nom,$prenom,$identifiant,$mdp);
    }

    /**
     * Short description of method ajouterUtilisateur
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Personne P
     * @return Utilisateur
     */
    public function ajouterUtilisateur( Personne $P)
    {
        return Utilisateur::convertPersonToUser($P);
    }

    /**
     * Short description of method ajouterUtilisateurCAS
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return Utilisateur
     */
    public function ajouterUtilisateurCAS($UnkownData)
    {
        $returnValue = null;

        return $returnValue;
    }

    /**
     * Short description of method changerStatutUtilisateur
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Utilisateur U
     * @return mixed
     */
    public function changerStatutUtilisateur( Utilisateur $U,Statut_personne $S,$operation)
    {
    	if($operation=='add')$U->add_status($S);
    	else if($operation=='remove')$U->remove_status($S);
    }

    /**
     * Short description of method supprimerUtilisateur
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Utilisateur U
     * @return Personne
     */
     
     //Flora: On veut supprimer le compte utilisateur mais pas la personne
    public function supprimerUtilisateur( Utilisateur $U)
    {
        
        $P=new Person($U->get_nom(),$U->get_prenom);
        $P->set_mail1($U->get_mail1());
        $P->set_mail2($U->get_mail2());
        $U=$P;
        return $U;
		//Flora TODO Adapter l'entrée de la BDD
    }

    /**
     * Short description of method supprimerPersonne
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Personne P
     * @return mixed
     */
    public function supprimerPersonne( Personne $P)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BC8 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BC8 end
        $U->__destroy();
        $U=NULL;
        //Flora TODO: Tester et voir s'il n'ya pas plus approprié
        // + Supprimer de la BDD
    }

    /**
     * Short description of method ajouterClasse
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  String Nom
     * @return Classe
     */
    public function ajouterClasse( String $Nom)
  {	

        return new Classe($Nom);
    }

    /**
     * Short description of method modifierClasse
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Classe C
     * @param  operation
     * @return mixed
     */
     //Flora TODO: Utiliser les fonctions de la classe Classe,fille de Groupe (ajouter/supprimer un étudiant en l'occurence)
    public function modifierClasse( Classe $C, $operation)
    {
        // section 127-0-1-1-156e4f1e:14c2db648ab:-8000:0000000000000BE3 begin
        // section 127-0-1-1-156e4f1e:14c2db648ab:-8000:0000000000000BE3 end
    }

} /* end of class Administrateur */

?>
