<?php
class HistoryManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(History $history){
    	$query = $this->_db->prepare(' INSERT INTO t_history (
		action, target, description, created, createdBy)
		VALUES (:action, :target, :description, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':action', $history->action());
		$query->bindValue(':target', $history->target());
		$query->bindValue(':description', $history->description());
		$query->bindValue(':created', $history->created());
		$query->bindValue(':createdBy', $history->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(History $history){
    	$query = $this->_db->prepare(' UPDATE t_history SET 
		action=:action, target=:target, description=:description, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $history->id());
		$query->bindValue(':action', $history->action());
		$query->bindValue(':target', $history->target());
		$query->bindValue(':description', $history->description());
		$query->bindValue(':updated', $history->updated());
		$query->bindValue(':updatedBy', $history->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_history
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getHistoryById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_history
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new History($data);
	}

	public function getHistorys(){
		$historys = array();
		$query = $this->_db->query('SELECT * FROM t_history ORDER BY id DESC LIMIT 100');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$historys[] = new History($data);
		}
		$query->closeCursor();
		return $historys;
	}
    
    public function getHistorysByDate($dateBegin, $dateEnd){
        $historys = array();
        $query = $this->_db->prepare(
        'SELECT * FROM t_history WHERE created BETWEEN :dateBegin AND :dateEnd ORDER BY created DESC');
        $query->bindValue(':dateBegin', $dateBegin);
        $query->bindValue(':dateEnd', $dateEnd);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $historys[] = new History($data);
        }
        $query->closeCursor();
        return $historys;
    }

	public function getHistorysByLimits($begin, $end){
		$historys = array();
		$query = $this->_db->query('SELECT * FROM t_history
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$historys[] = new History($data);
		}
		$query->closeCursor();
		return $historys;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_history
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}