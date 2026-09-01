<?php

namespace Controllers;

use Models\User;

class AuthController
{
    /**
     * Affiche le formulaire de connexion
     * Displays the login form
     */
    public function showLogin()
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Traite la connexion de l'utilisateur
     * Processes the user login
     */
    public function login()
    {
        if (isset($_POST['email']) && isset($_POST['mdp'])) {
            $email = trim($_POST['email']);
            $mdp = $_POST['mdp'];

            try {
                $db = \Config\Database::getConnection();
                $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($user && password_verify($mdp, $user['mdp'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_prenom'] = $user['prenom'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    if ($user['role'] === 'admin') {
                        header('Location: /admin');
                        exit;
                    }

                    header('Location: /mon-espace');
                    exit;
                }
            } catch (\PDOException $e) {
                echo "Erreur : " . htmlspecialchars($e->getMessage());
            }
        }
    }

    /**
     * Déconnecte l'utilisateur
     * Logs out the user
     */
    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}