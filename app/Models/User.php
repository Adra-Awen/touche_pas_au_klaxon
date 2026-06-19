<?php

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
     * Récupère tous les utilisateurs de la base de données grâce à son ID
     * Retrieves all users from the database by their ID
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
}