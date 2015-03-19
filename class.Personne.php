<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Personne.php
 *
 * $Id$
 *
 * $this file is part of modèle.edt.galilée.
 *
 * Automatically generated on 18.03.2015, 17:41:28 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('$this file was generated for PHP 5');
}

/**
 * include Personne_Statut_persone
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */

require_once('Personne/unknown.Statut_persone.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BA2-constants end

/**
 * Short description of class Personne
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Personne
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : statuts
    protected $statuts=array();

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute nom
     *
     * @access protected
     * @var String
     */
    protected $nom = null;

    /**
     * Short description of attribute prenom
     *
     * @access protected
     * @var String
     */
    protected $prenom = null;

    /**
     * Short description of attribute mail1
     *
     * @access protected
     * @var String
     */
    protected $mail1 = null;

    /**
     * Short description of attribute mail2
     *
     * @access protected
     * @var String
     */
    protected $mail2 = null;

    // --- OPERATIONS ---
    
    // -- Constructeurs
    
    public function __construct($N,$P){
    	$this->nom=$N;
    	$this->prenom=$P;
    }
    

	// -- Accesseurs --//
	public function get_nom(){
		return $this->nom;
	}
	public function get_prenom(){
		return $this->prenom;
	}
	public function get_mail1(){
		return $this->mail1;
	}
	
	public function get_mail2(){
		return $this->mail2;
	}
	
	public function set_mail1($m){
    	$this->mail1=$m;
    }
    public function set_mail2($m){
    	if($this->get_mail()!=null)$this->mail2=$m;
    	else $this->set_mail1($m);
    }
    
    public function add_status($S){
    	if($S instanceof Statut_personne)if(!$this->has_status($S))$this->statuts[]=$S;
    }
    public function remove_status($S){
    	if($S instanceof Statut_personne){
    		if($this->has_status($S)){
    			$indice=0;
    			foreach($this->statuts as $onestatus){
    				if($onestatus==$S){
    					unset($this->statuts[$indice]);
    					break;
    				}
    				$indice=$indice+1;
    			}
    		}
    	}
    }
    
    //Flora: TO COMPLETE après que Simon ait fait les enums (il y a redondance) 
    public function has_status(Statut_personne $S){
   		if($S instanceof Statut_personne){
			foreach($this->statuts as $onestatus){
				if($onestatus==$S)return true;
			}
		}
    	return false;
    }
    
    // -- Affichage texte --//
    public function to_html(){
    	$result="<p>Nom:&emsp;&emsp;  ".$this->nom."<br/>Prenom:&emsp; &emsp; ".$this->prenom."</p>";
    	if($this->get_mail1()!=NULL){
    		$result=$result."<p>Adresse mail1 :&emsp;  <i>".$this->mail1."</i>";
    		if($this->get_mail2())$result=$result."<br/>Adresse mail2 :&emsp;  <i>".$this->mail2."</i>";
    		$result=$result."</p>";
    	}
    	if($this->statuts!=NULL){
    		$result=$result."<p>Statuts:&emsp;  ";
    		foreach($this->statuts as $s){
    			$result=$result."- $s ";
    		}
    		$result=$result."</p>";
    	}
    	return $result;
    }
} /* end of class Personne */

?>
