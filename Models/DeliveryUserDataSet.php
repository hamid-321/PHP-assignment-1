<?php
namespace Models;


require_once ('Models/Database.php');
require_once ('Models/DeliveryUser.php');

class DeliveryUserDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @return array
     *
     * retrieves all delivery users
     */
    public function fetchAllUsers(): array
    {
        $sqlQuery = 'SELECT * FROM delivery_users';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUser($row);
        }
        return $dataSet;
    }
}