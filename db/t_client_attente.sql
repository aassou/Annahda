CREATE TABLE IF NOT EXISTS t_clientattente (
	id INT(11) NOT NULL AUTO_INCREMENT,
	nom VARCHAR(255) DEFAULT NULL,
	date DATE DEFAULT NULL,
	bien VARCHAR(50) DEFAULT NULL,
	prix VARCHAR(255) DEFAULT NULL,
	superficie VARCHAR(255) DEFAULT NULL,
	emplacementVente VARCHAR(100) DEFAULT NULL,
	emplacementAchat VARCHAR(100) DEFAULT NULL,
	created DATETIME DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	updated DATETIME DEFAULT NULL,
	updatedBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;