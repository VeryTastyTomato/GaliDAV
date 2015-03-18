<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Secretaire.php
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
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC6-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC6-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC6-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC6-constants end

/**
 * Short description of class Secretaire
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Secretaire
    extends Utilisateur
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

    /**
     * Short description of method modifierEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  EDT E
     * @param  Cours C
     * @param  Operation
     * @return Boolean
     */
    public function modifierEDT( EDT $E,  Cours $C, $Operation)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BFA begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BFA end

        return $returnValue;
    }

    /**
     * Short description of method ajouterGroupe
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  String Nom
     * @param  Boolean EstUneClasse
     * @return mixed
     */
    public function ajouterGroupe( String $Nom,  Boolean $EstUneClasse)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C19 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C19 end
    }

    /**
     * Short description of method modifierGroupe
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Personne Etu
     * @param  operation
     * @return Boolean
     */
    public function modifierGroupe( Personne $Etu, $operation)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C1C begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C1C end

        return $returnValue;
    }

    /**
     * Short description of method modifierGroupe
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Classe C
     * @param  operation
     * @return Boolean
     */
    public function modifierGroupe( Classe $C, $operation)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C20 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C20 end

        return $returnValue;
    }

    /**
     * Short description of method comparerEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  ListeEDT
     * @param  Debut
     * @param  Fin
     * @return Boolean
     */
    public function comparerEDT($ListeEDT, $Debut, $Fin)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C25 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C25 end

        return $returnValue;
    }

    /**
     * Short description of method validerEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  EDT E
     * @return mixed
     */
    public function validerEDT( EDT $E)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C2A begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C2A end
    }

} /* end of class Secretaire */

?>