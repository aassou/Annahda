<?php
class LivraisonDetail{
    //attributes
    private $_id;
    private $_libelle;
    private $_designation;
    private $_quantite;
    private $_prixUnitaire;
    private $_idLivraison;
    
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
    
    public function setLibelle($libelle){
        $this->_libelle = $libelle;
    }
    
    public function setDesignation($designation){
        $this->_designation = $designation;
    }
    
    public function setQuantite($quantite){
        $this->_quantite = (float) $quantite;
    }
    
    public function setPrixUnitaire($prixUnitaire){
        $this->_prixUnitaire = (float) $prixUnitaire;
    }
    
    public function setIdLivraison($idLivraison){
        $this->_idLivraison = $idLivraison;
    }
	
    //getters
    public function id(){
        return $this->_id;
    }
    
    public function libelle(){
        return $this->_libelle;
    }
    
    public function designation(){
        return $this->_designation;
    }
    
    public function quantite(){
        return $this->_quantite;
    }
    
    public function prixUnitaire(){
        return $this->_prixUnitaire;
    }
    
    public function idLivraison(){
        return $this->_idLivraison;
    }
	
}
