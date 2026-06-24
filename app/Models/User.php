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

    /** Crée un nouvel utilisateur dans la base de données
     * Creates a new user in the database
     * @param array $data Les données de l'utilisateur
     * @return bool True if the user was created successfully, false otherwise
     * @throws PDOException Si une erreur survient lors de la requête
     */
    public static function create($nom, $prenom, $telephone, $email, $mdp, $role = 'user')
    {
        $db = \Config\Database::getConnection();
        $hashedMdp = password_hash($mdp, PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT INTO users (nom, prenom, telephone, email, mdp, role) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $telephone, $email, $hashedMdp, $role]);
    }

    /** Met à jour les informations d'un utilisateur dans la base de données
     * Updates a user's information in the database
     * @param int $id L'ID de l'utilisateur
     * @param array $data Les nouvelles données de l'utilisateur
     * @return bool True if the user was updated successfully, false otherwise
     * @throws PDOException Si une erreur survient lors de la requête
     */
    public static function update($id, $data)
    {
        $db = \Config\Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET nom = ?, prenom = ?, telephone = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['telephone'],
            $data['email'],
            $data['role'],
            $id
        ]);
    }

    /** Supprime un utilisateur de la base de données
     * Deletes a user from the database
     * @param int $id L'ID de l'utilisateur
     * @return bool True if the user was deleted successfully, false otherwise
     * @throws PDOException Si une erreur survient lors de la requête
     */
    public static function delete($id)
    {
        $db = \Config\Database::getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}