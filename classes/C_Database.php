<?php
/**
 * \file    C_Database.php
 * \brief   Defines the class Database.
 * \details Allows to interact with the different database of the application.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

/* Par défaut la BDD considérée se nomme galidav accessible par l'utilisateur galidav en local */

require_once("/usr/share/davical/htdocs/always.php");
require_once("auth-functions.php"); // Utile ou pas ?

require_once("C_Person.php");
require_once("C_User.php");

class Database
{
	// --- ATTRIBUTES ---
	static private $currentDatabase = NULL;
	private        $save            = FALSE;
	private        $location        = NULL;
	private        $databaseName    = NULL;
	private        $user            = 'galidav';
	private        $password        = NULL;
	private        $host            = NULL;
	public         $sqlErrorMessage = "";

	// TODO : attributs des éléments enregistrés (1attribut != pour chaque élément ?)

	// --- OPERATIONS ---
	/**
	 * \brief Database’s constructor.
	 * \param $newUser         \e String containing the database’s user who can access the data.
	 * \param $newDatabaseName \e String containing the name of the database.
	 * \param $newPassword     \e String containing the password of the database.
	 * \param $newHost         \e ???
	*/
	public function __construct($newUser = 'galidav', Database $newDatabaseName = NULL, $newPassword = NULL, $newHost = NULL)
	{
		$this->user           = $newUser;
		$this->databaseName   = $newDatabaseName;
		$this->password       = $newPassword;
		$this->host           = $newHost;
	}

	// getters
	/**
	 * \brief  Getter for the attribute $save.
	 * \return The boolean value of $save.
	*/
	public function getSave()
	{
		return $this->save;
	}

	/**
	 * \brief  Getter for the attribute $location.
	 * \return The value of $location.
	*/
	public function getLocation()
	{
		return $this->location;
	}

	// setters
	/**
	 * \brief Setter for the attribute $save.
	 * \param $newSave Contains the new value of $save.
	*/
	public function setSave($newSave)
	{
		if (is_bool($newSave))
		{
			$this->save = $newSave;
		}
	} // p-e une méthode qui ne fait que changer la valeur du booléen ? à voir

	/**
	 * \brief Setter for the attribute $location.
	 * \param $newLocation Contains the new value of $location.
	*/
	public function setLocation($newLocation)
	{
		if (!empty($newLocation)) // ???
		{
			$this->location = $newLocation;
		}
	}

	/**
	 * \brief   Allows to get the current database.
	 * \details Static function, if there is not a current database, it initialize a new one.
	 * \return  The (possibly new) current database.
	*/
	static public function currentDB()
	{
		if (self::$currentDatabase == NULL)
		{
			self::$currentDatabase = new Database();
		}

		return self::$currentDatabase;
	}

	/**
	 * \brief  Execute the query with the given parameters.
	 * \return The result of the query.
	*/
	public function executeQuery($query, $params = NULL)
	{
		$this->sqlErrorMessage = "";
		$connection            = $this->connect();

		if (!$connection)
		{
			echo "Impossible de se connecter à la base de données " . $this->dbname . " avec le rôle " . $this->user . ".\n";

			exit;
		}

		if (is_array($params))
		{
			$result = pg_query_params($connection, $query, $params);
		}
		else
		{
			$result = pg_query_params($connection, $query, array());
		}

		if (!$result)
		{
			$this->sqlErrorMessage = "<div><b>GaliDAV Error</b>: The following query has failed: <p>&emsp;$query</p>";

			if (is_array($params))
			{
				$this->sqlErrorMessage .= "<p>(params = ";

				foreach($params as $oneParam)
				{
					$this->sqlErrorMessage .= " " . $oneParam . " /";
				}

				$this->sqlErrorMessage .= ")</p>";
			}

			$this->sqlErrorMessage .= "</div><p style = 'font-size:smaller;'><b>&emsp;&emsp;&emsp;Details on SQL</b> " . pg_last_error($connection) . "</p>";
		}

		return $result;
	}

