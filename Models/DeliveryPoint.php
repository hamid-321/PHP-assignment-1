<?php
namespace Models;
class DeliveryPoint {

    protected $_id, $_name, $_address_1, $_address_2, $_postcode, $_deliverer,$_lat, $_lng, $_status, $_del_photo, $_status_text, $_username ;

    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_name = $dbRow['name'];
        $this->_address_1 = $dbRow['address_1'];
        $this->_address_2 = $dbRow['address_2'];
        $this->_postcode = $dbRow['postcode'];
        $this->_deliverer = $dbRow['deliverer'];
        $this->_lat = $dbRow['lat'];
        $this->_lng  = $dbRow['lng'];
        $this->_status  = $dbRow['status'];
        $this->_del_photo  = $dbRow['del_photo'];
        $this->_status_text = $dbRow['status_text'] ?? null;
        $this->_username = $dbRow['username'] ?? null;
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }

    public function getAddress1() {
        return $this->_address_1;
    }

    public function getAddress2() {
        return $this->_address_2;
    }

    public function getPostcode() {
        return $this->_postcode;
    }

    public function getDeliverer() {
        return $this->_deliverer;
    }

    public function getLat() {
        return $this->_lat;
    }

    public function getLng() {
        return $this->_lng;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function getDelPhoto() {
        return $this->_del_photo;
    }
    public function getStatusText() {
        return $this->_status_text;
    }
    public function getUsername() {
        return $this->_username;
    }
}