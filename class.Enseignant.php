<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Enseignant.php
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
require_once('class.EDT.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BDF-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BDF-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BDF-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BDF-constants end

/**
 * Short description of class Enseignant
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Enseignant
    extends Utilisateur
{
    // --- ASSOCIATIONS ---
		

    // --- ATTRIBUTES ---

	private $edt_personnel=null;
    // --- OPERATIONS ---
    public function __construct($nom,$prenom,$identifiant,$mdp){
    	parent::__construct($nom,$prenom,$identifiant,$mdp);
    	//$this->add_status(); //Flora TODO: indiquer le statut  Enseignant
    	$this->edt_personnel=new EDT();
    	
    }
	public function get_edt_personnel(){
	
		return $this->edt_personnel;
	}
    /**
     * Short description of method lireEDTpersonnel
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return Boolean
     */
    public function lireEDTpersonnel()
    {
        parent::lireEDT($this->edt_personnel);
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BE0 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BE0 end

        return parent::lireEDT($this->edt_personnel);
    }

} /* end of class Enseignant */

?>