	/**
	 * \brief Clears all data of the application databases.
	*/
	public function clear()
	{
		$oneDatabase = new Database("davical_app", "davical");

		if (!$oneDatabase->connect())
		{
			echo("Pas de connexion à davical.");
		}
		else
		{
			if (!$oneDatabase->executeQuery("DELETE FROM calendar_item;"))
			{
				$oneDatabase->showError();
			}

			if (!$oneDatabase->executeQuery("DELETE FROM collection;"))
			{
				$oneDatabase->showError();
			}

			if (!$oneDatabase->executeQuery("DELETE FROM dav_principal WHERE username != 'admin';"))
			{
				$oneDatabase->showError();
			}

			$oneDatabase->close();
		}

		$oneDatabase = new Database("agendav");

		if (!$oneDatabase->connect())
		{
			echo("Pas de connexion vers agendav.");
		}
		else
		{
			if (!$oneDatabase->executeQuery("DELETE FROM shared;"))
			{
				$oneDatabase->showError();
			}

			$oneDatabase->close();
		}

		$this->executeQuery("DELETE FROM " . Modification::TABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Course::belongsToTABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Course::TABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Subject::TABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Group::linkedToTABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Group::composedOfTABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Group::TABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Timetable::TABLENAME . ";");
		$this->executeQuery("DELETE FROM " . User::TABLENAME . ";");
		$this->executeQuery("DELETE FROM " . PersonStatus::TABLENAME . ";");
		$this->executeQuery("DELETE FROM " . Person::TABLENAME . ";");
	}

	/**
	 * \brief Deletes tables of the database.
	*/
	public function dropAll() // Note: queries’ order is important, it prevents from warnings
	{
		$this->executeQuery("DROP TABLE IF EXISTS " . Modification::TABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Course::belongsToTABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Course::TABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Subject::TABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Group::composedOfTABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Group::linkedToTABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Group::TABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Timetable::TABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . User::TABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . PersonStatus::TABLENAME . " CASCADE;");
		$this->executeQuery("DROP TABLE IF EXISTS " . Person::TABLENAME . " CASCADE;");
	}

	/**
	 * \brief  Connects to the database.
	 * \return ???
	*/
	public function connect()
	{
		$param = "user = " . $this->user;

		if ($this->databaseName)
		{
			$param .= " dbname = " . $this->databaseName;
		}

		if ($this->password)
		{
			$param .= " password = " . $this->password;
		}

		if ($this->host)
		{
			$param .= " host = " . $this->host;
		}

		return pg_pconnect($param);
	}

	/**
	 * \brief Closes the connection to the database.
	*/
	public function close()
	{
		pg_close($this->connect());
	}

	/**
	 * \brief Displays error given.
	 * \param $explanation \e String containing the message error to display.
	*/
	public function showError($explanation = NULL)
	{
		$out = "<div style = 'z-index:2;border-style:solid;background-color:#AAAAAA'>";
		$out .= $this->sqlErrorMessage;

		if (is_string($explanation))
		{
			$out .= "<p><i><b>Explanation:</b>$explanation</i></p>";
		}

		$out .= "</div>";
		echo $out;
	}

	/**
	 * \brief  Initializes the database.
	 * \return The database with required tables.
	*/
	public function initialize()
	{
		$this->clear();
		$this->dropAll();
		$result = $this->executeQuery("CREATE TABLE " . Person::TABLENAME . " (" . Person::SQLcolumns . ");");

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . User::TABLENAME . " (" . User::SQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . PersonStatus::TABLENAME . " (" . PersonStatus::SQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Timetable::TABLENAME . " (" . Timetable::SQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Group::TABLENAME . " (" . Group::SQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Group::composedOfTABLENAME . " (" . Group::composedOfSQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Group::linkedToTABLENAME . " (" . Group::linkedToSQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Subject::TABLENAME . " (" . Subject::SQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Course::TABLENAME . " (" . Course::SQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Course::belongsToTABLENAME . " (" . Course::belongsToSQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}

		if ($result)
		{
			$result = $this->executeQuery("CREATE TABLE " . Modification::TABLENAME . " (" . Modification::SQLcolumns . ");");
		}
		else
		{
			$this->showError();
		}
		/*** TODO Autres tables ***/

		return $result;
	}
}
?>
