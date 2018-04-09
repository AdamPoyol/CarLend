CREATE DATABASE IF NOT EXISTS carlend CHARACTER SET 'utf8';
USE carlend;

CREATE TABLE IF NOT EXISTS connexion(
  identifiant VARCHAR(30),
  mot_de_passe VARCHAR(50),
  id_utilisateur INT(3)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS utilisateur(
  id_utilisateur INT(3)AUTO_INCREMENT,
  nom VARCHAR(30),
  prenom VARCHAR(30),
  date_de_naissance DATE,
  telephone VARCHAR(20),
  adresse VARCHAR(50),
  mail VARCHAR(50),
  code_postal VARCHAR(10),
  ville VARCHAR(50),
  date_adhesion DATE,
  lien_photo VARCHAR(50),
  CONSTRAINT pk_utilisateur PRIMARY KEY (id_utilisateur)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS vehicule(
  id_vehicule INT(3)AUTO_INCREMENT,
  id_utilisateur INT(3),
  immatriculation VARCHAR(10),
  marque VARCHAR(30),
  modele VARCHAR(30),
  lien_photo VARCHAR(50),
  CONSTRAINT pk_vehicule PRIMARY KEY(id_vehicule)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS mise_en_location(
  id_mise_en_location INT(3)AUTO_INCREMENT,
  id_utilisateur INT(3),
  id_vehicule INT(3),
  date_mise_en_location DATE DEFAULT NULL,
  CONSTRAINT pk_mise_en_location PRIMARY KEY(id_mise_en_location)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS location(
  id_location INT(3)AUTO_INCREMENT,
  id_utilisateur INT(3),
  id_vehicule INT(3),
  date_debut_location DATE,
  date_fin_location DATE DEFAULT NULL,
  CONSTRAINT pk_location PRIMARY KEY(id_location)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE connexion
  ADD CONSTRAINT fk_connexion_utilisateur
FOREIGN KEY (id_utilisateur)
REFERENCES utilisateur(id_utilisateur);

ALTER TABLE vehicule
  ADD CONSTRAINT fk_vehicule_utilisateur
FOREIGN KEY (id_utilisateur)
REFERENCES utilisateur(id_utilisateur);

ALTER TABLE mise_en_location
  ADD CONSTRAINT fk_mise_en_location_utilisateur
FOREIGN KEY (id_utilisateur)
REFERENCES utilisateur(id_utilisateur);

ALTER TABLE mise_en_location
  ADD CONSTRAINT fk_mise_en_location_vehicule
FOREIGN KEY (id_vehicule)
REFERENCES vehicule(id_vehicule);

ALTER TABLE location
  ADD CONSTRAINT fk_location_utilisateur
FOREIGN KEY (id_utilisateur)
REFERENCES utilisateur(id_utilisateur);

ALTER TABLE location
  ADD CONSTRAINT fk_location_vehicule
FOREIGN KEY (id_vehicule)
REFERENCES vehicule(id_vehicule);

INSERT INTO utilisateur
VALUES('1','ACQUART','Antoine','1999-05-26','06.06.06.06.06','123 ynov','antoine.acquart@ynov.com','13880','Velaux','2018-03-17','antoine.png');
