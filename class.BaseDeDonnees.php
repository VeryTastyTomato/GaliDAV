<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('$this file was generated for PHP 5');
}

/* Par défaut la BDD considérée se nomme galidav accessible par l'utilisateur galidav en local */

require_once("/usr/share/davical/htdocs/always.php");
require_once("auth-functions.php");	//Utile ou pas?

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
	private $dbname=null;
	private $user='galidav';
	private $password=null;
	private $host=null;
	// TODO : attributs des éléments enregistrés (1attribut != pour chaque élément ?)

	// --- OPERATIONS ---
	//getters

	public function __construct($user='galidav',$dbname=null,$password=null,$host=null)
	{
		$this->user=$user;
		$this->dbname=$dbname;
		$this->password=$password;
		$this->host=$host;
	}
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
		if(self::$current_db==null)
		{
			self::$current_db=new BaseDeDonnees();
			
		}
		return self::$current_db;
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
	
	
	public function executeQuery($query,$params=array())
	{
		$conn=$this->connect();
		if (!$conn) {
  			echo "Impossible de se connecter à la DB ".$this->dbname." avec le rôle ".$this->user." \n";
  			exit;
		}
		$result = pg_query_params($conn, $query, $params);
		return $result;          
	}
	
	public function clear()
	{
		//TODO: clear aussi la DB de davical cad tous les comptes sauf admin
		$this->executeQuery("DELETE from ".Utilisateur::TABLENAME.";");
		$this->executeQuery("DELETE from ".Statut_personne::TABLENAME.";");
		$this->executeQuery("DELETE from ".Personne::TABLENAME.";");
		
		
	}
	public function dropall()//KFK: NOTICE: L'ordre est important, on évite des warnings
	{
		$this->executeQuery("DROP TABLE IF EXISTS ".Utilisateur::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Statut_personne::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Personne::TABLENAME." CASCADE;");
		
		
	}
	
	public function connect()
	{
		$param="user=".$this->user;
		if($this->dbname)$param.=" dbname=".$this->dbname;
		if($this->password)$param.=" password=".$this->password;
		if($this->host)$param.=" host=".$this->host;
		return pg_pconnect($param);
	}
	
	public function close(){
		pg_close($this->connect());
	}
	public function initialize()
	{
		$result=$this->executeQuery("CREATE TABLE ".Personne::TABLENAME." (".Personne::SQLcolumns.");");
		if($result)$result=$this->executeQuery("CREATE TABLE ".Utilisateur::TABLENAME." (".Utilisateur::SQLcolumns.");");
		if($result)$result=$this->executeQuery("CREATE TABLE ".Statut_personne::TABLENAME." (".Statut_personne::SQLcolumns.");");
		/*** TODO Autres tables ***/
		
		return $result;
	}

}
?>


