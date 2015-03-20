<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Cours.php
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
 * include Cours_Type_cours
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('Cours/unknown.Type_cours.php');

/**
 * include EDT
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.EDT.php');

/**
 * include Matiere
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Matiere.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000C34-constants end

/**
 * Short description of class Cours
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Cours
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : listeEDTs    // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd : 

    // --- ATTRIBUTES ---
    /**
     * Short description of attribute Numero
     *
     * @access public
     * @var Integer
     */
    public $number = null;

    /**
     * Short description of attribute Début
     *
     * @access public
     */
    public $begin[ null | null | null ];

    /**
     * Short description of attribute Fin
     *
     * @access public
     */
    public $end[ null | null | null ];

    /**
     * Short description of attribute Salle
     *
     * @access public
     * @var String
     */
    public $room = null;

	public $typeCours = null;

	public $subject = null; //Etienne : la matière a sa place dans les attributs non ?

    // --- OPERATIONS ---

	//getters

	public function getNumber()
	{
		return $this->number;
	}

	public function getBegin()
	{
		return $this->begin;
	}

	public function getEnd()
	{
		return $this->end;
	}
	
	public function getRoom()
	{
		return $this->room;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	//setters

	public function setNumber($newNumber)
	{
		if(!empty($newNumber))
		{
			$this->number = $newNumber;
		}
	}

	public function setBegin($newBegin)
	{
		if(!empty($newBegin))
		{
			$this->begin = $newBegin;
		}
	}

	public function setEnd($newEnd)
	{
		if(!empty($newEnd))
		{
			$this->end = $newEnd;
		}
	}

	public function setRoom($newRoom)
	{
		if(!empty($newRoom))
		{
			$this->room = $newRoom;
		}
	}

	public function setSubject($newSubject)
	{
		if(!empty($newSubject))
		{
			$this->subject = $newSubject;
		}
	}

    /**
     * Short description of method retirer
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @return mixed
     */
    public function retire()
    {
	//Etienne : accès à la BDD pour la delete ?

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C04 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C04 end
    }

    /**
     * Short description of method modifierSalle
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  String S
     * @return mixed
     */
    public function modifyRoom( String $S)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C06 begin

	if(!empty($S))
		{
			$this->room = $S;
		}
	//Etienne : c'est une sorte de setteur ça...
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C06 end
    }

    /**
     * Short description of method Cours
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Matiere M
     * @param  Debut
     * @param  Fin
     * @return mixed
     */
    public function Cours( Matiere $M, $Debut, $Fin)
    {
	// Etienne : c'est un constructeur ça ?

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C09 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C09 end
    }

    /**
     * Short description of method integrerDansEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  EDT E
     * @return mixed
     */
    public function integrerDansEDT( EDT $E)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C0E begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C0E end
    }

} /* end of class Cours */

?>
