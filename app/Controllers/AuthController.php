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
        echo "<h2>Connexion</h2>
              <form method='POST' action='/login'>
                  <label>Email :</label>
                  <input type='email' name='email' required>
                  <br><br>
                  <label>Mot de passe :</label>
                  <input type='password' name='mdp' required>
                  <br><br>
                  <button type='submit'>Se connecter</button>
              </form>";
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

                    echo "<p>Bienvenue " . htmlspecialchars($user['prenom']) . " ! Connexion réussie.</p>";
                                        
                    echo "<p><a href='/trajets/add'><button type='button'>Proposer un nouveau trajet</button></a></p>";
                    
                    // Visualisation des trajets créés par l'utilisateur
                    try {
                        $mesTrajets = \Models\Trajet::getByConducteur((int)$_SESSION['user_id']);
                        echo "<h3>Mes trajets partagés</h3>";
                        
                        if (empty($mesTrajets)) {
                            echo "<p>Vous n'avez pas encore créé de trajet.</p>";
                        } else {
                            echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width:100%; text-align:left;'>";
                            echo "<tr>
                                    <th>Départ</th>
                                    <th>Arrivée</th>
                                    <th>Date/Heure Départ</th>
                                    <th>Date/Heure Arrivée</th>
                                    <th>Places Restantes</th>
                                    <th>Actions</th> </tr>";
                                  
                            foreach ($mesTrajets as $trajet) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($trajet['agence_depart']) . "</td>
                                        <td>" . htmlspecialchars($trajet['agence_arrivee']) . "</td>
                                        <td>" . htmlspecialchars($trajet['gdh_depart']) . "</td>
                                        <td>" . htmlspecialchars($trajet['gdh_arrivee']) . "</td>
                                        <td>" . htmlspecialchars($trajet['places_disponibles']) . " / " . htmlspecialchars($trajet['places_totales']) . "</td>
                                        <td>
                                            <a href='/trajets/edit/" . $trajet['id'] . "'><button type='button'>Modifier</button></a>
                                            
                                            <a href='/trajets/delete/" . $trajet['id'] . "' onclick=\"return confirm('Es-tu sûre de vouloir supprimer ce trajet ?');\"><button type='button'>Supprimer</button></a>
                                        </td>
                                      </tr>";
                            }
                            echo "</table>";
                        }
                    } catch (\PDOException $e) {
                        echo "<p>Erreur lors de la récupération de vos trajets : " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                    
                    echo "<p><a href='/logout'>Se déconnecter</a></p>";

                } else {
                    echo "<p>Email ou mot de passe incorrect.</p>";
                    echo "<p><a href='/login'>Réessayer</a></p>";
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