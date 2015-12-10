<?php
class ContratEmploye{

	//attributes
	private $_id;
	private $_dateContrat;
    private $_prixUnitaire;
    private $_nombreUnites;
	private $_total;
	private $_employe;
	private $_idProjet;
	private $_created;
	private $_createdBy;

	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d\'une façon dynamique!
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
	public function setDateContrat($dateContrat){
		$this->_dateContrat = $dateContrat;
   	}

    public function setPrixUnitaire($prixUnitaire){
        $this->_prixUnitaire = $prixUnitaire;
    }
    
    public function setNombreUnites($nombreUnites){
        $this->_nombreUnites = $nombreUnites;
    }
    
	public function setTotal($total){
		$this->_total = $total;
   	}

	public function setEmploye($employe){
		$this->_employe = $employe;
   	}

	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
   	}

	public function setCreated($created){
        $this->_created = $created;
    }

	public function setCreatedBy($createdBy){
        $this->_createdBy = $createdBy;
    }

	//getters
	public function id(){
    	return $this->_id;
    }
	public function dateContrat(){
		return $this->_dateContrat;
   	}

    public function prixUnitaire(){
        return $this->_prixUnitaire;
    }
    
    public function nombreUnites(){
        return $this->_nombreUnites;
    }

	public function total(){
		return $this->_total;
   	}

	public function employe(){
		return $this->_employe;
   	}

	public function idProjet(){
		return $this->_idProjet;
   	}

	public function created(){
        return $this->_created;
    }

	public function createdBy(){
        return $this->_createdBy;
    }

}