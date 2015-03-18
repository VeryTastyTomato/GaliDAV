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

    /**
     * Short description of method ajouterUtilisateur
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return Utilisateur
     */
    public function ajouterUtilisateur()
    {
        $returnValue = null;

        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BFD begin
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BFD end

        return $returnValue;
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
        $returnValue = null;

        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C00 begin
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C00 end

        return $returnValue;
    }

    /**
     * Short description of method ajouterUtilisateurCAS
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return Utilisateur
     */
    public function ajouterUtilisateurCAS()
    {
        $returnValue = null;

        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C03 begin
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C03 end

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
    public function changerStatutUtilisateur( Utilisateur $U)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BC2 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BC2 end
    }

    /**
     * Short description of method supprimerUtilisateur
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Utilisateur U
     * @return Personne
     */
    public function supprimerUtilisateur( Utilisateur $U)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BC5 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BC5 end

        return $returnValue;
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
        $returnValue = null;

        // section 127-0-1-1-156e4f1e:14c2db648ab:-8000:0000000000000BE1 begin
        // section 127-0-1-1-156e4f1e:14c2db648ab:-8000:0000000000000BE1 end

        return $returnValue;
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
    public function modifierClasse( Classe $C, $operation)
    {
        // section 127-0-1-1-156e4f1e:14c2db648ab:-8000:0000000000000BE3 begin
        // section 127-0-1-1-156e4f1e:14c2db648ab:-8000:0000000000000BE3 end
    }

} /* end of class Administrateur */

?>