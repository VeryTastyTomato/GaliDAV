<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Classe.php');
require_once('class.Element_de_maquette.php');

class Maquette
{
	// --- ASSOCIATIONS ---
	private $listOfElemOfClassesModel = array();

	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	// constructor
	public function __construct($newListOfElemOfClassesModel)
	{
		$this->listOfElemOfClassesModel = $newListOfElemOfClassesModel;
	}

	// getters
	public function getListOfElemOfClassesModel()
	{
		return $this->listOfElemOfClassesModel;
	}

	// setters
	public function setListOfElemOfClassesModel($newListOfElemOfClassesModel)
	{
		$this->listOfElemOfClassesModel = $newListOfElemOfClassesModel;
	}

	// others
	public function addElemOfClassesModel($newElem)
	{
		if ($newElem instanceof Element_de_maquette)
		{
			$this->listOfElemOfClassesModel[] = $newElem;
		}
		else
		{
			echo 'Erreur dans la méthode addElemOfClassesModel() de la classe Maquette : l’argument donné n’est pas un élément de maquette.';
		}
	}

	public function removeElemOfClassesModel($elemToRemove)
	{
		if ($elemToRemove instanceof Element_de_maquette)
		{
			$indice = array_search($elemToRemove, $this->listOfElemOfClassesModel);
			if ($indice !== false)
			{
				unset($this->listOfElemOfClassesModel[$indice]);
			}
			else
			{
				echo 'L’élément de maquette donné n’est pas dans cette maquette.';
			}
		}
		else
		{
			echo 'Erreur dans la méthode removeElemOfClassesModel() de la classe Maquette : l’argument donné n’est pas un élément de maquette.';
		}
	}
}
?>
