<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

require_once("class.BaseDeDonnees.php");
require_once("class.Utilisateur.php");
require_once('AWLUtilities.php');
$error=false;

if(isset($_POST['user'])){
	$params=array($_POST['user']);
	$query="select password from ".Utilisateur::TABLENAME." where login=$1 and id_person in (select id_person from  ".Statut_personne::TABLENAME." where status=6);";
	$result=BaseDeDonnees::currentDB()->executeQuery($query,$params);
	if($result){
		$array=pg_fetch_assoc($result);
		if($array!=null){
	
			if(session_validate_password($_POST['passwd'],$array['password'])){
				header('Location: admin_panel.php');
			}	
		}
	}
	
	$error=true;
	if($error){
			$error="<div class='ui-widget loginerrors'>
 				<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'> 
  <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
   </p><p>Le mot de passe est erroné ou vous n'avez pas les droits nécessaires.</p>
  <p></p>
  </div>
</div>";
	}

}
?>

 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" href="./agendav-1.2.6.2.css">
<link rel="stylesheet" href="./boostrap.agendav.css">
<title>Panneau d'administration</title></head>
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
 
  $agendav_path="http://edthote.fr/agendav2";
  	echo("<li class='dropdown' style='margin-top:auto;margin-bottom:auto;'><a href='$agendav_path/index.php' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary' role='button' aria-disabled='false'> <span class='ui-button-text'>Retour aux emplois du temps</span></a></li>");
  	
  	?>
    <li class="dropdown" id="usermenu"><a href="#"><span class="username">Non connecté</span></a></li>
   </ul>
      
  </div>
 </div>
</div>


<div class="ui-widget loginerrors">
 <?php if($error)echo $error; ?>
  

<div class="loginform ui-corner-all">

  <form action="http://edthote.fr/GaliDAV/login_admin.php" method="post" accept-charset="utf-8" class="form-horizontal">
  <div style="display:none">
<input name="csrf_test_name" value="3d354941803123010204d7bca40984ea" type="hidden">
</div>            <div class="control-group">
            <label class="control-label">Nom d'utilisateur</label><div class="controls">
            <?php if(isset($_GET['user']))
            echo "<input name='user' value='".$_GET['user']."' id='login_user' maxlength=40 size=15 class='input-medium' autofocus='autofocus' type='text'>";
            else 
            echo  "<input name='user' value='' id='login_user' maxlength='40' size='15' class='input-medium' autofocus='autofocus' type='text'>";
            ?>
            </div>            </div>
                      <div class="control-group">
            <label class="control-label">Mot de passe</label><div class="controls"><input name="passwd" value="" id="login_passwd" maxlength="40" class="input-medium" size="15" type="password"></div>            </div>
        <input aria-disabled="false" role="button" class="ui-button ui-widget ui-state-default ui-corner-all" name="login" value="Se connecter" type="submit"></form></div>


  
</div>
</body>
</html>
