<?php
class NotesClient{

    //attributes
    private $_id;
    private $_note;
    private $_created;
	private $_idProjet;
	private $_codeContrat;
    
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
    
    public function setNote($note){
        $this->_note = $note;
    }
    
    public function setCreated($created){
        $this->_created = $created;
    }
    
    public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
	
	public function setCodeContrat($codeContrat){
        $this->_codeContrat = $codeContrat;
    }
    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
	public function note(){
        return $this->_note;
    }
	
    public function created(){
        return $this->_created;
    }
    
    public function idProjet(){
        return $this->_idProjet;
    }
	
	public function codeContrat(){
        return $this->_codeContrat;
    }    
}