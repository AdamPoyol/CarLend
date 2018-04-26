<<<<<<< HEAD
CREATE DATABASE IF NOT EXISTS carlend CHARACTER SET 'utf8';
USE carlend;

CREATE TABLE IF NOT EXISTS utilisateur(
  id_utilisateur INT UNSIGNED AUTO_INCREMENT,
  mot_de_passe VARCHAR(32) NOT NULL,
  identifiant VARCHAR(30) NOT NULL,
  nom VARCHAR(20) NOT NULL,
  prenom VARCHAR(20) NOT NULL,
  date_de_naissance DATE NOT NULL,
  civilite ENUM('m','f') NOT NULL,
  telephone VARCHAR(20) NOT NULL,
  mail VARCHAR(256) NOT NULL,
  adresse VARCHAR(70) NOT NULL,
  ville VARCHAR(20) NOT NULL,
  code_postal VARCHAR(5) NOT NULL,
  lien_photo VARCHAR(250) NOT NULL,
  lien_permis VARCHAR(250) NOT NULL,
  date_adhesion DATE NOT NULL,
  CONSTRAINT pk_utilisateur PRIMARY KEY (id_utilisateur)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS vehicule(
  id_vehicule INT UNSIGNED AUTO_INCREMENT,
  id_utilisateur INT UNSIGNED NULL DEFAULT NULL,
  immatriculation VARCHAR(10) NOT NULL,
  marque VARCHAR(30) NOT NULL,
  modele VARCHAR(30) NOT NULL,
  lien_photo VARCHAR(250),
  puissance INT NOT NULL,
  puissance_fiscale INT NOT NULL,
  energie VARCHAR (25) NOT NULL,
  boite_vitesse VARCHAR (25) NOT NULL,
  nb_porte INT NOT NULL,
  nb_place INT NOT NULL,
  date_mise_en_location DATE NOT NULL,
  CONSTRAINT pk_vehicule PRIMARY KEY(id_vehicule)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS facture(
  id_facture INT UNSIGNED AUTO_INCREMENT,
  id_utilisateur INT UNSIGNED NULL DEFAULT NULL,
  id_vehicule INT UNSIGNED NULL DEFAULT NULL,
  id_tarif INT UNSIGNED NULL DEFAULT NULL,
  date_location DATE NOT NULL,
  date_retour DATE NOT NULL,
  prix INT NOT NULL,
  CONSTRAINT pk_facture PRIMARY KEY(id_facture)
)ENGINE=INNODB DEFAULT CHARSET=utf8;
=======
#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Locataire
#------------------------------------------------------------

CREATE TABLE Locataire(
        id_utilisateur    int (11) Auto_increment  NOT NULL ,
        Nom               Varchar (50) NOT NULL ,
        Prenom            Varchar (50) NOT NULL ,
        telephone         Int NOT NULL ,
        Adresse           Varchar (80) NOT NULL ,
        Code_postale      Int NOT NULL ,
        mail              Varchar (50) NOT NULL ,
        Ville             Varchar (50) NOT NULL ,
        date_adhesion     Date NOT NULL ,
        liens_photo       Varchar (255) ,
        liens_permis      Varchar (255) ,
        identifiant       Varchar (30) NOT NULL ,
        mot_de_passe      Varchar (30) NOT NULL ,
        date_de_naissance Date NOT NULL ,
        civilite          Varchar (25) NOT NULL ,
        id_facture        Int NOT NULL ,
        PRIMARY KEY (id_utilisateur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: véhicule
#------------------------------------------------------------

CREATE TABLE vehicule(
        id_vehicule              int (11) Auto_increment  NOT NULL ,
        marque                   Varchar (50) NOT NULL ,
        modele                   Varchar (50) NOT NULL ,
        Puissance                Int NOT NULL ,
        Puissance_fiscale        Int NOT NULL ,
        energie                  Varchar (25) NOT NULL ,
        boite_vitesse            Varchar (25) NOT NULL ,
        nbr_porte                Int NOT NULL ,
        nbr_place                Int NOT NULL ,
        date_mise_en_location    Date NOT NULL ,
        id_utilisateur           Int NOT NULL ,
        immatriculation          Varchar (25) NOT NULL ,
        lien_photo               Varchar (255) NOT NULL ,
        id_utilisateur_Locataire Int NOT NULL ,
        PRIMARY KEY (id_vehicule )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: facture
#------------------------------------------------------------

CREATE TABLE facture(
        id_facture     int (11) Auto_increment  NOT NULL ,
        id_utilisateur Int NOT NULL ,
        id_voiture     Int NOT NULL ,
        date_location  Date NOT NULL ,
        date_retour    Date NOT NULL ,
        prix           Int NOT NULL ,
        id_tarif       Int NOT NULL ,
        PRIMARY KEY (id_facture )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: historique
#------------------------------------------------------------

CREATE TABLE historique(
        id_utilisateur Int NOT NULL ,
        id_location    Int NOT NULL ,
        id_facture     Int NOT NULL ,
        id_vehicule    Int NOT NULL ,
        id_facture_1   Int NOT NULL ,
        PRIMARY KEY (id_utilisateur )
)ENGINE=InnoDB;
>>>>>>> 06052a07280cbcfa906dd9f37855dacc7cdace6b


#------------------------------------------------------------
# Table: tarif
#------------------------------------------------------------

CREATE TABLE tarif(
<<<<<<< HEAD
  id_tarif INT UNSIGNED AUTO_INCREMENT,
  marque VARCHAR(30) NOT NULL,
  modele VARCHAR(30) NOT NULL,
  puissance INT NOT NULL,
  puissance_fiscale INT NOT NULL,
  annee_vehicule DATE NOT NULL,
  prix INT NOT NULL,
  CONSTRAINT pk_tarif PRIMARY KEY(id_tarif)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE vehicule ADD CONSTRAINT fk_vehicule_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur);
ALTER TABLE facture ADD CONSTRAINT fk_facture_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur);
ALTER TABLE facture ADD CONSTRAINT fk_facture_vehicule FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule);
ALTER TABLE facture ADD CONSTRAINT fk_facture_tarif FOREIGN KEY (id_tarif) REFERENCES tarif(id_tarif);
=======
        id_tarif          int (11) Auto_increment  NOT NULL ,
        modele            Varchar (50) NOT NULL ,
        marque            Varchar (50) NOT NULL ,
        Puissance         Int NOT NULL ,
        Puissance_fiscale Int NOT NULL ,
        annee_vehicule    Date NOT NULL ,
        prix              Int NOT NULL ,
        PRIMARY KEY (id_tarif )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: créé des infos de connexion
#------------------------------------------------------------

CREATE TABLE cree_des_infos_de_connexion(
        id_vehicule Int NOT NULL ,
        id_facture  Int NOT NULL ,
        PRIMARY KEY (id_vehicule ,id_facture )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: créé
#------------------------------------------------------------

CREATE TABLE cree(
        id_tarif   Int NOT NULL ,
        id_facture Int NOT NULL ,
        PRIMARY KEY (id_tarif ,id_facture )
)ENGINE=InnoDB;

ALTER TABLE Locataire ADD CONSTRAINT FK_Locataire_id_facture FOREIGN KEY (id_facture) REFERENCES facture(id_facture);
ALTER TABLE vehicule ADD CONSTRAINT FK_vehicule_id_utilisateur_Locataire FOREIGN KEY (id_utilisateur_Locataire) REFERENCES Locataire(id_utilisateur);
ALTER TABLE historique ADD CONSTRAINT FK_historique_id_facture_1 FOREIGN KEY (id_facture_1) REFERENCES facture(id_facture);
ALTER TABLE cree_des_infos_de_connexion ADD CONSTRAINT FK_cree_des_infos_de_connexion_id_vehicule FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule);
ALTER TABLE cree_des_infos_de_connexion ADD CONSTRAINT FK_cree_des_infos_de_connexion_id_facture FOREIGN KEY (id_facture) REFERENCES facture(id_facture);
ALTER TABLE cree ADD CONSTRAINT FK_cree_id_tarif FOREIGN KEY (id_tarif) REFERENCES tarif(id_tarif);
ALTER TABLE cree ADD CONSTRAINT FK_cree_id_facture FOREIGN KEY (id_facture) REFERENCES facture(id_facture);
>>>>>>> 06052a07280cbcfa906dd9f37855dacc7cdace6b
