<?php
class ChargeSyndiqueManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ChargeSyndique $chargeSyndique){
    	$query = $this->_db->prepare(' INSERT INTO t_chargesyndique (
		type, dateOperation, montant, societe, designation, idProjet, created, createdBy)
		VALUES (:type, :dateOperation, :montant, :societe, :designation, :idProjet, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':type', $chargeSyndique->type());
		$query->bindValue(':dateOperation', $chargeSyndique->dateOperation());
		$query->bindValue(':montant', $chargeSyndique->montant());
		$query->bindValue(':societe', $chargeSyndique->societe());
		$query->bindValue(':designation', $chargeSyndique->designation());
		$query->bindValue(':idProjet', $chargeSyndique->idProjet());
		$query->bindValue(':created', $chargeSyndique->created());
		$query->bindValue(':createdBy', $chargeSyndique->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ChargeSyndique $chargeSyndique){
    	$query = $this->_db->prepare(' UPDATE t_chargesyndique SET 
		type=:type, dateOperation=:dateOperation, montant=:montant, 
		societe=:societe, designation=:designation, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $chargeSyndique->id());
		$query->bindValue(':type', $chargeSyndique->type());
		$query->bindValue(':dateOperation', $chargeSyndique->dateOperation());
		$query->bindValue(':montant', $chargeSyndique->montant());
		$query->bindValue(':societe', $chargeSyndique->societe());
		$query->bindValue(':designation', $chargeSyndique->designation());
		$query->bindValue(':updated', $chargeSyndique->updated());
		$query->bindValue(':updatedBy', $chargeSyndique->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_chargesyndique
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getChargeSyndiqueById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_chargesyndique
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ChargeSyndique($data);
	}

	public function getChargeSyndiques(){
		$chargeSyndiques = array();
		$query = $this->_db->query('SELECT * FROM t_chargesyndique
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargeSyndiques[] = new ChargeSyndique($data);
		}
		$query->closeCursor();
		return $chargeSyndiques;
	}
    
    public function getChargeSyndiquesByIdProjet($idProjet){
        $chargeSyndiques = array();
        $query = $this->_db->prepare('SELECT * FROM t_chargesyndique WHERE idProjet=:idProjet ORDER BY dateOperation DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $chargeSyndiques[] = new ChargeSyndique($data);
        }
        $query->closeCursor();
        return $chargeSyndiques;
    }
    
    public function getChargeSyndiquesByIdProjetByType($idProjet, $type){
        $chargeSyndiques = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_chargesyndique 
        WHERE idProjet=:idProjet 
        AND type=:type 
        ORDER BY dateOperation");
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':type', $type);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $chargeSyndiques[] = new ChargeSyndique($data);
        }
        $query->closeCursor();
        return $chargeSyndiques;
    }
    
    public function getChargeSyndiquesByGroupByIdProjet($idProjet){
        $chargeSyndiques = array();
        $query = $this->_db->prepare('SELECT id, type, SUM(montant) AS montant FROM t_chargesyndique WHERE idProjet=:idProjet GROUP BY type');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $chargeSyndiques[] = new ChargeSyndique($data);
        }
        $query->closeCursor();
        return $chargeSyndiques;
    }

	public function getChargeSyndiquesByLimits($begin, $end){
		$chargeSyndiques = array();
		$query = $this->_db->query('SELECT * FROM t_chargesyndique
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargeSyndiques[] = new ChargeSyndique($data);
		}
		$query->closeCursor();
		return $chargeSyndiques;
	}
    
    public function getChargeSyndiquesByIdProjetByDates($idProjet, $dateFrom, $dateTo){
        $chargeSyndiques = array();
        $query = $this->_db->prepare('SELECT * FROM t_chargesyndique WHERE idProjet=:idProjet
        AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY dateOperation DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $chargeSyndiques[] = new ChargeSyndique($data);
        }
        $query->closeCursor();
        return $chargeSyndiques;
    }
    
    public function getChargeSyndiquesByIdProjetByDatesByType($idProjet, $dateFrom, $dateTo, $type){
        $chargeSyndiques = array();
        $query = $this->_db->prepare('SELECT * FROM t_chargesyndique WHERE idProjet=:idProjet AND type=:type
        AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY dateOperation DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->bindValue(':type', $type);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $chargeSyndiques[] = new ChargeSyndique($data);
        }
        $query->closeCursor();
        return $chargeSyndiques;
    }
    
    public function getTotalByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_chargesyndique WHERE idProjet=:idProjet');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotal(){
        $query = $this->_db->query('SELECT SUM(montant) as total FROM t_chargesyndique');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotalByIdProjetByType($idProjet, $type){
        $query = $this->_db->prepare(
        'SELECT SUM(montant) as total FROM t_chargesyndique WHERE idProjet=:idProjet AND type=:type');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':type', $type);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotalByIdProjetByDates($idProjet, $dateFrom, $dateTo){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_chargesyndique 
        WHERE idProjet=:idProjet AND dateOperation BETWEEN :dateFrom AND :dateTo ');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotalByIdProjetByDatesByType($idProjet, $dateFrom, $dateTo, $type){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_chargesyndique 
        WHERE idProjet=:idProjet AND type=:type AND dateOperation BETWEEN :dateFrom AND :dateTo ');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->bindValue(':type', $type);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_chargesyndique
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}