CREATE TABLE IF NOT EXISTS t_annuaire (
	id INT(11) NOT NULL AUTO_INCREMENT,
	nom VARCHAR(100) DEFAULT NULL,
	description TEXT DEFAULT NULL,
	telephone1 VARCHAR(50) DEFAULT NULL,
	telephone2 VARCHAR(50) DEFAULT NULL,
	created DATETIME DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	updated DATETIME DEFAULT NULL,
	updatedBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;