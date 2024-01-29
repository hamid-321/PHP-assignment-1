<?php
namespace Models;
use PDO;
use PDOException;

class Database {
    /**
     * @var Database
     */
    protected static $_dbInstance = null;

    /**
     * @var PDO
     */
    protected $_dbHandle;

    /**
     * @return Database
     */
    public static function getInstance() {
        $username ='sgc488';
        $password = 'Dm1NKTOviQWR11a';
        $host = 'poseidon.salford.ac.uk';
        $dbName = 'sgc488';

        if(self::$_dbInstance === null) { //checks if the PDO exists
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$_dbInstance;
    }

    /**
     * @param $username
     * @param $password
     * @param $host
     * @param $database
     *
     * creates database connection
     */
    private function __construct($username, $password, $host, $database) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database",  $username, $password);


        }
        catch (PDOException $e) { // error handling
            echo $e->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getdbConnection() {
        return $this->_dbHandle; // returns the PDO
    }

    public function __destruct() {
        $this->_dbHandle = null; // destroys the PDO
    }
}
