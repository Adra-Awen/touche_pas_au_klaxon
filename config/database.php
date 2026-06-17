<?php
 
 /** Indication de l'emplacement du fichier de configuration */
 namespace Config;

 /** Importation des classes PDO et PDOException */
 use PDO;
 use PDOException;

 /** Classe de configuration et de connexion à la base de données 
  * Centralise la configuration de la base de données 
  * et fournit une méthode pour obtenir une connexion PDO.
 */
 class Database
 {
    /** Instance unique de la connexion PDO
     * @var PDO|null
     */
    private static ?PDO $connection = null;

    /** Retourne la connexion PDO
     * Si connection n'existe pas encore, elle est créée.
     * @return PDO
     * @throws PDOException si la connexion échoue
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $host = 'localhost';
            $db_name = 'touche_pas_au_klaxon';
            $username = 'root';
            $password = '';

            try {
                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$db_name;charset=utf8",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$connection;
    }
 }