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
<h1>Test utilisation davical</h1>

<?php 
require_once("test_davical_operations.php");
?>

<div id=admin_panel>
	<table>
		<tr>
			<th>Ajouter un utilisateur</th>
			<th>Ajouter une classe</th>
			<th>Ajouter une matière</th>
		</tr>
		<tr>
			<td><form><input type="submit" value="Ajouter"/></form></td>
			<td><form><input type="submit" value="Ajouter"/></form></td>
			<td><form action="test_davical_operations.php" method="POST">
				<input type='hidden' name='action' value="add_subject"/>
				Nom de la classe<br/><input type="text" name="classname"/><br/>
				Nom de la matière <br/><input type="text" name="subjectname"/><br/>
				Intervenant1: <br/><input type="text" list=listspeakers name="speaker1"/><br/>
				Intervenant2: <br/><input type="text" list=listspeakers name="speaker2"/><br/>
				Intervenant3: <br/><input type="text" list=listspeakers name="speaker3"/><br/>
				<datalist id=listspeakers >
   					<option> Sylvie Borne
   					<option> Céline Rouveirol
				</datalist>
				
				<!--<div id=listspeakers2 style= "max-height:50px; overflow:scroll">
					<input type="checkbox" value="Sylvie Borne"/>Sylvie Borne<br/>
					<input type="checkbox" value="Sylvie Borne"/>Céline Rouveirol
					<br/><input type="checkbox" value="Sylvie Borne"/>Christian Codognet
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					<br/><input type="checkbox" value="Sylvie Borne"/>Sylvie Borne
					
				</div>-->
				<input type="submit" value="Ajouter"/><br/>
			</form></td>
		</tr>
	</table>

</div>

</body>
</html>
