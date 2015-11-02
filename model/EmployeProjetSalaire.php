<?php
class EmployeProjetSalaire{

    //attributes
    private $_id;
	private $_salaire;
	private $_nombreJours;
	private $_dateOperation;
	private $_idEmploye;
	
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

	public function setNom($nom){
		$this->_nom = $nom;
	}
	
	public function setSalaire($salaire){
		$this->_salaire = $salaire;
	}
	
	public function setNombreJours($nombreJours){
		$this->_nombreJours = $nombreJours;
	}
	
	public function setDateOperation($dateOperation){
		$this->_dateOperation = $dateOperation;
	}
	
	public function setIdEmploye($idEmploye){
		$this->_idEmploye = $idEmploye;
	}
	
    //getters
    
    public function id(){
        return $this->_id;
    }
    
	public function nom(){
		return $this->_nom;
	}
	
	public function salaire(){
		return $this->_salaire;
	}
	
	public function nombreJours(){
		return $this->_nombreJours;
	}
	
	public function dateOperation(){
		return $this->_dateOperation;
	}
	
	public function idEmploye(){
		return $this->_idEmploye;
	}
}