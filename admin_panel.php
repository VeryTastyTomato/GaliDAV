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
<div class="navbar">
 <div class="navbar-inner">
  <div class="container-fluid">
   <span class="brand"><?php echo "Panneau d'administration"; ?></span>
   <p class="navbar-text pull-right" id="loading">
    Connexion
   </p>
   

   <ul class="nav pull-right">
  <?php
 
  $agendav_path="http://davical.example.net/agendav2";
  	echo("<li class='dropdown' style='margin-top:auto;margin-bottom:auto;'><a href='$agendav_path/index.php' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary' role='button' aria-disabled='false'> <span class='ui-button-text'>Retour aux emplois du temps</span></a></li>");
  	
  	?>
    <li class="dropdown" id="usermenu"><a href="#"><span class="username">X</span></a></li>
   </ul>
      
  </div>
 </div>
</div>


<?php 
require_once("test_davical_operations.php");
require_once("ListePersonnes.php");
	//Reconstruit toutes les tables de la base
	//BaseDeDonnees::currentDB()->initialize();

	if(isset($_GET['GMESSAGE_ERROR'])){
		if($_GET['GMESSAGE_ERROR']=='DIFFERENT_PASS')
			echo"<p class='gmessage error' style='width:80%;height:30px;padding:auto;margin-left:auto;margin-right:auto;overflow:auto; border-style:dashed'>Les deux mots de passes entrés sont différents</p>";
	
		unset($_GET['GMESSAGE_ERROR']);
	}
?>
<form action="test_davical_operations.php" method="POST" style="position:fixed;right:0px;top:50px;"><input type='hidden' name='action' value="clear_db"/><input type=submit value="Effacer toutes les données"/></form>

<div id=admin_panel style='width:80%;height:450px;padding:auto;margin-left:auto;margin-right:auto;overflow:auto'>
	<table>
		<tr>
			<th style="width:33%">Ajouter un utilisateur</th>
			<th style="width:33%">Ajouter une personne</th>
			<th style="width:33%">Ajouter une classe (ou un groupe)</th>
		</tr>
		<tr style="border-left:solid;border-right:solid">
			<td style="border-left:solid;border-right:solid; padding:auto;">
			<form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_user"/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom</th><td><input type="text" name="familyname" required/></td></tr>
				<tr><th>Prénom</th><td><input type="text" name="firstname" required/></td></tr>
				<tr><th>login</th><td><input type="text" name="login" required/></td></tr>
				<tr><th>Mot de passe</th><td><input type="password" name="password" required/></td></tr>
				<tr><th>Confirmation</th><td><input type="password" name="password2" required/></td></tr>
				<tr><th>email</th><td><input type="text" name="email" required/></td></tr>
				</table>
				<br/><input type="radio" name="status" value="teacher" checked/>Enseignant<br/>
				<input type="radio" name="status" value="secretary"/>Secrétaire<br/>
				<input type="radio" name="status" value="head"/>Responsable<br/>
				<input type="radio" name="status" value="administrator"/>Administrateur<br/>
				<input type="submit" value="Ajouter" style='width:80%;margin-left:auto;margin-right:auto;'/>
			</form></td>
			<td style="border-left:solid;border-right:solid; padding:auto;">
			<form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_person"/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom</th><td><input type="text" name="familyname" required/></td></tr>
				<tr><th>Prénom</th><td><input type="text" name="firstname" required/></td></tr>
				<tr><th>email</th><td><input type="text" name="email" required/></td></tr>
				</table>
				<br/><input type="radio" name="status" value="student" checked/>Élève<br/>
				<input type="radio" name="status" value="speaker"/>Intervenant<br/>
				<input type="submit" value="Ajouter" style='width:80%;margin-left:auto;margin-right:auto;'/>
			</form></td>
	
			<td style="border-left:solid;border-right:solid; padding:auto;">
			<form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_group"/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom:</th><td><input type="text" name="name" required/></td></tr>
				<tr><td><input type="radio" name="isaclass" value=true checked/>Classe<br/>
				<input type="radio" name="isaclass" value=false />Groupe<br/>
				</td></tr></table>
				<input type="submit" value="Ajouter" style='width:80%;margin-left:auto;margin-right:auto;'/><br/>
			</form></td>
	
		</tr>
		<tr>
			<th style="width:33%">Ajouter une matière</th>
			<th style="width:33%"></th>
			<th style="width:33%">Modifier un groupe</th>
			
		</tr>
		<tr>
			<td style="border-left:solid;border-right:solid; padding:auto;">
			<form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_subject"/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Matière </th><td><input type="text" name="subjectname" required/></td></tr>
				<tr><th>Classe</th><td><select name="groupname"/><?php echo XoptionGroups();?></td></tr>
				<tr><th>Intervenant1:</th><td><select name="speaker1"/><?php echo XoptionSpeakers();?></select></td></tr>
				<tr><th>Intervenant2: </th><td><select name="speaker2"/><?php echo XoptionSpeakers();?></select></td></tr>
				<tr><th>Intervenant3: </th><td><select name="speaker3"/><?php echo XoptionSpeakers();?></select></td></tr>
				</table>
				<input type="submit" value="Ajouter" style='width:80%;margin-left:auto;margin-right:auto;'/><br/>
			</form></td>

			<td></td>

			<td style = "border-left:solid; border-right:solid; padding:auto;">
				<form action = "test_davical_operations.php" method = "POST">
					<input type = 'hidden' name = 'action' value = "modify_group"/>
					<table style = margin-left:auto;margin-right:auto;>
						<tr>
							<th>Nom :</th><td><input type = "text" name = "subjectgroup" required></td>
						</tr>
						<tr>
							<th><?php echo XListStudents(); ?></th>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
</div>

<div style='height:150px;border:solid;background-color:#AAAAAA;border-width:10px;border-color:#888888;overflow:auto;width:100%;margin-left:auto;margin-right:auto;'>
	<table style='height:100%;width:100%';>
		<tr style='width:100%'>
			<th style='width:20%'>Toutes les personnes</th>
			<th style='width:20%'>Tous les enseignants</th>
			<th style='width:20%'>Tous les élèves</th>
			<th style="width:20%">Tous les groupes et classes</th>
		</tr>
		<tr style='height:50%;'>
			<td><?php echo XListAll();?></td>
			<td><?php echo XListTeachers();?></td>
			<td><?php echo XListStudents();?></td>
			<td><?php echo XListAllGroups();?></td>
		</tr>
		<tr>
			<th>?</th>
		</tr>
		<tr style='height:50%;'>
			
		</tr>
	</table>
</div>
</body>
</html>
