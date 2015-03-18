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
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BD4 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BD4 end

        return $returnValue;
    }

} /* end of class Utilisateur */

?>