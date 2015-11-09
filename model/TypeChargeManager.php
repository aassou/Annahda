<?php
class TypeChargeManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(TypeCharge $typeCharge){
    	$query = $this->_db->prepare(' INSERT INTO t_typeCharge (
		nom, created, createdBy)
		VALUES (:nom, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $typeCharge->nom());
		$query->bindValue(':created', $typeCharge->created());
		$query->bindValue(':createdBy', $typeCharge->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(TypeCharge $typeCharge){
    	$query = $this->_db->prepare(' UPDATE t_typeCharge SET 
		nom=:nom, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $typeCharge->id());
		$query->bindValue(':nom', $typeCharge->nom());
		$query->bindValue(':updated', $typeCharge->updated());
		$query->bindValue(':updatedBy', $typeCharge->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_typeCharge
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getTypeChargeById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_typeCharge
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new TypeCharge($data);
	}

	public function getTypeCharges(){
		$typeCharges = array();
		$query = $this->_db->query('SELECT * FROM t_typecharge ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$typeCharges[] = new TypeCharge($data);
		}
		$query->closeCursor();
		return $typeCharges;
	}

	public function getTypeChargesByLimits($begin, $end){
		$typeCharges = array();
		$query = $this->_db->query('SELECT * FROM t_typeCharge
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$typeCharges[] = new TypeCharge($data);
		}
		$query->closeCursor();
		return $typeCharges;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_typeCharge
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}