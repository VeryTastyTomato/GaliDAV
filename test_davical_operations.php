<?php
/**
 * \file  test_davical_operations.php
 * \brief Contains all the operations on DAViCal’s database.
*/
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Flora NOTE: vous devez écrire dans votre hote.conf la ligne
// php_value include_path /usr/share/davical/inc:/usr/share/awl/inc

require_once("/usr/share/davical/htdocs/always.php");
require_once("auth-functions.php");
require_once("DAVPrincipal.php");
require_once("classes/C_Secretary.php");
require_once("classes/C_Teacher.php");
require_once("classes/C_Administrator.php");
require_once("classes/C_Head.php");
require_once("ListePersonnes.php");

// Créer un calendrier de nom, $calendarNameGiven pour l'utilisateur d'identifiant $username

function CreateCalendar($userName, $calendarNameGiven, $default_timezone = NULL)
{
	global $session, $c;

	if (!isset($c->default_collections))
	{
		$c->default_collections = array();
	}

	$principal           = new Principal('username', $userName);
	$userFullName        = $principal->fullname; // user fullname
	$userReverseFullName = implode(' ', array_reverse(explode(' ', $principal->fullname))); // user fullname in reverse order
	$sqlQuery            = 'INSERT INTO collection (user_no, parent_container, dav_name, dav_etag, dav_displayname, is_calendar, is_addressbook, default_privileges, created, modified, resourcetypes) ';
	$sqlQuery           .= 'VALUES( :user_no, :parent_container, :collection_path, :dav_etag, :displayname, :is_calendar, :is_addressbook, :privileges::BIT(24), current_timestamp, current_timestamp, :resourcetypes );';
	// foreach ($c->default_collections as $v) {}

	if (FALSE)
	{
		/* if (!empty($v['name']))
		{
			$awlQuery = new AwlQuery('SELECT 1 FROM collection WHERE dav_name = :dav_name', array(':dav_name' => $principal->dav_name().$v['name'].'/'));
		}

		if (!$awlQuery->Exec())
		{
			$c->messages[] = i18n('There was an error reading from the database.');
			return FALSE;
		}

		if ($awlQuery->rows() > 0)
		{
			$c->messages[] = i18n('Home ' . $calendarGivenName . ' already exists.');
			return TRUE;
		}
		*/
	}
	else
	{
		$params[':user_no']          = $principal->user_no();
		$params[':parent_container'] = $principal->dav_name();
		$params[':dav_etag']         = '-1';
		$params[':collection_path']  = $principal->dav_name() . $calendarNameGiven . '/';
		// $params[':displayname'] = $userFullName . " " . $calendarNameGiven;
		$params[':displayname']      = $calendarNameGiven;
		$params[':resourcetypes']    = '<DAV::collection/><urn:ietf:params:xml:ns:caldav:calendar/>';
		$params[':is_calendar']      = TRUE;
		$params[':is_addressbook']   = FALSE;
		$params[':privileges']       = NULL;
		$awlQuery                    = new AwlQuery($sqlQuery, $params);

		if ($awlQuery->Exec())
		{
			$c->messages[] = i18n('Calendar added.');
			dbg_error_log("User", ":Write: Created user's calendar at '%s'", $params[':collection_path']);
			$DB     = new Database("davical_app", "davical");
			$result = $DB->executeQuery("SELECT collection_id FROM collection ORDER BY created DESC;");

			if ($result)
			{
				$result = pg_fetch_assoc($result);
				return $result['collection_id'];
			}
			else
			{
				$DB->showError("ligne n° " . __LINE__ . " //fonction : " . __FUNCTION__);

				return FALSE;
			}
		}
		else
		{
			$c->messages[] = i18n('There was an error writing to the database.');

			return FALSE;
		}
	}

	return TRUE;
}

function getDAVPrincipalNoFromLogin($login)
{
	$DB     = new Database("davical_app", "davical");
	$query  = "SELECT user_no FROM dav_principal WHERE username = '" . pg_escape_string($login) . "';";
	$result = $DB->executeQuery($query);

	if (!$result)
	{
		$BDD->showError("ligne n° " . __LINE__ . " //fonction : " . __FUNCTION__);

		return FALSE;
	}
	else
	{
		$result = pg_fetch_assoc($result);

		return ((int) $result['user_no']);
	}
}

function CreateUserAccount($userName, $fullName, $password, $email = NULL,  $privileges = NULL)
{
	$param['username']    = $userName;
	$param['fullname']    = $fullName;
	$param['displayname'] = $fullName;
	$param['password']    = $password;
	$param['email']       = $email;
	$param['type_id']     = 1; // type Person
	// $param['default_privileges'] = privilege_to_bits(array('all')) ; // ne compile pas
	$aPerson                    = new DAVPrincipal($param);
	$aPerson->password          = $password; // ne marche pas
	$aPerson->privileges        = $privileges; // ne marche pas
	$aPerson->Create($param);

	if ($privileges)
	{
		$DB        = new Database("davical_app", "davical");
		$params2[] = privilege_to_bits($privileges);
		$params2[] = $userName;
		$query     = "UPDATE dav_principal SET default_privileges = $1 WHERE username = $2;";
		$result    = $DB->executeQuery($query, $params2);
		$DB->close();

		if (!$result)
		{
			$DB->showError();
		}
	}

	return $aPerson;
}

