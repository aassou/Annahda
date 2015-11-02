<?php
class Terrain{
	//attributes
	private $_id;
	private $_prix;
	private $_vendeur;
	private $_fraisAchat;
	private $_superficie;
	private $_emplacement;
	private $_idProjet;
	
	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
	//setters
	public function setId($id){
        $this->_id = $id;
    }
	
	public function setPrix($prix){
		$this->_prix = $prix;
	}
	
	public function setVendeur($vendeur){
		$this->_vendeur = $vendeur;
	}
	
	public function setFraisAchat($fraisAchat){
		$this->_fraisAchat = $fraisAchat;
	}
	
	public function setSuperficie($superficie){
		$this->_superficie = $superficie;
	}
	
	public function setEmplacement($emplacement){
		$this->_emplacement = $emplacement;
	}
	
	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
	}
	
	//getters
	public function id(){
		return $this->_id;
	}
	
	public function prix(){
		return $this->_prix;
	}
	
	public function vendeur(){
		return $this->_vendeur;
	}
	
	public function fraisAchat(){
		return $this->_fraisAchat;
	}
	
	public function superficie(){
		return $this->_superficie;
	}
	
	public function emplacement(){
		return $this->_emplacement;
	}
	
	public function idProjet(){
		return $this->_idProjet;
	}
}
