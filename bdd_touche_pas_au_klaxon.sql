-- CREATION BDD
DROP DATABASE IF EXISTS touche_pas_au_klaxon;
CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon DEFAULT CHARACTER SET utf8mb4;
USE touche_pas_au_klaxon;

-- CREATION DES TABLES	
CREATE TABLE agences (
	id int auto_increment PRIMARY KEY,
    ville VARCHAR(50) NOT NULL
);

CREATE TABLE users (
	id int auto_increment PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    telephone VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mdp VARCHAR (255) NOT NULL,
    role VARCHAR(50) NOT NULL
);

CREATE TABLE trajets (
	id int auto_increment PRIMARY KEY,
    id_conducteur INT NOT NULL,
    id_agence_depart INT NOT NULL,
    id_agence_arrivee INT NOT NULL,
    gdh_depart DATETIME NOT NULL,
    gdh_arrivee DATETIME NOT NULL,
    places_totales INT NOT NULL,
    places_disponibles INT NOT NULL,
    FOREIGN KEY(id_conducteur) REFERENCES users(id),
    FOREIGN KEY(id_agence_depart) REFERENCES agences(id),
    FOREIGN KEY(id_agence_arrivee) REFERENCES agences(id)
);

-- ALIMENTATION BDD 
-- Table agences
INSERT INTO agences (ville) VALUES
	('Paris'),
	('Lyon'),
	('Marseille'),
	('Toulouse'),
	('Nice'),
	('Nantes'),
	('Strasbourg'),
	('Montpellier'),
	('Bordeaux'),
	('Lille'),
	('Rennes'),
	('Reims');

-- Table users (mot de passe temporaire hashé : password123)
INSERT INTO users (nom, prenom, telephone, email, mdp, role) VALUES 
	('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
	('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '$2y$10$7ykqh1lTu81hDoVXOb4Wde/O8sVXLmKZH4KJt2hGgGQ87H.cZ7EGO', 'user'),
    ('Admin', 'Administrateur', '0601020304', 'admin@email.fr', '$2y$10$NcYHe..qwJ5uoItVrPBr8.Ea1rh5m.uM8L28OpNNkmXKU711Hl4DS', 'admin'
);

-- exemples de trajets
INSERT INTO trajets (id_conducteur, id_agence_depart, id_agence_arrivee, gdh_depart, gdh_arrivee, places_totales, places_disponibles) VALUES
	( 
		4, -- id de Moreau Camille
        11, -- id de l'agence de départ, Rennes
        6, -- id de l'agence d'arrivée, Nantes
        '2026-06-20 09:00:00', -- heure de départ
        '2026-06-20 10:45:00',-- heure d'arrivée
        5, -- places totales
        3 -- places disponibles
	),
    ( 
		1, -- id de Martin Alexandre
        4, -- id de l'agence de départ, Toulouse
        8, -- id de l'agence d'arrivée, Montpellier
        '2026-07-02 08:30:00', -- heure de départ
        '2026-07-02 11:00:00',-- heure d'arrivée
        5, -- places totales
        2 -- places disponibles
	),
    ( 
		14, -- id de Robin, Nicolas
        1, -- id de l'agence de départ, Paris
        9, -- id de l'agence d'arrivée, Lille
        '2026-06-28 14:00:00', -- heure de départ
        '2026-06-28 16:50:00',-- heure d'arrivée
        4, -- places totales
        1 -- places disponibles
	);
	

	

