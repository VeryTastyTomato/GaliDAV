<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.EDT.php
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
 * include Cours
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Cours.php');

/**
 * include Modification
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Modification.php');

/**
 * include Utilisateur
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Utilisateur.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C24-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C24-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C24-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C24-constants end

/**
 * Short description of class EDT
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class EDT
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : listeCours    // generateAssociationEnd :     // generateAssociationEnd : modificateurActuel    // generateAssociationEnd : ListeCours

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute id_edt
     *
     * @access public
     * @var Integer
     */
    const id_edt = null;

    // --- OPERATIONS ---

    /**
     * Short description of method extraireExamens
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return Cours[]
     */
    public function extraireExamens()
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C33 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C33 end

        return $returnValue;
    }

} /* end of class EDT */

?>