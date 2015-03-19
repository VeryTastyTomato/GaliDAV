<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Utilisateur.php
 *
 * $Id$
 *
 * This file is part of modèle.edt.galilée.
 *
 * Automatically generated on 18.03.2015, 17:40:36 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include Personne
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Personne.php');
require_once('class.EDT.php');
/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BB2-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BB2-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BB2-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BB2-constants end

/**
 * Short description of class Utilisateur
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Utilisateur
    extends Personne
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute ID
     *
     * @access protected
     * @var String
     */
    protected $ID = null;

    /**
     * Short description of attribute Password
     *
     * @access private
     * @var String
     */
    private $Password = null;

    // --- OPERATIONS ---
    
    //Constructeurs
      //Flora NOTE: Ailleurs devra être défini l'accès au CAS
    //Flora PERSO: Rappel l'appel au constructeur de la classe mère n'est jamais implicite
     public function __construct($nom,$prenom,$identifiant,$mdp){
     	parent::__construct($nom,$prenom);
    	$this->ID=$identifiant;
    	$this->Password=$mdp;
    }
    
    //Accesseurs
    public get_ID(){
    	return $this->ID;
    }
    public is_Password($mdp){
    	return $Password==$mdp;
    }
    
  
    
    //Flora NOTE: La fonction ci-dessous peut ne pas être utile finalement
    static public function convertPersonToUser(Personne $P, $identifiant,$mdp){
    	$U=__construct(P->nom,P->prenom,$identifiant,$mdp);
    	$P=$U;
    	return $U;
    }

    /**
     * Short description of method connexion
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return mixed
     */
    public function connexion()
    {
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BBE begin
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BBE end
    }

    /**
     * Short description of method deconnexion
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return mixed
     */
    public function deconnexion()
    {
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC0 begin
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC0 end
    }

    /**
     * Short description of method lireEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  EDT E
     * @return Boolean
     */
    public function lireEDT( EDT $E)
    {
        $returnValue = false;
      
		//Flora NOTE: Si c" un RESP,ADMIN,SECRETAIRE OK. Si c'est un enseignant, vérifier que c'est le bon edt
		
		//S'il y a un souci par rapport à l'accès à l'edt renvoyer une erreur
		
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BD4 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BD4 end

        return $returnValue;
    }

	//Affichage texte
	public function to_html(){
		$result="<b>ID: &emsp;&emsp;".$this->ID."</b><br/>";
		$result=$result.parent::to_html();
		return $result;
	}
} /* end of class Utilisateur */

?>
