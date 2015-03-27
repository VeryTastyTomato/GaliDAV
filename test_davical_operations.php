<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
?>

<?php 
//Flora NOTE: vous devez écrire dans votre hote.conf la ligne 
//	php_value include_path /usr/share/davical/inc:/usr/share/awl/inc
require_once("/usr/share/davical/htdocs/always.php");
require_once("auth-functions.php");	
require_once("DAVPrincipal.php");	
	



//Créer un calendrier de nom, $calendarNameGiven pour l'utilisateur d'identifiant $username
function CreateSubject( $username, $calendarNameGiven,$defult_timezone = null ) {
  global $session, $c;

	if ( !isset($c->default_collections) )
	{
    	$c->default_collections = array();
    }

  $principal = new Principal('username',$username);

  $user_fullname = $principal->fullname;  // user fullname
  $user_rfullname = implode(' ', array_reverse(explode(' ', $principal->fullname)));  // user fullname in reverse order

  $sql = 'INSERT INTO collection (user_no, parent_container, dav_name, dav_etag, dav_displayname, is_calendar, is_addressbook, default_privileges, created, modified, resourcetypes) ';
  $sql .= 'VALUES( :user_no, :parent_container, :collection_path, :dav_etag, :displayname, :is_calendar, :is_addressbook, :privileges::BIT(24), current_timestamp, current_timestamp, :resourcetypes );';

  //foreach( $c->default_collections as $v ) {
  		if(false){
     /* if ( !empty($v['name']) ) {
        $qry = new AwlQuery( 'SELECT 1 FROM collection WHERE dav_name = :dav_name', array( ':dav_name' => $principal->dav_name().$v['name'].'/') );
        if ( !$qry->Exec() ) {
          $c->messages[] = i18n('There was an error reading from the database.');
          return false;
        }
        if ( $qry->rows() > 0 ) {
          $c->messages[] = i18n('Home '.$calendarGivenName.' already exists.');
          return true;
          */
        }
        else {
          $params[':user_no'] = $principal->user_no();
          $params[':parent_container'] = $principal->dav_name();
          $params[':dav_etag'] = '-1';
          $params[':collection_path'] = $principal->dav_name().$calendarNameGiven.'/';
         // $params[':displayname'] = $user_fullname." ".$calendarNameGiven;
          $params[':displayname'] = $calendarNameGiven;
          $params[':resourcetypes'] = '<DAV::collection/><urn:ietf:params:xml:ns:caldav:calendar/>';
          $params[':is_calendar'] = true;
          $params[':is_addressbook'] = false;
          $params[':privileges'] = null;

          $qry = new AwlQuery( $sql, $params );
          if ( $qry->Exec() ) {
            $c->messages[] = i18n('Calendar added.');
            dbg_error_log("User",":Write: Created user's calendar at '%s'", $params[':collection_path'] );
          }
          else {
            $c->messages[] = i18n("There was an error writing to the database.");
            return false;
          }
        }
      //}
    
  return true;
}


//Test de création d'un EDT (à décommenter)
/*
CreateTimeTable("test3","CalendarTestKFK");
echo ("<p>Un calendrier a dû être créé. Vérifiez sur davical</p>");
*/



function CreateUserAccount($username,$fullname,$password,$email,$privilege){

	$param['username']=$username;
	$param['fullname']=$fullname;
	$param['displayname']=$fullname;
	$param['password']=$password;//Ne marche pas
	$param['email']=$email;
	$param['type_id']=1;//Type Person
	//$param['default_privileges']= privilege_to_bits(array('all')) ;//Ne compile pas
	$P=new DAVPrincipal($param);
	$P->Create($param);
	return $P;
}

//Essai de création d'utilisateur (décommenter)
/*
echo "test création utilisateurs";
$P=new DAVPrincipal($param);
$P->privileges=privilege_to_bits( array('DAV::all') );//Ne marche pas
$P->Create($param);
echo "<br/>Num de l'user:  ".$P->user_no()."<br/>Vérifiez sur davical";
*/

function CreateClassAccount($classname,$password,$email,$privilege){//pour l'instant le mot de passe n'est pas utile, on n'est pas censé se connecter en tant que class

	$param['username']=$classname;
	$param['fullname']=$classname;
	$param['displayname']=$classname;
	$param['password']=$password;//Ne marche pas
	$param['email']=$email;
	$param['type_id']=3;//Type Groupe;
	$C=new DAVPrincipal($param);
	$C->Create($param);
	return $C;
}



if(isset($_POST['action'])){
	if($_POST['action']=='add_subject'){
		CreateSubject($_POST['classname'],$_POST['subjectname']);
		echo("OK");
	}
}
?>
