<?php

namespace Models;

use Config\Database;
use PDO;
use PDOException;

/**
 * Modèle pour la gestion des trajets
 * Model for managing trips
 * 
 * Gère les  requêtes et interactions avec la base de données pour les trajets.
 * Manages queries and interactions with the database for trips.
 * @package App\Models
 */
class Trajet
{
    /**
     * Récupère la liste de tous les trajets à venir
     * Retrieves the list of all upcoming trips
     * @return array Liste des trajets à venir
     * @throws PDOException Si une erreur survient lors de la requête
     */
    public static function getAllUpcoming(): array
    {
        try {
            $db = Database::getConnection();
            $queryStr = "SELECT
                        t.id, 
                        t.gdh_depart,
                        t.gdh_arrivee,
                        t.places_totales,
                        t.places_disponibles,
                        a_dep.ville AS agence_depart, 
                        a_arr.ville AS agence_arrivee,
                        u.nom AS conducteur_nom, 
                        u.prenom AS conducteur_prenom
                    FROM trajets t
                    INNER JOIN agences a_dep ON t.id_agence_depart= a_dep.id
                    INNER JOIN agences a_arr ON t.id_agence_arrivee = a_arr.id
                    INNER JOIN users u ON t.id_conducteur = u.id
                    WHERE t.gdh_depart >= NOW() 
                    ORDER BY t.gdh_depart ASC";
            $stmt = $db->query($queryStr);
            $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $trajets;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}