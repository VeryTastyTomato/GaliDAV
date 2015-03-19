<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Element_de_maquette.php
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
 * include Cours_Type_cours
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('Cours/unknown.Type_cours.php');

/**
 * include Maquette
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Maquette.php');

/**
 * include Matiere
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Matiere.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C79-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C79-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C79-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C79-constants end

/**
 * Short description of class Element_de_maquette
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Element_de_maquette
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd : 

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute typeOfCourse
     *
     * @access private
     * @var Type_Course
     */
    private $typeOfCourse = null;

    /**
     * Short description of attribute numHours
     *
     * @access private
     * @var Integer
     */
    private $numHours = null;

    // --- OPERATIONS ---

	/* getters */
	public function getTypeOfCourse()
	{
		return $this->typeOfCourse;
	}

	public function getNumHours()
	{
		return $this->numHours;
	}

	/* setters */
	public function setTypeofCourse($newTypeOfCourse)
	{
		if(!empty($newTypeOfCourse))
		{
			$this->typeOfCourse = $newTypeOfCourse;
		}
	}

	public function setNumHours($newNumHours)
	{
		if(!empty($newNumHours))
		{
			$this->numHours = $newNumHours;
		}
	}
} /* end of class Element_de_maquette */

?>
