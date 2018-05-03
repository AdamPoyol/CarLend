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
  annee VARCHAR(4) NOT NULL,
  lien_photo VARCHAR(250) NOT NULL,
  puissance_fiscale INT NOT NULL,
  energie VARCHAR (25) NOT NULL,
  boite_vitesse ENUM('manuelle','automatique') NOT NULL,
  nb_porte INT NOT NULL,
  nb_place INT NOT NULL,
  prix INT(4) NOT NULL,
  date_mise_en_location DATE NOT NULL,
  CONSTRAINT pk_vehicule PRIMARY KEY(id_vehicule)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS facture(
  id_facture INT UNSIGNED AUTO_INCREMENT,
  id_utilisateur INT UNSIGNED NULL DEFAULT NULL,
  id_vehicule INT UNSIGNED NULL DEFAULT NULL,
  date_location DATE NOT NULL,
  date_retour DATE NOT NULL,
  prix INT NOT NULL,
  CONSTRAINT pk_facture PRIMARY KEY(id_facture)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE vehicule ADD CONSTRAINT fk_vehicule_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur);
ALTER TABLE facture ADD CONSTRAINT fk_facture_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur);
ALTER TABLE facture ADD CONSTRAINT fk_facture_vehicule FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule);

INSERT INTO utilisateur(identifiant, mot_de_passe, nom, prenom, date_de_naissance, civilite, telephone, mail, adresse, ville, code_postal, lien_photo, lien_permis, date_adhesion) VALUES('administrateur', 'admin1234', 'null', 'null', '0001-01-01', 'm', 'null', 'null', 'null', 'null', 'null', 'null', 'null', '0001-01-01');