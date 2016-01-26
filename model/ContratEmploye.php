<?php
class ContratEmploye{

	//attributes
	private $_id;
	private $_dateContrat;
    private $_dateFinContrat;
    private $_prixUnitaire;
    private $_nombreUnites;
    private $_unite;
    private $_nomUnite;
    private $_traveaux;
    private $_traveauxArabe;
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
    
    public function setDateFinContrat($dateFinContrat){
        $this->_dateFinContrat = $dateFinContrat;
    }

    public function setPrixUnitaire($prixUnitaire){
        $this->_prixUnitaire = $prixUnitaire;
    }
    
    public function setUnite($unite){
        $this->_unite = $unite;
    }
    
    public function setNomUnite($nomUnite){
        $this->_nomUnite = $nomUnite;
    }
    
    public function setTraveaux($traveaux){
        $this->_traveaux = $traveaux;
    }
    
    public function setTraveauxArabe($traveauxArabe){
        $this->_traveauxArabe = $traveauxArabe;
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
    
    public function dateFinContrat(){
        return $this->_dateFinContrat;
    }

    public function prixUnitaire(){
        return $this->_prixUnitaire;
    }
    
    public function unite(){
        return $this->_unite;
    }
    
    public function nomUnite(){
        return $this->_nomUnite;
    }
    
    public function traveaux(){
        return $this->_traveaux;
    }
    
    public function traveauxArabe(){
        return $this->_traveauxArabe;
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