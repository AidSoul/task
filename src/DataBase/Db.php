<?php

namespace Task\DataBase;

use PDO;

/**
 * A class for easy work with the database
 */
class Db
{
    /**
     * Database name
     */
    const DB_NAME = 'task';

    /**
     * Database name user
     */
    const DB_USER = 'root';

    /**
     * Database user password
     */
    const DB_PASSWORD = "";

    /**
     * An instance of a class to work with PDO
     *
     * @var object
     */
    private object $db;

    /**
     *  Database table name
     */
    private $tableName = "users";

    public function __construct()
    {
        try {
            $this->db = new PDO(
                'mysql:host=localhost;dbname=' . self::DB_NAME,
                self::DB_USER,
                self::DB_PASSWORD
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    /**
     * Calling class functions without creating an instance of the class
     *
     * @return static
     */
    public static function query(): self
    {
        return new self();
    }

    /**
     * Function for selecting data from a database table
     *
     * @param array $params
     * 
     * @return array|boolean
     */
    public function select(array $params = []): array|bool
    {
        try {
            $query = "SELECT * FROM {$this->tableName} WHERE id = ? LIMIT 1";
            $stmt = $this->executeQuery($query, $params);
            return $stmt->fetch();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Function for deleting data from a database table
     *
     * @param array $params
     * 
     * @return void
     */
    public function delete(array $params = []): void
    {
        try {
            $query = "DELETE FROM {$this->tableName} WHERE id = ?";
            $this->executeQuery($query, $params);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * Function to insert data into a database table
     *
     * @param array $params
     * 
     * @return void
     */
    public function insert(array $params = []): void
    {
        try {
            $query = "INSERT INTO {$this->tableName} (`id`,`firstname`, `lastname`, `birthdate`, `gender`, `city`) VALUES (?,?,?,?,?,?)";
            $this->executeQuery($query, $params);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Function for sending a query to the database
     *
     * @param string $query
     * @param array $params
     * 
     * @return object
     */
    private function executeQuery(string $query = '', array $params = []): object
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
