<?php
class LocauxManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(Locaux $locaux){
        $query = $this->_db->prepare('INSERT INTO t_locaux (nom, superficie, facade, prix, mezzanine, status, idProjet, par)
        VALUES (:nom, :superficie, :facade, :prix, :mezzanine, :status, :idProjet, :par)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $locaux->nom());
        $query->bindValue(':superficie', $locaux->superficie());
		$query->bindValue(':facade', $locaux->facade());
		$query->bindValue(':prix', $locaux->prix());
		$query->bindValue(':mezzanine', $locaux->mezzanine());
		$query->bindValue(':status', $locaux->status());
		$query->bindValue(':idProjet', $locaux->idProjet());
		$query->bindValue(':par', $locaux->par());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Locaux $locaux){
		$query = $this->_db->prepare('UPDATE t_locaux SET nom=:nom, superficie=:superficie, facade=:facade, prix=:prix, 
		mezzanine=:mezzanine, status=:status WHERE id=:idLocaux') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idLocaux', $locaux->id());
		$query->bindValue(':nom', $locaux->nom());
		$query->bindValue(':superficie', $locaux->superficie());
		$query->bindValue(':facade', $locaux->facade());
		$query->bindValue(':prix', $locaux->prix());
		$query->bindValue(':mezzanine', $locaux->mezzanine());
		$query->bindValue(':status', $locaux->status());
        $query->execute();
        $query->closeCursor();
	}

	public function updatePar($par, $idLocaux){
		$query = $this->_db->prepare('
		UPDATE t_locaux SET par=:par WHERE id=:idLocaux') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idLocaux', $idLocaux);
		$query->bindValue(':par', $par);
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idLocaux){
		$query = $this->_db->prepare('DELETE FROM t_locaux WHERE id=:idLocaux')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idLocaux', $idLocaux);
		$query->execute();
		$query->closeCursor();
	}
	
	public function changeStatus($id, $status){
        $query = $this->_db->prepare('UPDATE t_locaux SET status=:status WHERE id=:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':status', $status);
        $query->bindValue(':id', $id);
        $query->execute();
        $query->closeCursor();
    }
	
	public function getLocauxNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS locauxNumber FROM t_locaux WHERE idProjet=:idProjet')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['locauxNumber'];
    }
	
	public function getLocauxReserveNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS locauxNumber FROM t_locaux 
        WHERE idProjet=:idProjet AND status="reserve"')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['locauxNumber'];
    }

	public function getLocauxById($id){
        $query = $this->_db->prepare('SELECT * FROM t_locaux WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Locaux($data);
    }

	public function getLocauxByIdProjet($idProjet, $begin , $end){
        $locaux = array();
        $query = $this->_db->prepare('SELECT * FROM t_locaux WHERE idProjet=:idProjet ORDER BY id DESC
        LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$locaux[] = new Locaux($data);
        }
        $query->closeCursor();
        return $locaux;
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_locaux ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($nom){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_locaux WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nom, ' ', '') ");
        $query->execute(array(':nom' => $nom));
        //get result
        return $query->fetchColumn();
    }
}
