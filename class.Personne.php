<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Personne.php
 *
 * $Id$
 *
 * This file is part of modèle.edt.galilée.
 *
 * Automatically generated on 18.03.2015, 17:41:28 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include Personne_Statut_persone
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('Personne/unknown.Statut_persone.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-constants end

/**
 * Short description of class Personne
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Personne
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : statuts

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute nom
     *
     * @access protected
     * @var String
     */
    protected $nom = null;

    /**
     * Short description of attribute prenom
     *
     * @access protected
     * @var String
     */
    protected $prenom = null;

    /**
     * Short description of attribute mail1
     *
     * @access protected
     * @var String
     */
    protected $mail1 = null;

    /**
     * Short description of attribute mail2
     *
     * @access protected
     * @var String
     */
    protected $mail2 = null;

    // --- OPERATIONS ---

} /* end of class Personne */

?>