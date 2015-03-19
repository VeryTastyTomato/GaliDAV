<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Groupe.php
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
 * include Classe
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Classe.php');

/**
 * include EDT
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.EDT.php');

/**
 * include Personne
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Personne.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD5-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD5-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD5-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BD5-constants end

/**
 * Short description of class Groupe
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Groupe
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : ListeEtudiants    // generateAssociationEnd :     // generateAssociationEnd : 

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute name
     *
     * @access private
     * @var String
     */
    private $name = null;

    /**
     * Short description of attribute isAClass
     *
     * @access private
     * @var Boolean
     */
<<<<<<< HEAD
    public $EstUneClasse = false;
=======
    private $isAClass = null;
>>>>>>> 72f55a4e51348a33da9a43145f56ca8890c7ff3f

    // --- OPERATIONS ---

	/* getters */
	public function getName()
	{
		return $this->name;
	}

	public function getIsAClass()
	{
		return $this->isAClass;
	}

	/* setters */
	public function setName($newName)
	{
		if(!empty($newName))
		{
			$this->name = $newName;
		}
	}

	public function setIsAClass($newIsAClass)
	{
		if(!empty($newIsAClass))
		{
			$this->isAClass = $newIsAClass;
		}
	}

    /**
     * Short description of method getEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return EDT
     */
    public function getEDT()
    {
        $returnValue = null;

        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BDD begin
        // section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BDD end

        return $returnValue;
    }

} /* end of class Groupe */

?>
