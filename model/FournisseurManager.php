<?php
class FournisseurManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Fournisseur $fournisseur){
        $query = $this->_db->prepare('INSERT INTO t_fournisseur (nom, adresse, email, telephone1, 
        telephone2, fax, dateCreation, code)
        VALUES (:nom, :adresse, :email, :telephone1, :telephone2, :fax, :dateCreation, :code)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $fournisseur->nom());
        $query->bindValue(':adresse', $fournisseur->adresse());
        $query->bindValue(':email', $fournisseur->email());
        $query->bindValue(':telephone1', $fournisseur->telephone1());
        $query->bindValue(':telephone2', $fournisseur->telephone2());
        $query->bindValue(':fax', $fournisseur->fax());
        $query->bindValue(':dateCreation', $fournisseur->dateCreation());
		$query->bindValue(':code', $fournisseur->code());
        $query->execute();
        $query->closeCursor();
    }
    
    public function update(Fournisseur $fournisseur){
        $query = $this->_db->prepare('UPDATE t_fournisseur SET nom=:nom, adresse=:adresse,
        email=:email, telephone1=:telephone1, telephone2=:telephone2, fax=:fax 
        WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $fournisseur->nom());
        $query->bindValue(':adresse', $fournisseur->adresse());
        $query->bindValue(':email', $fournisseur->email());
        $query->bindValue(':telephone1', $fournisseur->telephone1());
        $query->bindValue(':telephone2', $fournisseur->telephone2());
        $query->bindValue(':fax', $fournisseur->fax());
        $query->bindValue(':id', $fournisseur->id());
        $query->execute();
        $query->closeCursor();
    }

	public function delete($idFournisseur){
		$query = $this->_db->prepare('DELETE FROM t_fournisseur WHERE id=:idFournisseur')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idFournisseur', $idFournisseur);
		$query->execute();
		$query->closeCursor();
	}
    
	public function getFournisseurBySearch($recherche){
		$query = "";	
		$query = $this->_db->prepare("SELECT * FROM t_fournisseur WHERE nom LIKE :recherche");
		$query->bindValue(':recherche', '%'.$recherche.'%');
		$query->execute();
        $fournisseurs = array();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $fournisseurs[] = new Fournisseur($data);
        }
        $query->closeCursor();
        return $fournisseurs;
	}
	
	public function getOneFournisseurBySearch($recherche){
		$query = $this->_db->prepare("SELECT id FROM t_fournisseur WHERE id=:idFournisseur");
		$query->bindValue(':idFournisseur', $recherche);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['id'];
	}
	
    public function getFournisseurNumbers(){
        $query = $this->_db->query('SELECT COUNT(*) AS fournisseurNumbers FROM t_fournisseur');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['fournisseurNumbers'];
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_fournisseur ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
    public function getFournisseurs(){
        $fournisseurs = array();
        $query = $this->_db->query('SELECT * FROM t_fournisseur ORDER BY id DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $fournisseurs[] = new Fournisseur($data);
        }
        $query->closeCursor();
        return $fournisseurs;
    }
	
	public function getFournisseursByLimits($begin, $end){
        $fournisseurs = array();
        $query = $this->_db->query('SELECT * FROM t_fournisseur ORDER BY id DESC LIMIT '.$begin.' ,'.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $fournisseurs[] = new Fournisseur($data);
        }
        $query->closeCursor();
        return $fournisseurs;
    }
    
    public function getFournisseurById($id){
        $query = $this->_db->prepare('SELECT * FROM t_fournisseur WHERE id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Fournisseur($data);
    }
    
    public function getFournisseurNameById($id){
        $query = $this->_db->prepare('SELECT nom FROM t_fournisseur WHERE id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nom'];
    }
	
	public function getFournisseurByCode($code){
        $query = $this->_db->prepare('SELECT * FROM t_fournisseur WHERE code=:code');
        $query->bindValue(':code', $code);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Fournisseur($data);
    }
	
	public function getCodeFournisseur($code){
        $query = $this->_db->prepare('SELECT code FROM t_fournisseur WHERE code=:code');
		$query->bindValue(':code', $code);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['code'];
    }
	
	public function exists($nom){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_fournisseur WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nom, ' ', '') ");
        $query->execute(array(':nom' => $nom));
        //get result
        return $query->fetchColumn();
    }
    
}