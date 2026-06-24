<?php

namespace Models;

use Config\Database;
use PDO;
use PDOException;

/** 
 * Modèle pour la gestion des agences par l'admin
 * Agency model for managing agencies by the admin
 * @package App\Models
 */
class Agence
{
    /**
     * Récupère toutes les agences de la base de données
     * Retrieves all agencies from the database
     * @return array Un tableau contenant toutes les agences
     * @throws PDOException Si une erreur survient lors de la requête
     */
    public static function getAll(): array
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT id, ville FROM agences ORDER BY ville ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la récupération des agences : " . $e->getMessage());
        }
    }
    
    /**
     * Insère une nouvelle agence/ville dans la base de données
     * Inserts a new agency/city into the database
     * @param string $ville Le nom de la ville à insérer
     * @return bool True si l'insertion a réussi, false sinon
     * @throws PDOException Si une erreur survient lors de l'insertion
     */
    public static function create(string $ville): bool
    {
        try {
            $db = \Config\Database::getConnection();
            $stmt = $db->prepare("INSERT INTO agences (ville) VALUES (:ville)");
            return $stmt->execute(['ville' => $ville]);
        } catch (\PDOException $e) {
            throw new \PDOException("Erreur lors de l'insertion de la ville : " . $e->getMessage());
        }
    }

    /**
     * Met à jour une agence/ville existante dans la base de données
     * Updates an existing agency/city in the database
     * @param int $id L'identifiant de l'agence à mettre à jour
     * @param string $ville Le nouveau nom de la ville
     * @return bool True si la mise à jour a réussi, false sinon
     * @throws PDOException Si une erreur survient lors de la mise à jour
     */
    public static function update(int $id, string $ville): bool
    {
        try {
            $db = \Config\Database::getConnection();
            $stmt = $db->prepare("UPDATE agences SET ville = :ville WHERE id = :id");
            return $stmt->execute(['ville' => $ville, 'id' => $id]);
        } catch (\PDOException $e) {
            throw new \PDOException("Erreur lors de la mise à jour de la ville : " . $e->getMessage());
        }
    }

    /** Supprime une agence/ville
     * Deletes an agency/city
     * @param int $id L'identifiant de l'agence à supprimer
     * @return bool True si la suppression a réussi, false sinon
     * @throws PDOException Si une erreur survient lors de la suppression
     */
    public static function villesDelete(int $id): bool
    {
        try {
            $db = \Config\Database::getConnection();
            $stmt = $db->prepare("DELETE FROM agences WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            throw new \PDOException("Erreur lors de la suppression de la ville : " . $e->getMessage());
        }
    }
}
