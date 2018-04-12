CREATE DATABASE Carlend;

use Carlend;


CREATE TABLE IF NOT EXISTS Locataire(
        numero_client int (11) Auto_increment  NOT NULL ,
        Nom           Varchar (50) NOT NULL ,
        Prenom        Varchar (50) NOT NULL ,
        telephone     Int NOT NULL ,
        Adresse       Varchar (80) NOT NULL ,
        Code_postale  Int NOT NULL ,
        mail          Varchar (50) NOT NULL ,
        Ville         Varchar (50) NOT NULL ,
        date_adhesion Date NOT NULL ,
        PRIMARY KEY (numero_client )
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS vehicule(
        id_voiture        int (11) Auto_increment  NOT NULL ,
        marque            Varchar (50) NOT NULL ,
        modele            Varchar (50) NOT NULL ,
        Puissance         Int NOT NULL ,
        Puissance_fiscale Int NOT NULL ,
        energie           Varchar (25) NOT NULL ,
        boite_vitesse     Varchar (25) NOT NULL ,
        nbr_porte         Int NOT NULL ,
        nbr_place         Int NOT NULL ,
        PRIMARY KEY (id_voiture )
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS info_location(
        id_location    int (11) Auto_increment  NOT NULL ,
        date_location  Date NOT NULL ,
        date_rendu     Date NOT NULL ,
        id_utilisateur Int NOT NULL ,
        prix           Int NOT NULL ,
        id_voiture     Int NOT NULL ,
        PRIMARY KEY (id_location )
)ENGINE=InnoDB


CREATE TABLE IF NOT EXISTS loue(
        numero_client Int NOT NULL ,
        id_voiture    Int NOT NULL ,
        id_location   Int NOT NULL ,
        PRIMARY KEY (numero_client ,id_voiture ,id_location )
)ENGINE=InnoDB;

ALTER TABLE loue ADD CONSTRAINT FK_loue_numero_client FOREIGN KEY (numero_client) REFERENCES Locataire(numero_client);
ALTER TABLE loue ADD CONSTRAINT FK_loue_id_voiture FOREIGN KEY (id_voiture) REFERENCES vehicule(id_voiture);
ALTER TABLE loue ADD CONSTRAINT FK_loue_id_location FOREIGN KEY (id_location) REFERENCES info_location(id_location);
