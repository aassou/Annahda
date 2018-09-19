<?php
class TypeChargeSyndiqueManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(TypeChargeSyndique $typeChargeSyndique){
    	$query = $this->_db->prepare(' INSERT INTO t_typechargesyndique (
		nom, created, createdBy)
		VALUES (:nom, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $typeChargeSyndique->nom());
		$query->bindValue(':created', $typeChargeSyndique->created());
		$query->bindValue(':createdBy', $typeChargeSyndique->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(TypeChargeSyndique $typeChargeSyndique){
    	$query = $this->_db->prepare(' UPDATE t_typechargesyndique SET 
		nom=:nom, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $typeChargeSyndique->id());
		$query->bindValue(':nom', $typeChargeSyndique->nom());
		$query->bindValue(':updated', $typeChargeSyndique->updated());
		$query->bindValue(':updatedBy', $typeChargeSyndique->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_typechargesyndique
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getTypeChargeSyndiqueById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_typechargesyndique
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new TypeChargeSyndique($data);
	}

	public function getTypeChargeSyndiques(){
		$typeChargeSyndiques = array();
		$query = $this->_db->query('SELECT * FROM t_typechargesyndique ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$typeChargeSyndiques[] = new TypeChargeSyndique($data);
		}
		$query->closeCursor();
		return $typeChargeSyndiques;
	}

	public function getTypeChargeSyndiquesByLimits($begin, $end){
		$typeChargeSyndiques = array();
		$query = $this->_db->query('SELECT * FROM t_typechargesyndique
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$typeChargeSyndiques[] = new TypeChargeSyndique($data);
		}
		$query->closeCursor();
		return $typeChargeSyndiques;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_typechargesyndique
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
    
    public function exists($nomTypeChargeSyndique){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_typechargesyndique WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nom, ' ', '') ");
        $query->execute(array(':nom' => $nomTypeChargeSyndique));
        //get result
        return $query->fetchColumn();
    }

}