<?php
class ClientManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Client $client){
        $query = $this->_db->prepare(
        'INSERT INTO t_client (nom, adresse, telephone1, telephone2, cin, email, created, code)
        VALUES (:nom, :adresse, :telephone1, :telephone2, :cin, :email, :created, :code)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $client->nom());
        $query->bindValue(':adresse', $client->adresse());
        $query->bindValue(':telephone1', $client->telephone1());
        $query->bindValue(':telephone2', $client->telephone2());
        $query->bindValue(':cin', $client->cin());
        $query->bindValue(':email', $client->email());
        $query->bindValue(':created', $client->created());
		$query->bindValue(':code', $client->code());
        $query->execute();
        $query->closeCursor();
    }
    
    public function update(Client $client){
        $query = $this->_db->prepare('UPDATE t_client SET nom=:nom, adresse=:adresse, telephone1=:telephone1, 
        telephone2=:telephone2, cin=:cin, email=:email WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $client->nom());
        $query->bindValue(':adresse', $client->adresse());
        $query->bindValue(':telephone1', $client->telephone1());
        $query->bindValue(':telephone2', $client->telephone2());
        $query->bindValue(':cin', $client->cin());
        $query->bindValue(':email', $client->email());
        $query->bindValue(':id', $client->id());
        $query->execute();
        $query->closeCursor();
    }
	
	public function delete($idClient){
		$query = $this->_db->prepare('DELETE FROM t_client WHERE id=:idClient')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idClient', $idClient);
		$query->execute();
		$query->closeCursor();
	}
    
	public function getClientBySearch($recherche, $testRadio){
		$query = "";	
		if($testRadio==1){
			$query = $this->_db->prepare("SELECT * FROM t_client WHERE nom LIKE :recherche");
			$query->bindValue(':recherche', '%'.$recherche.'%');
		}
		else if($testRadio==2){
			$query = $this->_db->prepare("SELECT * FROM t_client WHERE cin=:cin");
			$query->bindValue(':cin', $recherche);
		}
		$query->execute();
        $clients = array();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
	}
	
 	public function getClientNameById($id){
        $query = $this->_db->prepare('SELECT nom FROM t_client WHERE id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nom'];
    }
    
    public function getClientsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS clientNumbers FROM t_client');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['clientNumbers'];
    }
    
    public function getClientsNumberToday(){
        $query = $this->_db->query('SELECT COUNT(*) AS clientNumbersToday FROM t_client WHERE created=CURDATE()');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['clientNumbersToday'];
    }
    
    public function getClientsNumberWeek(){
        $query = $this->_db->query('SELECT COUNT(*) AS clientNumbersWeek FROM t_client WHERE created BETWEEN SUBDATE(CURDATE(),7) AND CURDATE()') or die(print_r($this->_db->errorInfo()));;
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['clientNumbersWeek'];
    }
    
    public function getClientsNumberMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS clientNumbersMonth FROM t_client WHERE MONTHNAME(created) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['clientNumbersMonth'];
    }
    
    public function getClients(){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client ORDER BY id DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
    }
    
    public function getClientsByLimits($begin, $end){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //$query->bindValue(':begin', $begin);
        //$query->bindValue(':end', $end);
        //$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
    }

    public function getClientsToday(){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client WHERE created = CURDATE() ORDER BY created');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
    }
    
    public function getClientsYesterday(){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client WHERE created = SUBDATE(CURDATE(),1)');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
    }
    
    public function getClientsWeek(){
        $clients = array();
        $query = $this->_db->query('SELECT * FROM t_client WHERE created BETWEEN SUBDATE(CURDATE(),7) AND CURDATE()');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $clients[] = new Client($data);
        }
        $query->closeCursor();
        return $clients;
    }
    
	public function getClientByCode($code){
        $query = $this->_db->prepare('SELECT * FROM t_client WHERE code=:code');
        $query->bindValue(':code', $code);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Client($data);
    }
	
    public function getClientById($id){
        $query = $this->_db->prepare('SELECT * FROM t_client WHERE id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Client($data);
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_client ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function getCodeClient($code){
        $query = $this->_db->prepare('SELECT code FROM t_client WHERE code=:code');
		$query->bindValue(':code', $code);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['code'];
    }
	
	public function exists($nom){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_client WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nom, ' ', '') ");
        $query->execute(array(':nom' => $nom));
        //get result
        return $query->fetchColumn();
    }
}