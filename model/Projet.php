<?php
class Projet{

    //attributes
    private $_id;
    private $_nom;
    private $_adresse;
    private $_superficie;
    private $_description;
    private $_budget;
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
    
    public function setAdresse($adresse){
        $this->_adresse = $adresse;
    }
    
    public function setSuperficie($superficie){
        $this->_superficie = $superficie;
    }
    
    public function setDescription($description){
        $this->_description = $description;
    }
    
    public function setBudget($budget){
        $this->_budget = $budget;
    }
    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function nom(){
        return $this->_nom;
    }
    
    public function adresse(){
        return $this->_adresse;
    }
    
    public function superficie(){
        return $this->_superficie;
    }
    
    public function description(){
        return $this->_description;
    }
    
    public function budget(){
        return $this->_budget;
    }
        
}