<?php
/**
 * \file    C_ClassesModel.php
 * \brief   Defines the class ClassesModel.
 * \details Represents a class’ model.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

require_once('C_Class.php');
require_once('C_ElemOfClassesModel.php');

class ClassesModel
{
	// --- ATTRIBUTES ---
	private $elemOfClassesModelsList = array();

	// --- OPERATIONS ---
	/**
	 * \brief ClassesModel’s constructor
	 * \param $newElemOfClassesModelsList The list of elements which will composed the class’ model.
	*/
	public function __construct($newElemOfClassesModelsList)
	{
		$this->elemOfClassesModelsList = $newElemOfClassesModelsList;
	}

	// getters
	/**
	 * \brief  Getter for the attribute $elemOfClassesModelsList.
	 * \return The value of $elemOfClassesModelsList.
	*/
	public function getElemOfClassesModelsList()
	{
		return $this->elemOfClassesModelsList;
	}

	// setters
	/**
	 * \brief  Setter for the attribute $elemOfClassesModelsList.
	 * \param  $newElemOfClassesModelsList Contains the new value of $elemOfClassesModelsList.
	*/
	public function setElemOfClassesModelsList($newElemOfClassesModelsList)
	{
		$this->elemOfClassesModelsList = $newElemOfClassesModelsList;
	}

	// others
	/**
	 * \brief Adds an element of class’ model.
	 * \param $newElem The element to add.
	*/
	public function addElemOfClassesModel($newElem)
	{
		if ($newElem instanceof ElemOfClassesModel)
		{
			$this->elemOfClassesModelsList[] = $newElem;
		}
		else
		{
			echo 'Erreur dans la méthode addElemOfClassesModel() de la classe ClassesModel : l’argument donné n’est pas un élément de maquette.';
		}
	}

	/**
	 * \brief Removes an element of class’ model.
	 * \param $elemToRemove The element to remove.
	*/
	public function removeElemOfClassesModel($elemToRemove)
	{
		if ($elemToRemove instanceof ElemOfClassesModel)
		{
			$index = array_search($elemToRemove, $this->elemOfClassesModelsList);

			if ($index !== FALSE)
			{
				unset($this->elemOfClassesModelsList[$index]);
			}
			else
			{
				echo 'L’élément de maquette donné n’est pas dans cette maquette.';
			}
		}
		else
		{
			echo 'Erreur dans la méthode removeElemOfClassesModel() de la classe ClassesModel : l’argument donné n’est pas un élément de maquette.';
		}
	}
}
?>
