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

CREATE TABLE facture(
        id_facture     int (11) Auto_increment  NOT NULL ,
        id_utilisateur int (11) Auto_increment  NOT NULL ,
        id_voiture     int (11) Auto_increment  NOT NULL ,
        date_location  Date NOT NULL ,
        date_retour    Date NOT NULL ,
        prix           Int NOT NULL ,
        PRIMARY KEY (id_facture )
)ENGINE=InnoDB;

CREATE TABLE historique(
        id_utilisateur int (11) Auto_increment  NOT NULL ,
        id_location    int (11) Auto_increment  NOT NULL ,
        id_facture     int (11) Auto_increment  NOT NULL ,
        id_vehicule    int (11) Auto_increment  NOT NULL ,
        id_facture_1   Int NOT NULL ,
        PRIMARY KEY (id_utilisateur )
)ENGINE=InnoDB;

CREATE TABLE tarif(
        id_devis          int (11) Auto_increment  NOT NULL ,
        modele            Varchar (50) NOT NULL ,
        marque            Varchar (50) NOT NULL ,
        Puissance         Int NOT NULL ,
        Puissance_fiscale Int NOT NULL ,
        annee_vehicule    Date NOT NULL ,
        prix              Int NOT NULL ,
        PRIMARY KEY (id_devis )
)ENGINE=InnoDB;

CREATE TABLE cree_des_infos_de_connexion(
        id_vehicule Int NOT NULL ,
        id_facture  Int NOT NULL ,
        PRIMARY KEY (id_vehicule ,id_facture )
)ENGINE=InnoDB;

CREATE TABLE cree(
        id_devis   Int NOT NULL ,
        id_facture Int NOT NULL ,
        PRIMARY KEY (id_devis ,id_facture )
)ENGINE=InnoDB;

ALTER TABLE Locataire ADD CONSTRAINT FK_Locataire_id_facture FOREIGN KEY (id_facture) REFERENCES facture(id_facture);
ALTER TABLE vehicule ADD CONSTRAINT FK_vehicule_id_utilisateur_Locataire FOREIGN KEY (id_utilisateur_Locataire) REFERENCES Locataire(id_utilisateur);
ALTER TABLE historique ADD CONSTRAINT FK_historique_id_facture_1 FOREIGN KEY (id_facture_1) REFERENCES facture(id_facture);
ALTER TABLE cree_des_infos_de_connexion ADD CONSTRAINT FK_cree_des_infos_de_connexion_id_vehicule FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule);
ALTER TABLE cree_des_infos_de_connexion ADD CONSTRAINT FK_cree_des_infos_de_connexion_id_facture FOREIGN KEY (id_facture) REFERENCES facture(id_facture);
ALTER TABLE cree ADD CONSTRAINT FK_cree_id_devis FOREIGN KEY (id_devis) REFERENCES tarif(id_devis);
ALTER TABLE cree ADD CONSTRAINT FK_cree_id_facture FOREIGN KEY (id_facture) REFERENCES facture(id_facture);
