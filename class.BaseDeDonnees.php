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
	static private $current_db = null;

	private $save = false;
	private $location = null;
	private $dbname = null;
	private $user = 'galidav';
	private $password = null;
	private $host = null;
	public $error_sql_message ="";
	// TODO : attributs des éléments enregistrés (1attribut != pour chaque élément ?)

	// --- OPERATIONS ---
	// builder
	public function __construct($user = 'galidav', $dbname = null,$password = null,$host = null)
	{
		$this->user = $user;
		$this->dbname = $dbname;
		$this->password = $password;
		$this->host = $host;
	}

	// getters
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
		if(self::$current_db == null)
		{
			self::$current_db = new BaseDeDonnees();
		}

		return self::$current_db;
	}

	// setters

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

	public function executeQuery($query, $params = array())
	{
		$this->error_sql_message="";
		$conn = $this->connect();
		if (!$conn)
		{
			echo "Impossible de se connecter à la DB ".$this->dbname." avec le rôle ".$this->user." \n";
			exit;
		}

		$result = pg_query_params($conn, $query, $params);
		if(!$result)$this->error_sql_message="<div style='z-index:2;border-style:solid;'><p><b>GaliDAV Error</b>: The following query has failed: <br/>&emsp;$query<br/>(".var_dump($params).")</p><p><b>&emsp;&emsp;&emsp;Details on SQL</b> ".pg_last_error($conn)."</p></div>";
		return $result;
	}

	public function clear()
	{
		//TODO: clear aussi la DB de davical cad tous les comptes sauf admin, toutes les collectionx et item_collection
		$this->executeQuery("DELETE from ".Modification::TABLENAME.";");
		$this->executeQuery("DELETE from ".Cours::belongsToTABLENAME.";");
		$this->executeQuery("DELETE from ".Cours::TABLENAME.";");
		$this->executeQuery("DELETE from ".Matiere::TABLENAME.";");
		$this->executeQuery("DELETE from ".Groupe::linkedToTABLENAME.";");
		$this->executeQuery("DELETE from ".Groupe::composedOfTABLENAME.";");
		$this->executeQuery("DELETE from ".Groupe::TABLENAME.";");
		$this->executeQuery("DELETE from ".EDT::TABLENAME.";");
		$this->executeQuery("DELETE from ".Utilisateur::TABLENAME.";");
		$this->executeQuery("DELETE from ".Statut_personne::TABLENAME.";");
		$this->executeQuery("DELETE from ".Personne::TABLENAME.";");
	}

	public function dropAll()//KFK: NOTICE: L'ordre est important, on évite des warnings
	{	
		$this->executeQuery("DROP TABLE IF EXISTS ".Modification::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Cours::belongsToTABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Cours::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Matiere::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Groupe::composedOfTABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Groupe::linkedToTABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Groupe::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".EDT::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Utilisateur::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Statut_personne::TABLENAME." CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS ".Personne::TABLENAME." CASCADE;");
	}

	public function connect()
	{
		$param = "user=".$this->user;
		if ($this->dbname)
		{
			$param.=" dbname=".$this->dbname;
		}

		if ($this->password)
		{
			$param.=" password=".$this->password;
		}

		if ($this->host)
		{
			$param.=" host=".$this->host;
		}

		return pg_pconnect($param);
	}

	public function close()
	{
		pg_close($this->connect());
	}

	public function show_error(){
		echo $this->error_sql_message;
	}
	public function initialize()
	{
		$result = $this->executeQuery("CREATE TABLE ".Personne::TABLENAME." (".Personne::SQLcolumns.");");
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Utilisateur::TABLENAME." (".Utilisateur::SQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Statut_personne::TABLENAME." (".Statut_personne::SQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".EDT::TABLENAME." (".EDT::SQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Groupe::TABLENAME." (".Groupe::SQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Groupe::composedOfTABLENAME." (".Groupe::composedOfSQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Groupe::linkedToTABLENAME." (".Groupe::linkedToSQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Matiere::TABLENAME." (".Matiere::SQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Cours::TABLENAME." (".Cours::SQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Cours::belongsToTABLENAME." (".Cours::belongsToSQLcolumns.");");
		}else $this->show_error();
		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE ".Modification::TABLENAME." (".Modification::SQLcolumns.");");
		}else $this->show_error();
		/*** TODO Autres tables ***/

		return $result;
	}
}
?>
