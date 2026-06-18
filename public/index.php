<?php

/** This file is the entry point of the application. 
 * It initializes the routing system and handles incoming requests. 
 * Ce fichier est le point d'entrée de l'application.
 * Il initialise le système de routage et gère les requêtes entrantes.
 */

/** Autoloading of classes using Composer's autoloader 
 * L'autoloading des classes via l'autoloader de Composer
*/
require_once __DIR__ . '/../vendor/autoload.php';

/** Importation de la classe Router du package Buki\Router 
 * Importing the Router class from the Buki\Router package
*/
use Buki\Router\Router;

/** Initialisation du routeur avec sa configuration par défaut
 * Initialization of the router with its default configuration
 * @var Router $router
*/
$router = new Router();

// DEFINITION DES ROUTES DE L'APPLICATION

/** Route pour la page d'accueil
 * Home page route
 * URL : http://localhost/touche_pas_au_klaxon/public/
 */
$router->get('/', function () {
    echo "<h1>Bienvenue sur Touche pas au klaxon !</h1>
          <p>Cette application est en cours de développement.</p>";
});

/**
 * Route pour tester la connexion à la base de données
 * Database connection test route
 * URL : http://localhost/touche_pas_au_klaxon/public/test-db
 */
$router->get('/test-db', function () {
    try {
        $pdo = \Config\Database::getConnection();
        echo "<h1>Connexion à la base de données réussie !</h1>";
    } catch (\PDOException $e) {
        echo "<h1>Erreur de connexion à la base de données :</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
});

$router->run();