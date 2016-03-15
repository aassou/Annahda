CREATE TABLE IF NOT EXISTS t_commande (
	id INT(11) NOT NULL AUTO_INCREMENT,
	idFournisseur INT(12) DEFAULT NULL,
	idProjet INT(12) DEFAULT NULL,
	dateCommande DATE DEFAULT NULL,
	numeroCommande VARCHAR(50) DEFAULT NULL,
	designation VARCHAR(255) DEFAULT NULL,
	status INT(12) DEFAULT NULL,
	codeLivraison VARCHAR(255) DEFAULT NULL,
	created DATETIME DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	updated DATETIME DEFAULT NULL,
	updatedBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;