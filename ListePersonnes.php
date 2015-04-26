<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("classes/C_Database.php");

function XListAll()
{
	$out = "<ul class = listOfPeople style = 'overflow-y:auto;height:80%;'>";
	$res = Database::currentDB()->executeQuery(query_all_people_names());

	if ($res)
	{
		$person = pg_fetch_assoc($res);

		while ($person)
		{
			// $out .= "<li>" . $person['familyname'] . " " . $person['firstname'] . "</li>";
			$out .= "<li>" . XPerson($person) . "</li>";
			$person = pg_fetch_assoc($res);
		}
	}
	else
	{
		Database::currentDB()->showError();
	}

	$out .= "</ul>";

	return $out;
}

function XListStudents()
{
	$out = "<ul class = listOfPeople style = 'overflow-y:auto;height:80%;'>";
	$res = Database::currentDB()->executeQuery(query_all_students());

	if ($res)
	{
		$person = pg_fetch_assoc($res);

		while ($person)
		{
			// $out .= "<li>" . $person['familyname'] . " " . $person['firstname'] . "</li>";
			$out .= "<li>" . XPerson($person) . "</li>";
			$person = pg_fetch_assoc($res);
		}
	}
	else
	{
		Database::currentDB()->showError();
	}

	$out .= "</ul>";

	return $out;
}

function XListTeachers()
{
	$out = "<ul class = listOfPeople style = 'overflow-y:auto;height:80%;'>";
	$res = Database::currentDB()->executeQuery(query_all_teachers());

	if($res)
	{
		$person = pg_fetch_assoc($res);

		while ($person)
		{
			// $out .= "<li>" . $person['familyname'] . " " . $person['firstname'] . "</li>";
			$out .= "<li>" . XPerson($person) . "</li>";
			$person = pg_fetch_assoc($res);
		}
	}
	else
	{
		Database::currentDB()->showError();
	}

	$out .= "</ul>";

	return $out;
}

function XListAllGroups()
{
	$out = "<ul class = listOfGroup style = 'overflow-y:auto;height:80%;'>";
	$res = Database::currentDB()->executeQuery(query_all_groups());

	if($res)
	{
		$group = pg_fetch_assoc($res);

		while ($group)
		{
			// $out .= "<li>" . $person['familyname'] . " " . $person['firstname'] . "</li>";
			$out .= "<li>" . XGroup($group) . "</li>";
			$group = pg_fetch_assoc($res);
		}
	}
	else
	{
		Database::currentDB()->showError();
	}

	$out .= "</ul>";

	return $out;
}

function XoptionSpeakers()
{
	// $out = "<datalist class = optionOfPeople id = listspeakers'>";
	$out = "<option>--";
	$res = Database::currentDB()->executeQuery(query_all_speakers());
	$person = pg_fetch_assoc($res);

	while ($person != NULL)
	{
		// $out .= "<option value='" . $person['familyname'] . " " . $person['firstname'] . "'>";
		$out .= "<option>" . $person['familyname'] . " " . $person['firstname'];
	}

	// $out .= "</datalist>";

	return $out;
}

function XoptionGroups()
{
	// $out = "<datalist class = optionOfGroup id = listgroups'>";
	$out = "";
	$res = Database::currentDB()->executeQuery(query_all_groups());
	$group = pg_fetch_assoc($res);

	while ($group != NULL)
	{
		// $out .= "<option value='" . $person['familyname'] . " " . $person['firstname'] . "'>";
		$out .= "<option>" . $group['name'];
	}

	//$out .= "</datalist>";

	return $out;
}

function XPerson($ressource)
{
	if (is_array($ressource))
	{
		$out = "";
		$out .= "<form action = 'test_davical_operations.php' method = 'POST'>" . $ressource['familyname'] . " " . $ressource['firstname'];
		$out .= "<input type = 'hidden' name = 'action' value = 'delete_person' /><input type = 'hidden' name = 'id' value = " . $ressource['id'] . " /><input type = 'submit' value = 'Supprimer' /></form>";

		return $out;	
	}
}

function XGroup($ressource)
{
	if (is_array($ressource))
	{
		$out = "";
		$out .= "<form action = 'test_davical_operations.php' method = 'POST'>" . $ressource['name'];
		$out .= "<input type = 'hidden' name = 'action' value = 'delete_group' /><input type = 'hidden' name = 'id' value = " . $ressource['id'] . " /><input type = 'submit' value = 'Supprimer' /></form>";

		return $out;
	}
}

function query_all_people()
{
	return "SELECT * FROM " . Person::TABLENAME . " ORDER BY familyName;";
}

function query_all_people_names()
{
	return "SELECT id, familyname, firstname FROM " . Person::TABLENAME . ";";
}

function query_all_students()
{
	return "SELECT * FROM " . Person::TABLENAME . " AS P WHERE EXISTS(SELECT * FROM " . PersonStatus::TABLENAME . " AS S WHERE S.id_person = P.id AND S.status = 1) ORDER BY familyName;";
}

function query_all_teachers()
{
	return "SELECT * FROM " . Person::TABLENAME . " AS P WHERE EXISTS(SELECT * FROM " . PersonStatus::TABLENAME . " AS S WHERE S.id_person = P.id AND S.status = 3) ORDER BY familyName;";
}

function query_all_speakers()
{
	return "SELECT * FROM " . Person::TABLENAME . " AS P WHERE EXISTS(SELECT * FROM " . PersonStatus::TABLENAME . " AS S WHERE S.id_person = P.id AND S.status IN (2,3)) ORDER BY familyName;";
}

function query_all_groups()
{
	return "SELECT * FROM " . Group::TABLENAME . " ORDER BY name;";
}

function query_one_group($idOrName)
{
	if (is_string($idOrName))
	{
		return "SELECT * FROM " . Group::TABLENAME . " WHERE NAME = '" . pg_escape_string($idOrName) . "';";
	}
	else if (is_int($idOrName))
	{
		return "SELECT * FROM " . Group::TABLENAME . " WHERE id = $idOrName;";
	}
}

function query_person_by_fullname($fullname)
{
	return "SELECT * FROM " . Person::TABLENAME . " WHERE familyname || ' ' || firstname = '" . pg_escape_string($fullname) . "';";
}
?>
