<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Cours.php
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
 * include Cours_Type_cours
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('Cours/unknown.Type_cours.php');

/**
 * include EDT
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.EDT.php');

/**
 * include Matiere
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Matiere.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-constants end

/**
 * Short description of class Cours
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Cours
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : listeEDTs    // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd : 

    // --- ATTRIBUTES ---
    private static $enum_courses_types = array(
			"CM"=>0,
			"TD"=>1,
			"TP"=>2,
			"Examen"=>4,
			"Rattrapage"=>5,
			"Conference"=>6
		);
	
	public $courses_type = null;
	
    /**
     * Short description of attribute Numero
     *
     * @access public
     * @var Integer
     */
    public $Numero = null;

    /**
     * Short description of attribute Début
     *
     * @access public
     */
    public $Début[ null | null | null ];

    /**
     * Short description of attribute Fin
     *
     * @access public
     */
    public $Fin[ null | null | null ];

    /**
     * Short description of attribute Salle
     *
     * @access public
     * @var String
     */
    public $Salle = null;

    // --- OPERATIONS ---

    /**
     * Short description of method retirer
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return mixed
     */
    public function retirer()
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C04 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C04 end
    }

    /**
     * Short description of method modifierSalle
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  String S
     * @return mixed
     */
    public function modifierSalle( String $S)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C06 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C06 end
    }

    /**
     * Short description of method Cours
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Matiere M
     * @param  Debut
     * @param  Fin
     * @return mixed
     */
    public function Cours( Matiere $M, $Debut, $Fin)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C09 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C09 end
    }

    /**
     * Short description of method integrerDansEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  EDT E
     * @return mixed
     */
    public function integrerDansEDT( EDT $E)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C0E begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C0E end
    }

} /* end of class Cours */

?>
