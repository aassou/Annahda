
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE t_alert (
  id int(11) NOT NULL,
  alert text DEFAULT NULL,
  status int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_annuaire (
  id int(11) NOT NULL,
  nom varchar(100) DEFAULT NULL,
  description text DEFAULT NULL,
  telephone1 varchar(50) DEFAULT NULL,
  telephone2 varchar(50) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE t_appartement (
  id int(11) NOT NULL,
  nom varchar(45) DEFAULT NULL,
  superficie decimal(10,2) DEFAULT NULL,
  prix decimal(10,2) DEFAULT NULL,
  montantRevente decimal(12,2) DEFAULT NULL,
  niveau varchar(45) DEFAULT NULL,
  facade varchar(45) DEFAULT NULL,
  nombrePiece varchar(45) DEFAULT NULL,
  status varchar(45) DEFAULT NULL,
  cave varchar(45) DEFAULT NULL,
  idProjet int(11) DEFAULT NULL,
  par varchar(255) DEFAULT NULL,
  titre varchar(255) DEFAULT NULL,
  superficie2 decimal(10,2) DEFAULT NULL,
  prixDeclare decimal(10,2) DEFAULT NULL,
  avancePrixDeclare decimal(10,2) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_bien (
  id int(11) NOT NULL,
  numero varchar(45) DEFAULT NULL,
  etage varchar(45) DEFAULT NULL,
  superficie decimal(10,2) DEFAULT NULL,
  facade varchar(45) DEFAULT NULL,
  reserve varchar(10) DEFAULT NULL,
  idProjet int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_bug (
  id int(11) NOT NULL,
  bug text DEFAULT NULL,
  lien text DEFAULT NULL,
  status int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_caisse (
  id int(11) NOT NULL,
  type varchar(50) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  destination varchar(50) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_caisse_entrees (
  id int(11) NOT NULL,
  montant decimal(12,2) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  utilisateur varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_caisse_iaaza (
  id int(11) NOT NULL,
  type varchar(50) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  destination varchar(50) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_caisse_sorties (
  id int(11) NOT NULL,
  montant decimal(12,2) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  destination varchar(255) DEFAULT NULL,
  utilisateur varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_charge (
  id int(11) NOT NULL,
  type varchar(100) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  societe varchar(50) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  idProjet int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_chargesyndique (
  id int(11) NOT NULL,
  type varchar(100) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  societe varchar(50) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  idProjet int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_charge_commun (
  id int(11) NOT NULL,
  type varchar(100) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  societe varchar(50) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE t_client (
  id int(11) NOT NULL,
  nom varchar(100) DEFAULT NULL,
  nomArabe varchar(255) DEFAULT NULL,
  adresse varchar(255) DEFAULT NULL,
  adresseArabe varchar(255) DEFAULT NULL,
  telephone1 varchar(45) DEFAULT NULL,
  telephone2 varchar(45) DEFAULT NULL,
  cin varchar(45) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  facebook varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  code text DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_clientattente (
  id int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  tel varchar(30) DEFAULT NULL,
  date date DEFAULT NULL,
  bien varchar(50) DEFAULT NULL,
  prix varchar(255) DEFAULT NULL,
  superficie varchar(255) DEFAULT NULL,
  emplacementVente varchar(100) DEFAULT NULL,
  emplacementAchat varchar(100) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_clientclassement (
  id int(11) NOT NULL,
  nom varchar(50) DEFAULT NULL,
  classement int(2) DEFAULT NULL,
  remarque text DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_collaboration (
  id int(11) NOT NULL,
  titre varchar(50) DEFAULT NULL,
  description text DEFAULT NULL,
  status varchar(5) DEFAULT NULL,
  duree varchar(20) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_commande (
  id int(11) NOT NULL,
  idFournisseur int(12) DEFAULT NULL,
  idProjet int(12) DEFAULT NULL,
  dateCommande date DEFAULT NULL,
  numeroCommande varchar(50) DEFAULT NULL,
  designation varchar(255) DEFAULT NULL,
  status int(12) DEFAULT NULL,
  codeLivraison varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_commandedetail (
  id int(11) NOT NULL,
  reference varchar(100) DEFAULT NULL,
  libelle varchar(50) DEFAULT NULL,
  quantite decimal(12,2) DEFAULT NULL,
  idCommande int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_commission (
  id int(11) NOT NULL,
  titre text DEFAULT NULL,
  commissionnaire varchar(50) DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  codeContrat varchar(255) DEFAULT NULL,
  date date DEFAULT NULL,
  etat varchar(50) DEFAULT NULL,
  status varchar(50) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_company (
  id int(11) NOT NULL,
  nom varchar(50) DEFAULT NULL,
  adresse varchar(255) DEFAULT NULL,
  nomArabe varchar(50) DEFAULT NULL,
  adresseArabe varchar(255) DEFAULT NULL,
  directeur varchar(50) DEFAULT NULL,
  cinDirecteur varchar(30) DEFAULT NULL,
  rc varchar(100) DEFAULT NULL,
  ifs varchar(100) DEFAULT NULL,
  patente varchar(100) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_comptebancaire (
  id int(11) NOT NULL,
  numero varchar(50) DEFAULT NULL,
  denomination varchar(255) DEFAULT NULL,
  dateCreation date DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_conge_employe_projet (
  id int(11) NOT NULL,
  dateDebut date DEFAULT NULL,
  dateFin date DEFAULT NULL,
  idEmploye int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_conge_employe_societe (
  id int(11) NOT NULL,
  dateDebut date DEFAULT NULL,
  dateFin date DEFAULT NULL,
  idEmploye int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_contrat (
  id int(11) NOT NULL,
  reference varchar(255) DEFAULT NULL,
  numero varchar(255) DEFAULT NULL,
  dateCreation date DEFAULT NULL,
  prixVente decimal(12,2) DEFAULT NULL,
  avance decimal(12,2) DEFAULT NULL,
  prixVenteArabe varchar(255) DEFAULT NULL,
  avanceArabe varchar(255) DEFAULT NULL,
  modePaiement varchar(255) DEFAULT NULL,
  dureePaiement int(11) DEFAULT NULL,
  nombreMois int(11) DEFAULT NULL,
  echeance decimal(12,2) DEFAULT NULL,
  note text DEFAULT NULL,
  observationClient text DEFAULT NULL,
  imageNote text DEFAULT NULL,
  idClient int(11) DEFAULT NULL,
  idProjet int(11) DEFAULT NULL,
  idBien int(11) DEFAULT NULL,
  typeBien varchar(255) DEFAULT NULL,
  code varchar(255) DEFAULT NULL,
  status varchar(255) DEFAULT NULL,
  revendre int(2) DEFAULT NULL,
  numeroCheque varchar(255) DEFAULT NULL,
  societeArabe int(11) DEFAULT NULL,
  etatBienArabe varchar(100) DEFAULT NULL,
  facadeArabe varchar(50) DEFAULT NULL,
  articlesArabes text DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE t_contratcaslibre (
  id int(11) NOT NULL,
  date date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  observation text DEFAULT NULL,
  status int(2) DEFAULT NULL,
  codeContrat varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_contratdetails (
  id int(11) NOT NULL,
  dateOperation date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  numeroCheque varchar(100) DEFAULT NULL,
  idContratEmploye int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_contratemploye (
  id int(11) NOT NULL,
  dateContrat date DEFAULT NULL,
  dateFinContrat date DEFAULT NULL,
  prixUnitaire decimal(10,2) DEFAULT NULL,
  unite varchar(30) DEFAULT NULL,
  nomUnite varchar(50) DEFAULT NULL,
  nomUniteArabe varchar(100) DEFAULT NULL,
  traveaux varchar(100) DEFAULT NULL,
  traveauxArabe varchar(100) DEFAULT NULL,
  articlesArabes text DEFAULT NULL,
  nombreUnites decimal(10,2) DEFAULT NULL,
  prixUnitaire2 decimal(10,2) DEFAULT NULL,
  unite2 varchar(30) DEFAULT NULL,
  nomUnite2 varchar(50) DEFAULT NULL,
  nomUniteArabe2 varchar(100) DEFAULT NULL,
  nombreUnites2 decimal(10,2) DEFAULT NULL,
  total decimal(12,2) DEFAULT NULL,
  employe varchar(100) DEFAULT NULL,
  idSociete int(11) DEFAULT NULL,
  idProjet int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_contrattravail (
  id int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  cin varchar(50) DEFAULT NULL,
  adresse text DEFAULT NULL,
  dateNaissance varchar(25) DEFAULT NULL,
  matiere varchar(100) DEFAULT NULL,
  prix decimal(12,2) DEFAULT NULL,
  mesure decimal(12,2) DEFAULT NULL,
  prixTotal decimal(12,2) DEFAULT NULL,
  dateContrat date DEFAULT NULL,
  idProjet int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_contrattravailreglement (
  id int(11) NOT NULL,
  montant decimal(12,2) DEFAULT NULL,
  motif text DEFAULT NULL,
  dateReglement date DEFAULT NULL,
  idContratTravail int(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_employe (
  id int(11) NOT NULL,
  nom varchar(50) DEFAULT NULL,
  adresse varchar(255) DEFAULT NULL,
  nomArabe varchar(50) DEFAULT NULL,
  adresseArabe varchar(255) DEFAULT NULL,
  cin varchar(50) DEFAULT NULL,
  telephone varchar(50) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_employe_projet (
  id int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  cin varchar(100) DEFAULT NULL,
  photo text DEFAULT NULL,
  telephone varchar(45) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  etatCivile varchar(45) DEFAULT NULL,
  dateDebut date DEFAULT NULL,
  dateSortie date DEFAULT NULL,
  idProjet int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_employe_societe (
  id int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  cin varchar(100) DEFAULT NULL,
  photo text DEFAULT NULL,
  telephone varchar(45) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  etatCivile varchar(45) DEFAULT NULL,
  dateDebut date DEFAULT NULL,
  dateSortie date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_fournisseur (
  id int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  adresse varchar(255) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  telephone1 varchar(45) DEFAULT NULL,
  telephone2 varchar(45) DEFAULT NULL,
  fax varchar(45) DEFAULT NULL,
  dateCreation date DEFAULT NULL,
  code varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_history (
  id int(11) NOT NULL,
  action varchar(50) DEFAULT NULL,
  target varchar(50) DEFAULT NULL,
  description text DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_livraison (
  id int(11) NOT NULL,
  libelle varchar(50) NOT NULL,
  status int(11) DEFAULT NULL,
  designation text NOT NULL,
  quantite decimal(12,2) NOT NULL,
  prixUnitaire decimal(10,2) NOT NULL,
  paye decimal(10,2) NOT NULL,
  reste decimal(10,2) NOT NULL,
  dateLivraison date NOT NULL,
  modePaiement varchar(50) NOT NULL,
  idFournisseur int(11) NOT NULL,
  idProjet int(11) NOT NULL,
  code varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_livraison_detail (
  id int(11) NOT NULL,
  libelle varchar(255) DEFAULT NULL,
  designation text DEFAULT NULL,
  prixUnitaire decimal(12,2) DEFAULT NULL,
  quantite decimal(12,2) DEFAULT NULL,
  idLivraison int(11) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_livraison_detail_iaaza (
  id int(11) NOT NULL,
  type int(2) DEFAULT NULL,
  designation text DEFAULT NULL,
  prixUnitaire decimal(12,2) DEFAULT NULL,
  quantite decimal(12,2) DEFAULT NULL,
  idLivraison int(11) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_livraison_iaaza (
  id int(11) NOT NULL,
  libelle varchar(50) NOT NULL,
  status int(11) DEFAULT NULL,
  type int(2) DEFAULT NULL,
  designation text NOT NULL,
  quantite decimal(12,2) NOT NULL,
  prixUnitaire decimal(10,2) NOT NULL,
  paye decimal(10,2) NOT NULL,
  reste decimal(10,2) NOT NULL,
  dateLivraison date NOT NULL,
  modePaiement varchar(50) NOT NULL,
  idFournisseur int(11) NOT NULL,
  idProjet int(11) NOT NULL,
  code varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_locaux (
  id int(11) NOT NULL,
  nom varchar(45) DEFAULT NULL,
  superficie decimal(10,2) DEFAULT NULL,
  facade varchar(45) DEFAULT NULL,
  prix decimal(10,2) DEFAULT NULL,
  montantRevente decimal(12,2) DEFAULT NULL,
  mezzanine varchar(45) DEFAULT NULL,
  status varchar(45) DEFAULT NULL,
  idProjet int(11) DEFAULT NULL,
  par varchar(255) DEFAULT NULL,
  titre varchar(255) DEFAULT NULL,
  superficie2 decimal(10,2) DEFAULT NULL,
  prixDeclare decimal(10,2) DEFAULT NULL,
  avancePrixDeclare decimal(10,2) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table t_mail
--

CREATE TABLE t_mail (
  id int(11) NOT NULL,
  content text NOT NULL,
  sender varchar(50) NOT NULL,
  created datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_notes_client (
  id int(11) NOT NULL,
  note text DEFAULT NULL,
  created date DEFAULT NULL,
  idProjet int(11) DEFAULT NULL,
  codeContrat varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_operation (
  id int(11) NOT NULL,
  reference varchar(255) DEFAULT NULL,
  date date DEFAULT NULL,
  dateReglement date DEFAULT NULL,
  compteBancaire varchar(50) DEFAULT NULL,
  observation text DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  modePaiement varchar(255) DEFAULT NULL,
  idContrat int(11) DEFAULT NULL,
  numeroCheque varchar(255) DEFAULT NULL,
  status int(2) DEFAULT NULL,
  url varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_parking (
  id int(11) NOT NULL,
  code int(12) DEFAULT NULL,
  status varchar(50) DEFAULT NULL,
  idProjet int(12) DEFAULT NULL,
  idContrat int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_pieces_appartement (
  id int(11) NOT NULL,
  nom varchar(45) DEFAULT NULL,
  url varchar(255) DEFAULT NULL,
  idAppartement int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_pieces_livraison (
  id int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  url text DEFAULT NULL,
  idLivraison int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_pieces_locaux (
  id int(11) NOT NULL,
  nom varchar(45) DEFAULT NULL,
  url varchar(255) DEFAULT NULL,
  idLocaux int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_pieces_terrain (
  id int(11) NOT NULL,
  nom varchar(45) DEFAULT NULL,
  url varchar(255) DEFAULT NULL,
  idTerrain int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_projet (
  id int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  orders float DEFAULT NULL,
  titre varchar(255) DEFAULT NULL,
  adresse varchar(255) DEFAULT NULL,
  superficie decimal(10,2) DEFAULT NULL,
  description text DEFAULT NULL,
  budget decimal(12,2) DEFAULT NULL,
  numeroLot varchar(255) DEFAULT NULL,
  numeroAutorisation varchar(255) DEFAULT NULL,
  dateAutorisation date DEFAULT NULL,
  nombreEtages int(11) DEFAULT NULL,
  sousSol decimal(9,2) DEFAULT NULL,
  rezDeChausser decimal(9,2) DEFAULT NULL,
  mezzanin decimal(9,2) DEFAULT NULL,
  cageEscalier decimal(9,2) DEFAULT NULL,
  terrase decimal(9,2) DEFAULT NULL,
  superficieEtages decimal(9,2) DEFAULT NULL,
  delai int(11) DEFAULT NULL,
  prixParMetreTTC decimal(9,2) DEFAULT NULL,
  prixParMetreHT decimal(9,2) DEFAULT NULL,
  TVA decimal(9,2) DEFAULT NULL,
  architecte text DEFAULT NULL,
  bet text DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(60) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(60) DEFAULT NULL,
  nomArabe varchar(100) DEFAULT NULL,
  adresseArabe varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_reglementprevu (
  id int(11) NOT NULL,
  datePrevu date DEFAULT NULL,
  codeContrat varchar(255) DEFAULT NULL,
  status int(2) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table t_reglement_fournisseur
--

CREATE TABLE t_reglement_fournisseur (
  id int(11) NOT NULL,
  montant decimal(12,2) DEFAULT NULL,
  dateReglement date DEFAULT NULL,
  idProjet int(11) DEFAULT NULL,
  idFournisseur int(11) DEFAULT NULL,
  modePaiement varchar(255) DEFAULT NULL,
  numeroCheque varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_reglement_fournisseur_iaaza (
  id int(11) NOT NULL,
  montant decimal(12,2) DEFAULT NULL,
  dateReglement date DEFAULT NULL,
  idProjet int(11) DEFAULT NULL,
  idFournisseur int(11) DEFAULT NULL,
  modePaiement varchar(255) DEFAULT NULL,
  numeroCheque varchar(255) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_relevebancaire (
  id int(11) NOT NULL,
  dateOpe varchar(12) DEFAULT NULL,
  dateVal varchar(12) DEFAULT NULL,
  libelle varchar(255) DEFAULT NULL,
  reference varchar(50) DEFAULT NULL,
  debit decimal(12,2) DEFAULT NULL,
  credit decimal(12,2) DEFAULT NULL,
  projet varchar(50) DEFAULT NULL,
  idCompteBancaire int(11) DEFAULT NULL,
  status int(2) NOT NULL DEFAULT 0,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_salaires_projet (
  id int(11) NOT NULL,
  salaire decimal(12,2) DEFAULT NULL,
  nombreJours decimal(12,2) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  idEmploye int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_salaires_societe (
  id int(11) NOT NULL,
  salaire decimal(12,2) DEFAULT NULL,
  prime decimal(12,2) DEFAULT NULL,
  dateOperation date DEFAULT NULL,
  idEmploye int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_syndique (
  id int(11) NOT NULL,
  date date DEFAULT NULL,
  montant decimal(12,2) DEFAULT NULL,
  status varchar(20) DEFAULT NULL,
  idClient int(12) DEFAULT NULL,
  idProjet int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_task (
  id int(11) NOT NULL,
  user varchar(50) DEFAULT NULL,
  content text DEFAULT NULL,
  status int(12) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_terrain (
  id int(11) NOT NULL,
  prix decimal(12,2) DEFAULT NULL,
  vendeur varchar(100) DEFAULT NULL,
  fraisAchat decimal(12,2) DEFAULT NULL,
  superficie decimal(12,2) DEFAULT NULL,
  emplacement text DEFAULT NULL,
  idProjet int(11) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_todo (
  id int(11) NOT NULL,
  todo varchar(255) DEFAULT NULL,
  priority int(2) NOT NULL DEFAULT 0,
  status int(12) DEFAULT NULL,
  date date DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_typecharge (
  id int(11) NOT NULL,
  nom varchar(100) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_typechargesyndique (
  id int(11) NOT NULL,
  nom varchar(100) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_typecharge_commun (
  id int(11) NOT NULL,
  nom varchar(100) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE t_typeSyndique (
  id int(11) NOT NULL,
  designation varchar(255) DEFAULT NULL,
  frais decimal(12,2) DEFAULT NULL,
  created datetime DEFAULT NULL,
  createdBy varchar(50) DEFAULT NULL,
  updated datetime DEFAULT NULL,
  updatedBy varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE t_user (
  id int(11) NOT NULL,
  login varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  created date NOT NULL,
  profil varchar(30) NOT NULL,
  status int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for table t_alert
--
ALTER TABLE t_alert
  ADD PRIMARY KEY (id);
ALTER TABLE t_annuaire
  ADD PRIMARY KEY (id);
ALTER TABLE t_appartement
  ADD PRIMARY KEY (id);
ALTER TABLE t_bien
  ADD PRIMARY KEY (id);
ALTER TABLE t_bug
  ADD PRIMARY KEY (id);
ALTER TABLE t_caisse
  ADD PRIMARY KEY (id);
ALTER TABLE t_caisse_entrees
  ADD PRIMARY KEY (id);
ALTER TABLE t_caisse_iaaza
  ADD PRIMARY KEY (id);
ALTER TABLE t_caisse_sorties
  ADD PRIMARY KEY (id);
ALTER TABLE t_charge
  ADD PRIMARY KEY (id);
ALTER TABLE t_chargesyndique
  ADD PRIMARY KEY (id);
ALTER TABLE t_charge_commun
  ADD PRIMARY KEY (id);
ALTER TABLE t_client
  ADD PRIMARY KEY (id);
ALTER TABLE t_clientattente
  ADD PRIMARY KEY (id);
ALTER TABLE t_clientclassement
  ADD PRIMARY KEY (id);
ALTER TABLE t_collaboration
  ADD PRIMARY KEY (id);
ALTER TABLE t_commande
  ADD PRIMARY KEY (id);
ALTER TABLE t_commandedetail
  ADD PRIMARY KEY (id);
ALTER TABLE t_commission
  ADD PRIMARY KEY (id);
ALTER TABLE t_company
  ADD PRIMARY KEY (id);
ALTER TABLE t_comptebancaire
  ADD PRIMARY KEY (id);
ALTER TABLE t_conge_employe_projet
  ADD PRIMARY KEY (id);
ALTER TABLE t_conge_employe_societe
  ADD PRIMARY KEY (id);
ALTER TABLE t_contrat
  ADD PRIMARY KEY (id);
ALTER TABLE t_contratcaslibre
  ADD PRIMARY KEY (id);
ALTER TABLE t_contratdetails
  ADD PRIMARY KEY (id);
ALTER TABLE t_contratemploye
  ADD PRIMARY KEY (id);
ALTER TABLE t_contrattravail
  ADD PRIMARY KEY (id);
ALTER TABLE t_contrattravailreglement
  ADD PRIMARY KEY (id);
ALTER TABLE t_employe
  ADD PRIMARY KEY (id);
ALTER TABLE t_employe_projet
  ADD PRIMARY KEY (id);
ALTER TABLE t_employe_societe
  ADD PRIMARY KEY (id);
ALTER TABLE t_fournisseur
  ADD PRIMARY KEY (id);
ALTER TABLE t_history
  ADD PRIMARY KEY (id);
ALTER TABLE t_livraison
  ADD PRIMARY KEY (id);
ALTER TABLE t_livraison_detail
  ADD PRIMARY KEY (id);
ALTER TABLE t_livraison_detail_iaaza
  ADD PRIMARY KEY (id);
ALTER TABLE t_livraison_iaaza
  ADD PRIMARY KEY (id);
ALTER TABLE t_locaux
  ADD PRIMARY KEY (id);
ALTER TABLE t_mail
  ADD PRIMARY KEY (id);
ALTER TABLE t_notes_client
  ADD PRIMARY KEY (id);
ALTER TABLE t_operation
  ADD PRIMARY KEY (id);
ALTER TABLE t_parking
  ADD PRIMARY KEY (id)
ALTER TABLE t_pieces_appartement
  ADD PRIMARY KEY (id);
ALTER TABLE t_pieces_livraison
  ADD PRIMARY KEY (id);
ALTER TABLE t_pieces_locaux
  ADD PRIMARY KEY (id);
ALTER TABLE t_pieces_terrain
  ADD PRIMARY KEY (id);
ALTER TABLE t_projet
  ADD PRIMARY KEY (id);
ALTER TABLE t_reglementprevu
  ADD PRIMARY KEY (id);
ALTER TABLE t_reglement_fournisseur
  ADD PRIMARY KEY (id);
ALTER TABLE t_reglement_fournisseur_iaaza
  ADD PRIMARY KEY (id);
ALTER TABLE t_relevebancaire
  ADD PRIMARY KEY (id);
ALTER TABLE t_salaires_projet
  ADD PRIMARY KEY (id);
ALTER TABLE t_salaires_societe
  ADD PRIMARY KEY (id);
ALTER TABLE t_syndique
  ADD PRIMARY KEY (id);
ALTER TABLE t_task
  ADD PRIMARY KEY (id);
ALTER TABLE t_terrain
  ADD PRIMARY KEY (id);
ALTER TABLE t_todo
  ADD PRIMARY KEY (id);
ALTER TABLE t_typecharge
  ADD PRIMARY KEY (id);
ALTER TABLE t_typechargesyndique
  ADD PRIMARY KEY (id);
ALTER TABLE t_typecharge_commun
  ADD PRIMARY KEY (id);
ALTER TABLE t_typeSyndique
  ADD PRIMARY KEY (id);
ALTER TABLE t_user
  ADD PRIMARY KEY (id);


ALTER TABLE t_alert
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
ALTER TABLE t_annuaire
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
ALTER TABLE t_appartement
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=887;
ALTER TABLE t_bien
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_bug
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
ALTER TABLE t_caisse
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1070;
ALTER TABLE t_caisse_entrees
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
ALTER TABLE t_caisse_iaaza
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
ALTER TABLE t_caisse_sorties
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;
ALTER TABLE t_charge
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1581;
ALTER TABLE t_chargesyndique
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
ALTER TABLE t_charge_commun
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;
ALTER TABLE t_client
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=699;
ALTER TABLE t_clientattente
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
ALTER TABLE t_clientclassement
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
ALTER TABLE t_collaboration
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
ALTER TABLE t_commande
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE t_commandedetail
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE t_commission
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
ALTER TABLE t_company
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE t_comptebancaire
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
ALTER TABLE t_conge_employe_projet
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE t_conge_employe_societe
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_contrat
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1050;
ALTER TABLE t_contratcaslibre
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;
ALTER TABLE t_contratdetails
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
ALTER TABLE t_contratemploye
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
ALTER TABLE t_contrattravail
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE t_contrattravailreglement
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_employe
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
ALTER TABLE t_employe_projet
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE t_employe_societe
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE t_fournisseur
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
ALTER TABLE t_history
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21004;
ALTER TABLE t_livraison
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4564;
ALTER TABLE t_livraison_detail
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5635;
ALTER TABLE t_livraison_detail_iaaza
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2003;
ALTER TABLE t_livraison_iaaza
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=904;
ALTER TABLE t_locaux
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
ALTER TABLE t_mail
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE t_notes_client
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=901;
ALTER TABLE t_operation
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3809;
ALTER TABLE t_parking
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
ALTER TABLE t_pieces_appartement
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE t_pieces_livraison
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_pieces_locaux
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_pieces_terrain
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_projet
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_reglementprevu
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_reglement_fournisseur
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_reglement_fournisseur_iaaza
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_relevebancaire
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_salaires_projet
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_salaires_societe
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_syndique
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_task
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_terrain
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_todo
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_typecharge
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_typechargesyndique
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_typecharge_commun
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_typeSyndique
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE t_user
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