function CreateGroupAccount($className, $password, $email = NULL, $privilege = NULL) // pour l'instant le mot de passe n'est pas utile, on n'est pas censé se connecter en tant que class
{
	$param['username']    = $className;
	$param['fullname']    = $className;
	$param['displayname'] = $className;
	$param['password']    = $password; // ne marche pas
	$param['email']       = $email;
	$param['type_id']     = 3; // type Groupe;
	$aClass               = new DAVPrincipal($param);
	$aClass->Create($param);

	return $aClass;
}

if (isset($_POST['action']))
{
	if ($_POST['action'] == 'add_subject')
	{
		$aGroup = new Group();

		if ($aGroup->loadFromDB($_POST['groupname']))
		{
			$aSubject = new Subject($_POST['subjectname'], $aGroup);

			if ($_POST['speaker1'] != "--")
			{
				$res = Database::currentDB()->executeQuery(query_person_by_fullname($_POST['speaker1']));

				if($res)
				{
					$result = pg_fetch_assoc($res);
					$aPerson = new Person();
					$aPerson->loadFromDB($result['id']);
					$aSubject->addTeacher($aPerson);
				}
				else
				{
					Database::currentDB()->showError();
				}
			}

			if ($_POST['speaker2'] != "--")
			{
				$res = Database::currentDB()->executeQuery(query_person_by_fullname($_POST['speaker2']));

				if ($res)
				{
					$result = pg_fetch_assoc($res);
					$aPerson = new Person();
					$aPerson->loadFromDB($result['id']);
					$aSubject->addTeacher($aPerson);
				}
				else
				{
					Database::currentDB()->showError();
				}
			}

			if ($_POST['speaker3'] != "--")
			{
				$res = Database::currentDB()->executeQuery(query_person_by_fullname($_POST['speaker3']));

				if ($res)
				{
					$result = pg_fetch_assoc($res);
					$aPerson = new Person();
					$aPerson->loadFromDB($result['id']);
					$subject->addTeacher($aPerson);
				}
				else
				{
					Database::currentDB()->showError();
				}
			}
		}

		header('Location: ./admin_panel2.php');
		die;
	}

	if ($_POST['action'] == 'add_user')
	{
		if ($_POST['password'] != $_POST['password2'])
		{
			header('Location: ./admin_panel2.php?GMESSAGE_ERROR=DIFFERENT_PASS');
			die;
		}
		else
		{
			if ($_POST['status'] == 'secretary')
			{
				$aUser = new Secretary($_POST['familyname'], $_POST['firstname'], $_POST['login'], $_POST['password'], $_POST['email']);
			}
			else if ($_POST['status'] == 'teacher')
			{
				$aUser = new Teacher($_POST['familyname'], $_POST['firstname'], $_POST['login'], $_POST['password'], $_POST['email']);
			}
			else if ($_POST['status'] == 'head')
			{
				$aUser = new Head($_POST['familyname'], $_POST['firstname'], $_POST['login'], $_POST['password'], $_POST['email']);
			}
			else if ($_POST['status'] == 'administrator')
			{
				$aUser = new Administrator($_POST['familyname'], $_POST['firstname'], $_POST['login'], $_POST['password'], $_POST['email']);
			}

			echo($aUser->toHTML());
			header('Location: ./admin_panel2.php');
			die;
		}
	}

	if ($_POST['action'] == 'add_group')
	{
		$aGroup = new Group($_POST['name'], $_POST['isaclass']);
		// header('Location: ./admin_panel.php');
	}

	if ($_POST['action'] == 'add_person')
	{
		$aPerson = new Person($_POST['familyname'], $_POST['firstname'], $_POST['email']);

		if ($_POST['status'] == 'student')
		{
			$aPerson->addStatus(new PersonStatus(PersonStatus::STUDENT));
		}
		else if ($_POST['status'] == 'speaker')
		{
			$aPerson->addStatus(new PersonStatus(PersonStatus::SPEAKER));
		}

		echo($aPerson->toHTML());
		header('Location: ./admin_panel2.php');
		die;
	}

	if ($_POST['action'] == 'delete_person')
	{
		$aPerson = new Person();
		$aPerson->loadFromDB(intval($_POST['id']));
		$aPerson->removeFromDB();
		header('Location: ./admin_panel2.php');
		die;
	}

	if ($_POST['action'] == 'clear_db')
	{
		Database::currentDB()->clear();
		header('Location: ./admin_panel2.php');
		die;
	}

	if ($_POST['action'] == 'init_db')
	{
		Database::currentDB()->initialize();
		header('Location: ./admin_panel2.php');
		die;
	}

	if ($_POST['action'] == 'delete_group')
	{
		$aGroup = new Group();

		if (!$aGroup->loadFromDB(intval($_POST['id'])))
		{
			die('Group not found');
		}
		else
		{
			echo("G id/name= " . $aGroup->getSqlId() . " / " . $aGroup->getName());
		}

		$aGroup->removeFromDB();
		header('Location: ./admin_panel2.php');
		die;
	}

	if ($_POST['action'] == 'modify_group')
	{
		$aGroup = new Group();

		if (!$aGroup->loadFromDB(intval($_POST['id'])))
		{
			die('Error: Group' . $_POST['id'] . 'not found.');
		}
		else
		{
			echo("G id/name = " . $aGroup->getSqlId() . " / " . $aGroup->getName());
		}
	}
}
?>
