<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was generated for PHP 5');
}

/* TODO quand on aura réglé les attributs dépendants
require_once('');
*/
class BaseDeDonnees
{
	// --- ASSOCIATIONS ---


	// --- ATTRIBUTES ---
	private $save = false;
	private $location = null;
	// TODO : attributs des éléments enregistrés (1attribut != pour chaque élément ?)

	// --- OPERATIONS ---
	//getters

	public function getSave()
	{
		return $this->save;
	}

	public function getLocation()
	{
		return $this->location;
	}

	//setters

	public function setSave($newSave)
	{
		if (!empty($newSave))
		{
			$this->save = $newSave;
		}
	}//p-e une méthode qui ne fait que changer la valeur du booléen ? à voir

	public function setLocation($newLocation)
	{
		if (!empty($newLocation))
		{
			$this->location = $newLocation;
		}
	}	

}
?>
