<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
?>

 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" href="./agendav-1.2.6.2.css">
<title>Tests GaliDAV</title></head>
<body> 
<h1 style="text-align:center;">Test utilisation davical</h1>

<?php 
require_once("test_davical_operations.php");
require_once("ListePersonnes.php");
//BaseDeDonnees::currentDB()->initialize();
?>

<div id=admin_panel style='width:80%;height:50%;padding:auto;margin-left:auto;margin-right:auto;'>
	<table>
		<tr>
			<th style="width:33%">Ajouter un utilisateur</th>
			<th style="width:33%">Ajouter une personne</th>
			<th style="width:33%">Ajouter une matière</th>
		</tr>
		<tr style="border-left:solid;border-right:solid">
			<td style="border-left:solid;border-right:solid; padding:auto;">
			<form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_user"/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom</th><td><input type="text" name="familyname"/></td>
				<tr><th>Prénom</th><td><input type="text" name="firstname"/></td>
				<tr><th>login</th><td><input type="text" name="login"/></td>
				<tr><th>Mot de passe</th><td><input type="password" name="password"/></td>
				</table>
				<br/><input type="radio" name="status" value="teacher"/>Enseignant<br/>
				<input type="radio" name="status" value="secretary"/>Secrétaire<br/>
				<input type="radio" name="status" value="head"/>Responsable<br/>
				<input type="radio" name="status" value="administrator"/>Administrateur<br/>
				<input type="submit" value="Ajouter" style='width:80%;margin-left:auto;margin-right:auto;'/>
			</form></td>
			<td style="border-left:solid;border-right:solid; padding:auto;">
			<form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_person"/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom</th><td><input type="text" name="familyname"/></td>
				<tr><th>Prénom</th><td><input type="text" name="firstname"/></td>
				<tr><th>email</th><td><input type="text" name="email"/></td>
				</table>
				<br/><input type="radio" name="status" value="student"/>Élève<br/>
				<input type="radio" name="status" value="speaker"/>Intervenant<br/>
				<input type="submit" value="Ajouter" style='width:80%;margin-left:auto;margin-right:auto;'/>
			</form></td>
			<td style="border-left:solid;border-right:solid; padding:auto;">
			<form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_subject"/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Classe</th><td><input type="text" name="classname"/></td></tr>
				<tr><th>Matière </th><td><input type="text" name="subjectname"/></td></tr>
				<tr><th>Intervenant1:</th><td><select name="speaker1"/><?php echo XoptionSpeakers();?></select></td></tr>
				<tr><th>Intervenant2: </th><td><select name="speaker2"/><?php echo XoptionSpeakers();?></select></td></tr>
				<tr><th>Intervenant3: </th><td><select name="speaker3"/><?php echo XoptionSpeakers();?></select></td></tr>
				</table>
				<input type="submit" value="Ajouter" style='width:80%;margin-left:auto;margin-right:auto;'/><br/>
			</form></td>
		</tr>
	</table>
</div>


	<table style='margin-top:2%;height:auto;border:solid;border-width:10px;width:100%;margin-left:auto;margin-right:auto;'>
		<tr>
			<th style="width:33%">Toutes les personnes</th>
			<th style="width:33%">Tous les enseignants</th>
			<th style="width:33%">Tous les élèves</th>
		</tr>
		<tr>
			<td><?php echo XListAll();?></td>
			<td><?php echo XListTeachers();?></td>
			<td><?php echo XListStudents();?></td>
		</tr>
	</table>

</body>
</html>
