<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was generated for PHP 5');
}

require_once("/usr/share/davical/htdocs/always.php");

/* TODO quand on aura réglé les attributs dépendants
require_once('');

*/
require_once("class.Personne.php");
require_once("class.Utilisateur.php");
class BaseDeDonnees
{
	// --- ASSOCIATIONS ---

	
	// --- ATTRIBUTES ---
	static private $current_db=null;
	
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
	
	static public function currentDB()
	{
		if(self::current_db==null)self::current_db=new BaseDeDonnees();
		self::current_db->initialize();
		return self::current_db;
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
	
	public function executeQuery($query,$params=null){
		global $c;
		$Q=new AwlQuery( $query, $params );
		if ( $Q->Exec() ) {
            $c->messages[] = i18n('GaliDAV query answered.');
            dbg_error_log("GaliDAV",": ? : SQL Operation done" );
          }
          else {
            $c->messages[] = i18n("There was an error reading/writing to the GaliDAV database.");
          }
          return $Q;
	}
	
	public function initialize()
	{
		$result=$this->executeQuery("CREATE TABLE ".Personne::TABLENAME."(".Personne::SQLcolumns.";");
		if($result->Exec())$result=$this->executeQuery("CREATE TABLE ".Utilisateur::TABLENAME."(".Utilisateur::SQLcolumns.";");
		
		/*** TODO Autres tables ***/
		
		return $result->Exec();
	}

}
?>
