<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Modification.php
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
 * include Utilisateur
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Utilisateur.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000CD7-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000CD7-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000CD7-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000CD7-constants end

/**
 * Short description of class Modification
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Modification
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd : 

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute Date
     *
     * @access protected
     */
    protected $date[ null | null | null ];

	//Etienne : un attribut pour connaître l'auteur de la modif
	protected $madeBy = null;

    // --- OPERATIONS ---

	//getters
	public function getDate()
	{
		return $this->date;
	}

	public function getMadeBy()
	{
		return $this->madeBy;
	}

	//setters
	public function setDate($newDate)
	{
		if(!empty($newDate))
		{
			$this->date = $newDate;
		}
	}

	public function setMadeBy($newMadeBy)
	{
		if(!empty($newMadeBy))
		{
			$this->madeBy = $newMadeBy;
		}
	}
} /* end of class Modification */

?>
