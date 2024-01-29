<?php

namespace Controllers;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('Models/DeliveryPointDataSet.php');
require_once('Models/DeliveryUserDataSet.php');
use Models\DeliveryPointDataSet;
use Models\DeliveryUserDataSet;
use stdClass;

// Instantiate the view object
$view = new stdClass();
$view->pageTitle = 'Login';

// Checking if the user is logged in
if (isset($_SESSION['user_data'])) {$userData = $_SESSION['user_data'];
    $view->userTypeName = $userData['user_type_name'];
    $userid = $userData['user_id'];
    //creating datasets to work with
    $deliveryPointDataSet = new DeliveryPointDataSet();
    $deliveryUserDataSet = new DeliveryUserDataSet();

        if ($userData['user_type_name'] === 'Manager') // conditional content if user is a manager
         {
            switch ($_POST['orderer'] ?? 'default'){ //selector with switch to call different fuctions depending on how user wants to order the outputted database

                default;
                    $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoints(); // default case, incase any issue arise
                    break;

                case 1;
                    $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPointsById();
                    break;

                case 2;
                    $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPointsByDeliverer();
                    break;

                case 3;
                    $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPointsByStatus();
                    break;
            }
             $view->deliveryUserDataSet = $deliveryUserDataSet->fetchAllUsers(); // gets all delivery user information to be used in the edit and create forms later
         }
        else
         {
             switch ($_POST['orderer'] ?? 'default') { // if user is not manager (so a deliverer)
//               shows only options which are relevant to non managers, and calls different fuctions
                 default;
                     $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPointsForUserID($userid); //default case
                     break;

                 case 1;
                     $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPointsForUserIDById($userid);
                     break;

                 case 2;
                     $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPointsForUserIDByStatus($userid);
                     break;
             }
         }
} elseif (isset($_SESSION['login_error'])) {  //if log in error occurs, send message to view
    $view->loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // unset the log in error
}

if (isset($_GET['search']) && $_GET['search'] != null) //if  a user submits a search which has text in it
    {
        $userData = $_SESSION['user_data'];
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $userid = $userData['user_id'];
        $query = ($_GET['search']);  //stores the string in a variable
        if ($userData['user_type_name'] === 'Manager') // if user is a manager
        {
            $view->deliveryPointDataSet = $deliveryPointDataSet->searchAllDeliveryPoints($query); //searches ALL points by the query string
        }
        else // if user is not manager (delivery user)
        {
            $view->deliveryPointDataSet = $deliveryPointDataSet->searchAllDeliveryPointsWithUserId($userid, $query); //searches only relevant points which have the user id by the query string
        }
}
// Including the view
require 'Views/index.phtml';
