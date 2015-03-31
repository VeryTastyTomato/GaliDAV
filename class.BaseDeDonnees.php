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
	
	
	public function executeQuery($query,$params=array()){
		$conn=$this->connect();
		if (!$conn) {
  			echo "Impossible de se connecter à la DB galidav.\n";
  			exit;
		}
		$result = pg_query_params($conn, $query, $params);
		return $result;
		/*$Q=new AwlQuery( $query, $params );
		$connection=array();
		$connection['dsn']='galidav';
		$connection['dbuser']='galidav';
		$Q->SetConnection($connection);
		if ( $Q->Exec() ) {
            $c->messages[] = i18n('GaliDAV query answered.');
            dbg_error_log("GaliDAV",": ? : SQL Operation done" );
          }
          else {
          	echo("GaliDAV SQL error: ".$Q->getErrorInfo());
            $c->messages[] = i18n("There was an error reading/writing to the GaliDAV database.");
          }*/
          
	}
	
	public function clear(){
		$this->executeQuery("DELETE from ".Personne::TABLENAME." where true;");
		$this->executeQuery("DELETE from ".Utilisateur::TABLENAME." where true;");
	}
	public function dropall(){
		$this->executeQuery("DROP TABLE ".Personne::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE ".Utilisateur::TABLENAME." CASCADE;");
	}
	
	public function connect()
	{
		$param="user=".$this->user;
		if($this->dbname)$param.=", dbname=".$this->dbname;
		if($this->password)$param.=", password=".$this->password;
		if($this->host)$param.=", host=".$this->host;
		return pg_pconnect($param);
	}
	
	public function initialize()
	{
		$result=$this->executeQuery("CREATE TABLE ".Personne::TABLENAME." (".Personne::SQLcolumns.");");
		if($result)$result=$this->executeQuery("CREATE TABLE ".Utilisateur::TABLENAME." (".Utilisateur::SQLcolumns.");");
		
		/*** TODO Autres tables ***/
		
		return $result;
	}

}
?>


