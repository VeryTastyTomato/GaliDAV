<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Matiere.php
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
 * include Personne
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Personne.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BE1-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BE1-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BE1-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BE1-constants end

/**
 * Short description of class Matiere
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Matiere
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : intervenants

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute name
     *
     * @access private
     * @var String
     */
    private $name = null;

	public $teachedBy = null;

    // --- OPERATIONS ---

	/* getters */
	public function getName()
	{
		return $this->name;
	}

	public function getTeachedBy()
	{
		return $this->teachedBy;
	}

	/* setters */
	public function setName($newName)
	{
		if(!empty($newName))
		{
			$this->name = $newName;
		}
	}

	public function setTeachedBy($newTeachedBy)
	{
		if(!empty($newTeachedBy))
		{
			$this->name = $newTeachedBy;
		}
	}
} /* end of class Matiere */

?>
