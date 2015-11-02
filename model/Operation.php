<?php
class Operation{
    //attributes
    private $_id;
    private $_date;
    private $_montant;
	private $_modePaiement;
    private $_idContrat;
	private $_numeroCheque;
    
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
    
    public function setDate($date){
        $this->_date = $date;
    }
    
    public function setMontant($montant){
        $this->_montant = $montant;
    }
	
	public function setModePaiement($modePaiement){
        $this->_modePaiement = $modePaiement;
    }
    
    public function setIdContrat($idContrat){
        $this->_idContrat = $idContrat;
    }
	
	public function setNumeroCheque($numeroCheque){
        $this->_numeroCheque = $numeroCheque;
    }
    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function date(){
        return $this->_date;
    }
    
    public function montant(){
        return $this->_montant;
    }
    
	public function modePaiement(){
        return $this->_modePaiement;
    }
	
    public function idContrat(){
        return $this->_idContrat;
    }
	
	public function numeroCheque(){
        return $this->_numeroCheque;
    }
}
