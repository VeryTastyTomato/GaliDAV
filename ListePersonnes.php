<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
require_once("class.BaseDeDonnees.php");

function XListAll(){
	$out="<ul class=listOfPeople style='overflow:scroll;'>";
		$res=BaseDeDonnees::currentDB()->executeQuery(query_all_people());
		while(($person=pg_fetch_assoc($res))!=null)
		{
			//$out.="<li>".$person['familyname']." ".$person['firstname']."</li>";
			$out.="<li>".XPerson($person)."</li>";
		}
		$out.="</ul>";
		return $out;
}

function XListStudents(){
	$out="<ul class=listOfPeople style='overflow:scroll;'>";
		$res=BaseDeDonnees::currentDB()->executeQuery(query_all_students());
		while(($person=pg_fetch_assoc($res))!=null)
		{
			//$out.="<li>".$person['familyname']." ".$person['firstname']."</li>";
			$out.="<li>".XPerson($person)."</li>";
		}
		$out.="</ul>";
	return $out;
}

function XListTeachers(){
	$out="<ul class=listOfPeople style='overflow:scroll;'>";
		$res=BaseDeDonnees::currentDB()->executeQuery(query_all_teachers());
		while(($person=pg_fetch_assoc($res))!=null)
		{
			//$out.="<li>".$person['familyname']." ".$person['firstname']."</li>";
			$out.="<li>".XPerson($person)."</li>";
		}
		$out.="</ul>";
		return $out;
}

function XoptionSpeakers(){
	//$out="<datalist class=optionOfPeople id=listspeakers'>";
	$out="";
		$res=BaseDeDonnees::currentDB()->executeQuery(query_all_speakers());
		while(($person=pg_fetch_assoc($res))!=null)
		{
			//$out.="<option value='".$person['familyname']." ".$person['firstname']."'>";
			$out.="<option>".$person['familyname']." ".$person['firstname'];
		}
		//$out.="</datalist>";
		return $out;
}

function XPerson($ressource){
	if(is_array($ressource)){
		$out="";
		$out.="<form action='test_davical_operations.php' method='POST'>".$ressource['familyname']." ".$ressource['firstname'];
		$out.="<input type='hidden' name='action' value='delete_person'/><input type='hidden' name='id' value=".$ressource['id']." /><input type='submit' value='Supprimer'/></form>";
		return $out;	
	}
}
function query_all_people(){
	return "select * from ".Personne::TABLENAME." order by familyName;";
}
function query_all_people_names(){
	return "select familyName, firstName from ".Person::TABLENAME.";";
}

function query_all_students(){
	return "select * from ".Personne::TABLENAME." as P where exists(select * from ".Statut_personne::TABLENAME." as S where S.id_person=P.id and S.status=1) order by familyName;";
}

function query_all_teachers(){
	return "select * from ".Personne::TABLENAME." as P where exists(select * from ".Statut_personne::TABLENAME." as S where S.id_person=P.id and S.status=3 ) order by familyName;";
}
function query_all_speakers(){
	return "select * from ".Personne::TABLENAME." as P where exists(select * from ".Statut_personne::TABLENAME." as S where S.id_person=P.id and S.status IN (2,3)) order by familyName;";
}
