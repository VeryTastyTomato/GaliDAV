<?php
/**
 * \file  admin_panel.php
 * \brief Displays the administrator’s panel.
*/
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv = "Content-Type" content = "text/html;charset = utf-8">
		<link rel = "stylesheet" href = "./css/agendav-1.2.6.2.css">
		<title>Tests GaliDAV</title>
	</head>
	<body>
		<div class = "navbar">
			<div class = "navbar-inner">
				<div class = "container-fluid">
					<span class = "brand">
						<?php
							echo "Panneau d’administration";
						?>
					</span>
					<p class = "navbar-text pull-right" id = "loading">Connexion</p>

					<ul class = "nav pull-right">
						<?php
							if (!defined("AGENDAV_PATH"))
							{
								define("AGENDAV_PATH", "http://test.davical.net/agendav/");
							}
							$agendav_path = AGENDAV_PATH;
							$galidav_path = "http://test.davical.net/galidav";
							echo ("<li class = 'dropdown' style = 'margin-top:auto;margin-bottom:auto;'><a href = '".$agendav_path."index.php' class = 'ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary' role = 'button' aria-disabled = 'false'> <span class = 'ui-button-text'>Retour aux emplois du temps</span></a></li>");
						?>
						<li class = "dropdown" id = "usermenu">
							<a href = "#"><span class = "username"></span></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<?php
			require_once("test_davical_operations.php");
			require_once("liste_personnes.php");

			// Reconstruit toutes les tables de la base
			// Database::currentDB()->initialize();

			if (isset($_GET['GMESSAGE_ERROR']))
			{
				if ($_GET['GMESSAGE_ERROR'] == 'DIFFERENT_PASS')
				{
					echo "<p class = 'gmessage error' style = 'width:80%;height:30px;padding:auto;margin-left:auto;margin-right:auto;overflow:auto; border-style:dashed'>Les deux mots de passes entrés sont différents</p>";
				}

				unset($_GET['GMESSAGE_ERROR']);
			}
		?>
		<form action = "test_davical_operations.php" method = "POST" style = "position:absolute;left:0px;top:50px;width:150px;">
			<input type = 'hidden' name = 'action' value = "clear_db" />
			<input type = submit value = "Effacer toutes les données" />
		</form>
		<form action = "test_davical_operations.php" method = "POST" style = "position:absolute;left:180px;top:50px;width:150px;">
			<input type = 'hidden' name = 'action' value = "init_db" />
			<input type = submit value = "(Re)créer une base vierge" />
		</form>
		<div id = admin_panel style = 'width:80%;height:450px;padding:auto;margin-left:auto;margin-right:auto;overflow:auto'>
			<table style = 'width:100%;height:100%;'>
				<tr style = 'width:100%;height:100%;'>
					<td style = 'width:50%;height:100%'>
						<ul style = 'width:100%;list-style-type:none;padding:20px;'>
							<li class = 'dropdown add_student' style = 'margin-top:auto;margin-bottom:auto;width:100%;height:10%;'>
								<?php
									echo ("<a href = '$galidav_path/admin_panel.php?action=add_person' class = 'ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary add_student' role = 'button' aria-disabled = 'false'>");
								?>
									<div class = 'ui-button-text add_student' style = 'width:100%;'>Ajouter un étudiant ou un intervenant</div>
								</a>
							</li>
							<li class = 'dropdown' style = 'margin-top:auto;margin-bottom:auto;'>
								<?php
									echo ("<a href = '$galidav_path/admin_panel.php?action=add_user' class ='ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary add_student' role = 'button' aria-disabled = 'false'>");
								?>
									<div class = 'ui-button-text'>Ajouter un utilisateur</div>
								</a>
							</li>
							<li class = 'dropdown' style = 'margin-top:auto;margin-bottom:auto;'>
								<?php
									echo ("<a href = '$galidav_path/admin_panel.php?action=add_group' class = 'ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary add_student' role = 'button' aria-disabled = 'false'>");
								?>
									<div class = 'ui-button-text'>Ajouter une classe ou un groupe</div>
								</a>
							</li>
							<li class = 'dropdown' style = 'margin-top:auto;margin-bottom:auto;'>
								<?php
									echo ("<a href = '$galidav_path/admin_panel.php?action=add_subject' class = 'ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary add_student' role = 'button' aria-disabled = 'false'>");
								?>
									<div class = 'ui-button-text'>Ajouter une matière</div>
								</a>
							</li>
						</ul>
					<td>
					<td class = "loginform ui-corner-all add_student" style = 'width:50%;height:100%'>
						<?php
							if (isset($_GET['action']))
							{
								if ($_GET['action'] == 'add_user')
								{
									echo ("
				<form action='test_davical_operations.php' method='POST'>
				<input type='hidden' name='action' value='add_user'0/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom</th><td><input type='text' name='familyname' required/></td></tr>
				<tr><th>Prénom</th><td><input type='text' name='firstname' required/></td></tr>
				<tr><th>login</th><td><input type='text' name='login' required/></td></tr>
				<tr><th>Mot de passe</th><td><input type='password' name='password' required/></td></tr>
				<tr><th>Confirmation</th><td><input type='password' name='password2' required/></td></tr>
				<tr><th>email</th><td><input type='text' name='email' required/></td></tr>
				</table>
				<br/><input type='radio' name='status' value='teacher' checked/>Enseignant<br/>
				<input type='radio' name='status' value='secretary'/>Secrétaire<br/>
				<input type='radio' name='status' value='head'/>Responsable<br/>
				<input type='radio' name='status' value='administrator'/>Administrateur<br/>
				<input type='submit' value='Ajouter' style='width:80%;margin-left:auto;margin-right:auto;'/>
			</form>");
								}

								if ($_GET['action'] == 'add_person')
								{
									echo ("
				<form action='test_davical_operations.php' method='POST'>
				<input type='hidden' name='action' value='add_person'/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom</th><td><input type='text' name='familyname' required/></td></tr>
				<tr><th>Prénom</th><td><input type='text' name='firstname' required/></td></tr>
				<tr><th>email</th><td><input type='text' name='email' required/></td></tr>
				</table>
				<br/><input type='radio' name='status' value='student' checked/>Élève<br/>
				<input type='radio' name='status' value='speaker'/>Intervenant<br/>
				<input type='submit' value='Ajouter' style='width:80%;margin-left:auto;margin-right:auto;'/>
			</form>");
								}

								if ($_GET['action'] == 'add_group')
								{
									echo ("
				<form action='test_davical_operations.php' method='POST'>
				<input type='hidden' name='action' value='add_group'/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Nom:</th><td><input type='text' name='name' required/></td></tr>
				<tr><td><input type='radio' name='isaclass' value=true checked/>Classe<br/>
				<input type='radio' name='isaclass' value=false />Groupe<br/>
				</td></tr></table>
				<input type='submit' value='Ajouter' style='width:80%;margin-left:auto;margin-right:auto;'/><br/>
			</form>");
								}

								if ($_GET['action'] == 'add_subject')
								{
									$liste_intervenants = XoptionSpeakers();
									echo ("
				<form action='test_davical_operations.php' method='POST'>
				<input type='hidden' name='action' value='add_subject'/>
				<table style=margin-left:auto;margin-right:auto;>
				<tr><th>Matière </th><td><input type='text' name='subjectname' required/></td></tr>
				<tr><th>Classe</th><td><select name='groupname'/>"); ?><?php echo XoptionGroups();?>
				<?php
									echo ("</td></tr>
				<tr><th>Intervenant1:</th><td><select name='speaker1'/>");
 									echo $liste_intervenants;
									echo ("</select></td></tr>
				<tr><th>Intervenant2: </th><td><select name='speaker2'/>"); 
									echo $liste_intervenants;
									echo ("</select></td></tr>
				<tr><th>Intervenant3: </th><td><select name='speaker3'/>");
									echo $liste_intervenants;
									echo ("</select></td></tr>
				</table>
				<input type='submit' value='Ajouter' style='width:80%;margin-left:auto;margin-right:auto;'/><br/>
			</form>");
								}
							}

							else echo("Sélectionnez une action");
						?>
					<td>
				</tr>
			</table>
		</div>
		<div style = 'height:150px;border:solid;background-color:#AAAAAA;border-width:10px;border-color:#888888;overflow:auto;width:100%;margin-left:auto;margin-right:auto;'>
			<table style = 'height:100%;width:100%';>
				<tr style = 'width:100%'>
					<th style = 'width:20%'>Toutes les personnes</th>
					<th style = 'width:20%'>Tous les enseignants</th>
					<th style = 'width:20%'>Tous les élèves</th>
					<th style = "width:20%">Tous les groupes et classes</th>
				</tr>
				<tr style = 'height:50%;'>
					<td><?php echo XListAll(); ?></td>
					<td><?php echo XListTeachers(); ?></td>
					<td><?php echo XListStudents(); ?></td>
					<td><?php echo XListAllGroups(); ?></td>
				</tr>
				<tr>
					<th>?</th>
				</tr>
				<tr style = 'height:50%;'>
				</tr>
			</table>
		</div>
	</body>
</html>
