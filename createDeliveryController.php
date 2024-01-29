<?php

namespace Controllers;

//get all the required files and information
require_once 'Models/DeliveryUserDataSet.php';
require_once 'Models/DeliveryPointDataSet.php';
use Models\DeliveryPointDataSet;
use stdClass;

//if a session hasnt started, start one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$view = new Stdclass();
$deliveryPointDataSet = new DeliveryPointDataSet(); // create a new dataset to work with

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_delivery_form'])){
    $_SESSION['deliveryform'] = true; //if the create delivery button was pressed, set the delivery form to show in the view
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_creation'])){
    unset($_SESSION['deliveryform']); //if the creation is cancelled, unset the delivery form from the view
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_creation'])) { //if the admin confirms the delivery creation
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); //filter input, make sure the sql query interprets the input as a string
    $address1 = filter_input(INPUT_POST, 'address_1', FILTER_SANITIZE_STRING); // and not as part of the sql query, sql injection protection
    $address2 = filter_input(INPUT_POST, 'address_2', FILTER_SANITIZE_STRING); // this applies to all the variables here
    $postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);
    $deliverer = filter_input(INPUT_POST, 'deliverer', FILTER_VALIDATE_INT);
    $lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_STRING);
    $lng = filter_input(INPUT_POST, 'lng', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
    $del_photo = filter_input(INPUT_POST, 'del_photo', FILTER_SANITIZE_STRING);
    $deliveryPointDataSet->createDeliveryPoint($name, $address1, $address2, $postcode, $deliverer, $lat, $lng, $status, $del_photo); //sends the data to the model to create the point
    $_SESSION['createSuccessMessage'] = 'You successfully created a new delivery'; // sends the conditional message to the view

    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['closeCreateMessage'])){
    unset($_SESSION['createSuccessMessage']); //once user presses close on the message, unsets it from the view
    header('Location: index.php');
}