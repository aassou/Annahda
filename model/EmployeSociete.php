<?php
class EmployeSociete{
	//attributes
	private $_id;
	private $_nom;
	private $_cin;
	private $_photo;
	private $_telephone;
	private $_email;
	private $_etatCivile;
	private $_dateDebut;
	private $_dateSortie;
	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    //this method serve to use and call setters dynamically
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
	
	public function setNom($nom){
		$this->_nom = $nom;
	}
	
	public function setCin($cin){
		$this->_cin = $cin;
	}
	
	public function setPhoto($photo){
		$this->_photo = $photo;
	}
	
	public function setTelephone($telephone){
		$this->_telephone = $telephone;
	}
	
	public function setEmail($email){
		$this->_email = $email;
	}
	
	public function setEtatCivile($etat){
		$this->_etatCivile = $etat;
	}
	
	public function setDateDebut($dateDebut){
		$this->_dateDebut = $dateDebut;
	}
	
	public function setDateSortie($dateSortie){
		$this->_dateSortie = $dateSortie;
	}
	
	//getters
	public function id(){
		return $this->_id;
	}
	
	public function nom(){
		return $this->_nom;
	}
	
	public function cin(){
		return $this->_cin;
	}
	
	public function photo(){
		return $this->_photo;
	}
	
	public function telephone(){
		return $this->_telephone;
	}
	
	public function email(){
		return $this->_email;
	}
	
	public function etatCivile(){
		return $this->_etatCivile;
	}
	
	public function dateDebut(){
		return $this->_dateDebut;
	}
	
	public function dateSortie(){
		return $this->_dateSortie;
	}
}