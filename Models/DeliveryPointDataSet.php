<?php
namespace Models;


use PDO;

require_once ('Database.php');
require_once ('DeliveryPoint.php');


class DeliveryPointDataSet{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @return array
     *
     * retrieves all delivery point information
     */
    public function fetchAllDeliveryPoints(): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                     FROM delivery_point 
                     INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                     INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userid';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }

    /**
     * @return array
     *
     * Retrieves all the DP info and orders by ID
     */
    public function fetchAllDeliveryPointsById(): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                     FROM delivery_point 
                     INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                     INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userid
                     ORDER BY delivery_point.id';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }

    /**
     * @return array
     *
     * Retrieves all the info and orders by deliverer id
     */
    public function fetchAllDeliveryPointsByDeliverer(): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                     FROM delivery_point 
                     INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                     INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userid
                     ORDER BY delivery_point.deliverer, delivery_point.id';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }
    /**
     * @return array
     *
     * Retrieves all the info and orders by status code
     */
    public function fetchAllDeliveryPointsByStatus(): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                     FROM delivery_point 
                     INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                     INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userid
                     ORDER BY delivery_point.status, delivery_point.id';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }
    /**
     * @param $userid
     * @return array
     *
     * Retrieves all the info for a specific user id (deliverer)
     */
    public function fetchAllDeliveryPointsForUserID($userid): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                     FROM delivery_point
                     INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                     INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userid
                     WHERE deliverer=:userid';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }
    /**
     * @param $userid
     * @return array
     *
     * Retrieves all the info for a specific user id (deliverer) and orders by id
     */
    public function fetchAllDeliveryPointsForUserIDById($userid): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                     FROM delivery_point
                     INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                     INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userid
                     WHERE deliverer=:userid
                     ORDER BY delivery_point.id ';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }

    /**
     * @param $userid
     * @return array
     *
     * Retrieves all the info for a specific user id (deliverer) and orders by status
     */
    public function fetchAllDeliveryPointsForUserIDByStatus($userid): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                     FROM delivery_point
                     INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                     INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userid
                     WHERE deliverer=:userid
                     ORDER BY delivery_point.status, delivery_point.id';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }

    /**
     * @param $name
     * @param $address_1
     * @param $address_2
     * @param $postcode
     * @param $deliverer
     * @param $lat
     * @param $lng
     * @param $status
     * @param $del_photo
     * @return void
     *
     * Creates a new delivery point
     */
    public function createDeliveryPoint($name, $address_1, $address_2, $postcode, $deliverer, $lat, $lng, $status, $del_photo) {

        $sqlQuery = 'INSERT INTO delivery_point (name, address_1, address_2, postcode, deliverer, lat, lng, status, del_photo) VALUES (:name, :address_1, :address_2, :postcode, :deliverer, :lat, :lng, :status, :del_photo)';

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindParam(':name', $name);
        $statement->bindParam(':address_1', $address_1);
        $statement->bindParam(':address_2', $address_2);
        $statement->bindParam(':postcode', $postcode);
        $statement->bindParam(':deliverer', $deliverer, PDO::PARAM_INT);
        $statement->bindParam(':lat', $lat);
        $statement->bindParam(':lng', $lng);
        $statement->bindParam(':status', $status, PDO::PARAM_INT);
        $statement->bindParam(':del_photo', $del_photo);

        $statement->execute();
    }

    /**
     * @param $id
     * @return void
     *
     * deletes a delivery point by id
     */
    public function deleteDeliveryPoint($id) {
        $statement = $this->_dbHandle->prepare("DELETE FROM delivery_point WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param $query
     * @return array
     *
     * uses a query string to filter through the delivery points
     */
    public function searchAllDeliveryPoints($query): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                 FROM delivery_point
                 INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                 INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userId
                 WHERE delivery_point.name LIKE :searchTerm OR
                       delivery_point.address_1 LIKE :searchTerm OR
                       delivery_point.address_2 LIKE :searchTerm OR
                       delivery_point.postcode LIKE :searchTerm OR
                       delivery_point.lat LIKE :searchTerm OR
                       delivery_point.lng LIKE :searchTerm OR
                       delivery_users.username LIKE :searchTerm OR
                       delivery_status.status_text LIKE :searchTerm';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $databaseQuery = '%' . $query . '%';
        $statement->bindParam(':searchTerm', $databaseQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }

    /**
     * @param $userid
     * @param $query
     * @return array
     *
     * uses a query string to search but only returns delivery points relevant to the deliverer
     */
    public function searchAllDeliveryPointsWithUserId($userid, $query): array
    {
        $sqlQuery = 'SELECT delivery_point.*, delivery_status.status_text, delivery_users.username
                 FROM delivery_point
                 INNER JOIN delivery_status ON delivery_point.status = delivery_status.id
                 INNER JOIN delivery_users ON delivery_point.deliverer = delivery_users.userId
                 WHERE deliverer=:userid AND
                       delivery_point.name LIKE :searchTerm OR
                       delivery_point.address_1 LIKE :searchTerm OR
                       delivery_point.address_2 LIKE :searchTerm OR
                       delivery_point.postcode LIKE :searchTerm OR
                       delivery_point.lat LIKE :searchTerm OR
                       delivery_point.lng LIKE :searchTerm OR
                       delivery_users.username LIKE :searchTerm OR
                       delivery_status.status_text LIKE :searchTerm';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $databaseQuery = '%' . $query . '%';
        $statement->bindParam(':searchTerm', $databaseQuery);
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }

    /**
     * @param $id
     * @return DeliveryPoint|null
     *
     * retrieves a specific delivery points information by id
     */
    public function fetchDeliveryPointInfoById($id)
    {
        $sqlQuery = 'SELECT * FROM delivery_point WHERE id = :id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new DeliveryPoint($row);
        } else {
            return null;
        }
    }

    /**
     * @param $id
     * @param $name
     * @param $address_1
     * @param $address_2
     * @param $postcode
     * @param $deliverer
     * @param $lat
     * @param $lng
     * @param $status
     * @param $del_photo
     * @return void
     *
     * updates a delivery point by id
     */
    public function updateDeliveryPoint($id, $name, $address_1, $address_2, $postcode, $deliverer, $lat, $lng, $status, $del_photo) {
        $sqlQuery = "UPDATE delivery_point SET 
                 name = :name, 
                 address_1 = :address_1, 
                 address_2 = :address_2, 
                 postcode = :postcode, 
                 deliverer = :deliverer, 
                 lat = :lat, 
                 lng = :lng, 
                 status = :status, 
                 del_photo = :del_photo
                 WHERE id = :id";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':address_1', $address_1);
        $statement->bindParam(':address_2', $address_2);
        $statement->bindParam(':postcode', $postcode);
        $statement->bindParam(':deliverer', $deliverer, PDO::PARAM_INT);
        $statement->bindParam(':lat', $lat);
        $statement->bindParam(':lng', $lng);
        $statement->bindParam(':status', $status, PDO::PARAM_INT);
        $statement->bindParam(':del_photo', $del_photo);

        $statement->execute();

    }

}


