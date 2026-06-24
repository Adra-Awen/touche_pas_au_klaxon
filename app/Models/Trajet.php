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

    /**
     * Crée un nouveau trajet dans la base de données
     * Creates a new trip in the database
     */
    public static function create(int $id_conducteur, int $id_agence_depart, int $id_agence_arrivee, string $gdh_depart, string $gdh_arrivee, int $places_totales): bool
    {
        try {
            $db = Database::getConnection();
            $queryStr = "INSERT INTO trajets (id_conducteur, id_agence_depart, id_agence_arrivee, gdh_depart, gdh_arrivee, places_totales, places_disponibles) VALUES (:id_conducteur, :id_agence_depart, :id_agence_arrivee, :gdh_depart, :gdh_arrivee, :places_totales, :places_disponibles)";
            $stmt = $db->prepare($queryStr);
            $stmt->execute([
                'id_conducteur' => $id_conducteur,
                'id_agence_depart' => $id_agence_depart,
                'id_agence_arrivee' => $id_agence_arrivee,
                'gdh_depart' => $gdh_depart,
                'gdh_arrivee' => $gdh_arrivee,
                'places_totales' => $places_totales,
                'places_disponibles' => $places_totales
            ]);
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Récupère les trajets créés par un utilisateur spécifique
     * Retrieves trips created by one specific user
     */
    public static function getByConducteur(int $id_conducteur): array
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
                            a_arr.ville AS agence_arrivee
                        FROM trajets t
                        INNER JOIN agences a_dep ON t.id_agence_depart = a_dep.id
                        INNER JOIN agences a_arr ON t.id_agence_arrivee = a_arr.id
                        WHERE t.id_conducteur = :id_conducteur
                        ORDER BY t.gdh_depart DESC";

            $stmt = $db->prepare($queryStr);
            $stmt->execute(['id_conducteur' => $id_conducteur]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOExeption $e) {
            throw $e;
        }
    }

    /**
     * Supprime un trajet dans la BDD
     * Deletes a trip in the database
     */
    public static function delete(int $id): bool
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM trajets WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}