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

/** Initialisation du routeur avec configuration personnalsée
 * Initialization of the router with personalized configuration
 * @var Router $router
*/
$router = new Router([
    'paths' => [
        'controllers' => __DIR__ . '/../app/Controllers',
    ],
    'namespaces' => [
        'controllers' => 'Controllers',
    ],
]);

// ==========================================
// DEFINITION DES ROUTES DE L'APPLICATION
// DEFINING THE APPLICATION ROUTES
// ==========================================

// ROUTES PUBLIQUES
// PUBLIC ROUTES 

/** Route pour la page d'accueil
 * Home page route
 * URL : http://localhost/touche_pas_au_klaxon/
 */
$router->get('/', 'HomeController@index');

/** Route pour les trajets
 * Trips page route
 * URL : http://localhost/touche_pas_au_klaxon/trajets
 */
$router->get('/trajets', 'TrajetController@index');

/** Route pour la page des utilisateurs
 * Users page route
 * URL : http://localhost/touche_pas_au_klaxon/users
 */
$router->get('/users', 'UserController@index');


// ROUTES ADMIN (CRUD)
// ADMIN ROUTES (CRUD)
/** 
 * Page principale du panneau d'administration
 * Main page of the admin panel
 * URL : http://localhost/touche_pas_au_klaxon/admin
 */
$router->get('/admin', 'AdminController@index');

/**
 * Liste des villes pour l'admin
 * List of cities for the admin
 * URL : http://localhost/touche_pas_au_klaxon/admin/villes
 */
$router->get('/admin/villes', 'AdminController@villesIndex');

/** 
 * Action d'ajout d'une ville pour l'admin
 * Adding a city by the admin
 * URL : http://localhost/touche_pas_au_klaxon/admin/villes/ajouter
 */
$router->post('/admin/villes/ajouter', 'AdminController@villesAdd');

/** 
 * Action de modification d'une ville pour l'admin
 * Editing a city by the admin
 * URL : http://localhost/touche_pas_au_klaxon/admin/villes/modifier
 */
$router->put('/admin/villes/modifier', 'AdminController@villesUpdate');

/** 
 * Action de suppression d'une ville pour l'admin
 * Deleting a city by the admin
 * URL : http://localhost/touche_pas_au_klaxon/admin/villes/supprimer
 */
$router->delete('/admin/villes/supprimer', 'AdminController@villesDelete');

/**
 *  Consultation de tous les employés par l'admin
 * Listing all employees for the admin
 * URL : http://localhost/touche_pas_au_klaxon/admin/users
 */
$router->get('/admin/users', 'AdminController@usersIndex');

/**
 * Mise à jour du profil d'un employé par l'admin
 * Updating an employee's profile by the admin
 * URL : http://localhost/touche_pas_au_klaxon/admin/users/update
 */
$router->put('/admin/users/update', 'AdminController@usersUpdate');

/**
 * Suppression d'un employé par l'admin
 * Deleting an employee by the admin
 * URL : http://localhost/touche_pas_au_klaxon/admin/users/delete
 */
$router->delete('/admin/users/delete', 'AdminController@usersDelete');

// BASE DE DONNEES
// DATABASE

/**
 * Route pour tester la connexion à la base de données
 * Database connection test route
 * URL : http://localhost/touche_pas_au_klaxon/test-db
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

/** Exécution du routeur
 * Running the router
 */
$router->run();