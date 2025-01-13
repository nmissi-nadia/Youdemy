CREATE TABLE user (
    iduser INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('etudiant', 'Enseignant', 'admin') NOT NULL,
    status ENUM('accepter', 'refuser', 'en attente'), -- pour le statut du compte prof
    EstActive BOOLEAN -- pour le statut du compte étudiant
);


create table categorie(
    idcategorie INT PRIMARY KEY AUTO_INCREMENT,
    categorie varchar(255)
    
);
CREATE TABLE cours (
    idcours INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    documentation TEXT,
    path_vedio VARCHAR(255),
    idcategorie INT NOT NULL,
    idEnseignant INT NOT NULL,
    dateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idcategorie) REFERENCES categorie(idcategorie),
    FOREIGN KEY (idEnseignant) REFERENCES user(iduser)
);

create table tag(
    idtag int primary key AUTO_INCREMENT,
    tag varchar(255)
);

create table tag_cours(
    idcours int not null,
    idtag int not null,
    foreign key (idcours) references cours(idcours),
    foreign key (idtag) references tag(idtag),
    primary key(idcours,idtag)
);