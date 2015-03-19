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
	private static $person_types = array(
		"Administrateur"=>0,			
		"Secretaire"=>1,
		"Responsable"=>2,
		"Enseignant"=>3
	);
				
	public $person_type;
    /**
     * Short description of attribute familyName
     *
     * @access private
     * @var String
     */
    private $familyName = null;

    /**
     * Short description of attribute firstName
     *
     * @access private
     * @var String
     */
    private $firstName = null;

    /**
     * Short description of attribute emailAddress1
     *
     * @access private
     * @var String
     */
    private $emailAddress1 = null;

    /**
     * Short description of attribute emailAddress2
     *
     * @access private
     * @var String
     */
    private $emailAddress2 = null;

    // --- OPERATIONS ---

    /* getters */
	public function getFamilyName()
	{
		return $this->familyName;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function getEmailAddress1()
	{
		return $this->emailAddress1;
	}

	public function getEmailAddress2()
	{
		return $this->emailAddress2;
	}

	/* setters */
	public function setFamilyName($newFamilyName)
	{
		if (!empty($newFamilyName))
		{
			$this->familyName = $newFamilyName;
		}
	}

	public function setFirstName($newFirstName)
	{
		if (!empty($newFirstName))
		{
			$this->firstName = $newFirstName;
		}
	}

	public function setEmailAddress1($newEmailAddress1)
	{
		//  todo: add a regular expression to check the parameter’s pattern
		if (!empty($newEmailAddress1))
		{
			$this->emailAddress1 = $newEmailAddress1;
		}
	}

	public function setEmailAddress2($newEmailAddress2)
	{
		//  todo: add a regular expression to check the parameter’s pattern
		if (!empty($newEmailAddress2))
		{
			$this->emailAddress2 = $newEmailAddress2;
		}
	}
} /* end of class Personne */

?>
