<?php

namespace Models;

class DeliveryUser
{

    protected $_userId, $_username, $_password, $_userType, $_userTypeName;

    public function __construct($dbRow)
    {
        $this->_userId = $dbRow['userid'];
        $this->_username = $dbRow['username'];
        $this->_password = $dbRow['password'] ?? null;
        $this->_userType = $dbRow['usertype'] ?? null;
        $this->_userTypeName = $dbRow['usertypename'] ?? null;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function getUserType()
    {
        return $this->_userType;
    }
    public function getUserTypeName()
    {
        return $this->_userTypeName;
    }
}