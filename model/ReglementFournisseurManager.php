<?php
class ReglementFournisseurManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD ReglementFournisseurs
    public function add(ReglementFournisseur $reglementFournisseur){
        $query = $this->_db->prepare('INSERT INTO t_reglement_fournisseur 
        (dateReglement, montant, idProjet, idFournisseur, modePaiement, numeroCheque)
        VALUES (:dateReglement, :montant, :idProjet, :idFournisseur, :modePaiement, :numeroCheque)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':dateReglement', $reglementFournisseur->dateReglement());
        $query->bindValue(':montant', $reglementFournisseur->montant());
        $query->bindValue(':idProjet', $reglementFournisseur->idProjet());
		$query->bindValue(':idFournisseur', $reglementFournisseur->idFournisseur());
		$query->bindValue(':modePaiement', $reglementFournisseur->modePaiement());
		$query->bindValue(':numeroCheque', $reglementFournisseur->numeroCheque());
        $query->execute();
        $query->closeCursor();
    }
    
    public function update(ReglementFournisseur $reglementFournisseur){
        $query = $this->_db->prepare('UPDATE t_reglement_fournisseur SET dateReglement=:dateReglement, 
        montant=:montant, idProjet=:idProjet, modePaiement=:modePaiement WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':dateReglement', $reglementFournisseur->dateReglement());
        $query->bindValue(':montant', $reglementFournisseur->montant());
		$query->bindValue(':modePaiement', $reglementFournisseur->modePaiement());
		$query->bindValue(':idProjet', $reglementFournisseur->idProjet());
        $query->bindValue(':id', $reglementFournisseur->id());
        $query->execute();
        $query->closeCursor();
    }
	
	public function updateNumeroCheque($numeroCheque, $idReglement){
        $query = $this->_db->prepare('UPDATE t_reglement_fournisseur SET numeroCheque=:numeroCheque WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idReglement);
		$query->bindValue(':numeroCheque', $numeroCheque);
        $query->execute();
        $query->closeCursor();
    }
	
	public function delete($idReglementFournisseur){
        $query = $this->_db->prepare('DELETE FROM t_reglement_fournisseur WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idReglementFournisseur);
        $query->execute();
        $query->closeCursor();
    }
    
    public function getReglementFournisseursByIdFournisseur($idFournisseur){
        $reglementFournisseurs = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE idFournisseur=:idFournisseur 
        ORDER BY id DESC');
        $query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $reglementFournisseurs[] = new ReglementFournisseur($data);
        }
        $query->closeCursor();
        return $reglementFournisseurs;
    }
	
	public function getReglementFournisseursByIdProjet($idProjet){
        $reglementFournisseurs = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE idProjet=:idProjet 
        ORDER BY dateReglement DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $reglementFournisseurs[] = new ReglementFournisseur($data);
        }
        $query->closeCursor();
        return $reglementFournisseurs;
    }
    
	public function sommeReglementFournisseurByIdProjetAndIdFournisseur($idProjet, $idFournisseur){
        $query = $this->_db->prepare('SELECT SUM(montant) AS total FROM t_reglement_fournisseur 
        WHERE idProjet=:idProjet AND idFournisseur=:idFournisseur');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
        return $data['total'];
    }
	
    public function sommeReglementFournisseurByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT SUM(montant) AS total FROM t_reglement_fournisseur 
        WHERE idProjet=:idProjet');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
        return $data['total'];
    }
    
    public function sommeReglementFournisseursByIdFournisseur($idFournisseur){
        $query = $this->_db->prepare('SELECT sum(montant) AS somme 
        FROM t_reglement_fournisseur WHERE idFournisseur =:idFournisseur');
        $query->bindValue('idFournisseur', $idFournisseur);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['somme'];
    }

    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_reglement_fournisseur ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
    public function getReglementFournisseurById($id){
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE id =:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new ReglementFournisseur($data);
    }
	
	public function getReglementNumberTous($idProjet){
		$query = $this->_db->prepare('SELECT count(id) AS nombreReglements 
        FROM t_reglement_fournisseur WHERE idProjet =:idProjet');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nombreReglements'];
	}
	
	public function getReglementsNumberByIdFournisseur($idProjet, $idFournisseur){
        $query = $this->_db->prepare('SELECT count(id) AS nombreReglements 
        FROM t_reglement_fournisseur WHERE idProjet =:idProjet AND idFournisseur=:idFournisseur');
        $query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nombreReglements'];
    }
	
	public function getIdFournisseurs($idProjet){
		$idFournisseurs = array();
		$query = $this->_db->prepare('SELECT DISTINCT idFournisseur FROM t_reglement_fournisseur WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$idFournisseurs[] = $data['idFournisseur'];  
        }
        $query->closeCursor();
        return $idFournisseurs;
	}

	public function getReglementTousByLimits($idProjet, $begin, $end){
		$reglementFournisseurs = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE idProjet=:idProjet 
        ORDER BY id DESC LIMIT '.$begin.', '.$end);
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $reglementFournisseurs[] = new ReglementFournisseur($data);
        }
        $query->closeCursor();
        return $reglementFournisseurs;		
	}
	
	public function getReglementTous($idProjet){
		$reglementFournisseurs = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE idProjet=:idProjet 
        ORDER BY id DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $reglementFournisseurs[] = new ReglementFournisseur($data);
        }
        $query->closeCursor();
        return $reglementFournisseurs;		
	}
	
	public function getTotalReglementTous($idProjet){
        $query = $this->_db->prepare('SELECT SUM(montant) AS total FROM t_reglement_fournisseur WHERE idProjet=:idProjet');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];		
	}
	
	public function getReglementFournisseurByLimits($idProjet, $idFournisseur, $begin, $end){
		$reglementFournisseurs = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE idProjet=:idProjet 
        AND idFournisseur=:idFournisseur ORDER BY id DESC LIMIT '.$begin.', '.$end);
        $query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $reglementFournisseurs[] = new ReglementFournisseur($data);
        }
        $query->closeCursor();
        return $reglementFournisseurs;
	}
	
	public function getReglementFournisseur($idProjet, $idFournisseur){
		$reglementFournisseurs = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE idProjet=:idProjet 
        AND idFournisseur=:idFournisseur ORDER BY id DESC');
        $query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $reglementFournisseurs[] = new ReglementFournisseur($data);
        }
        $query->closeCursor();
        return $reglementFournisseurs;
	}
	
	public function getTotalReglementFournisseur($idProjet, $idFournisseur){
        $query = $this->_db->prepare('SELECT SUM(montant) AS total FROM t_reglement_fournisseur WHERE idProjet=:idProjet 
        AND idFournisseur=:idFournisseur');
        $query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
	}
	
	public function getTotalReglementByIdFournisseur($idFournisseur){
        $query = $this->_db->prepare('SELECT SUM(montant) AS total FROM t_reglement_fournisseur WHERE 
        idFournisseur=:idFournisseur');
		$query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
	}
	
	//new functions: after MerlaTrav meeting
	public function getReglementFournisseursByIdFournisseurByLimits($idFournisseur, $begin, $end){
        $reglementFournisseurs = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglement_fournisseur WHERE idFournisseur=:idFournisseur 
        ORDER BY id DESC LIMIT '.$begin.' ,'.$end);
        $query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $reglementFournisseurs[] = new ReglementFournisseur($data);
        }
        $query->closeCursor();
        return $reglementFournisseurs;
    }

	public function getReglementsNumberByIdFournisseurOnly($idFournisseur){
        $query = $this->_db->prepare('SELECT count(id) AS nombreReglements 
        FROM t_reglement_fournisseur WHERE idFournisseur=:idFournisseur');
		$query->bindValue(':idFournisseur', $idFournisseur);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nombreReglements'];
    }
	public function getTotalReglement(){
        $query = $this->_db->query('SELECT SUM(montant) AS total FROM t_reglement_fournisseur');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
	}
	
	//new functions
	//add to ReglementFournisseurManager class on 
	//http://merlatrav.esy.es
	public function sommeReglementFournisseursByIdFournisseurByProjet($idFournisseur, $idProjet){
        $query = $this->_db->prepare('SELECT SUM(montant) AS total 
        FROM t_reglement_fournisseur WHERE idFournisseur =:idFournisseur AND idProjet=:idProjet');
        $query->bindValue(':idFournisseur', $idFournisseur);
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
}
