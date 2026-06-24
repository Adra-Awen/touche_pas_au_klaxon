<?php

namespace Models;

use Config\Database;
use PDO;
use PDOException;


/**
 * Modèle de l'utilisateur
 * User model
 * 
 * Gère les interactions avec la table "users" de la base de données.
 * Manages interactions with the "users" table in the database.
 * @package App\Models
 */
class User
{ 
    /**
     * Récupère un utilisateur de la base de données grâce à son ID
     * Retrieves a user from the database by their ID
     * @param int $id L'ID de l'utilisateur
     * @return array|false Un tableau associatif contenant les informations de l'utilisateur ou false si non trouvé
     * @throws PDOException Si une erreur survient lors de la requête
     */
    public static function findById($id)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        }
    }

    /**
     * Récupère la liste de tous les utilisateurs de la base de données
     * Retrieves the list of all users from the database
     * @return array Un tableau contenant tous les utilisateurs
     * @throws PDOException Si une erreur survient lors de la requête
     */
    public static function getAll(): array
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT id, nom, prenom, telephone, email, role FROM users ORDER BY nom ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
        }
    }
}