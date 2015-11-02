<?php
class User{

    //attributes
    private $_id;
    private $_login;
    private $_password;
    private $_created;
    private $_profil;
	private $_status;
    
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
    
    public function setLogin($login){
        $this->_login = $login;
    }
    
    public function setPassword($password){
        $this->_password = $password;
    }
    
    public function setCreated($created){
        $this->_created = $created;
    }
	
	public function setProfil($profil){
		$this->_profil = $profil;
	}
	
	public function setStatus($status){
		$this->_status = $status;
	}
	    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function login(){
        return $this->_login;
    }
    
    public function password(){
        return $this->_password;
    }
    
    public function created(){
        return $this->_created;
    }
    
    public function profil(){
        return $this->_profil;
    }
	
	public function status(){
        return $this->_status;
    }
        
}