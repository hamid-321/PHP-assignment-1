<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
use Models\DeliveryPointDataSet;

require_once 'Models/DeliveryPointDataSet.php';
$view = new stdClass();

$deliveryPointDataSet = new DeliveryPointDataSet(); // create a new dataset to work with
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])){  // if the edit button was pressed
    $_SESSION['editform'] = true; // show the edit form
    $deliveryPoint = $deliveryPointDataSet->fetchDeliveryPointInfoById($_POST['edit']);  // get the corresponding delivery point by id
    // create a session to send the information about the delivery point to the view, to populate input fields and allow the user to edit the fields
    $_SESSION['delivery_data'] = [
        'id' => $deliveryPoint->getId(),
        'name' => $deliveryPoint->getName(),
        'address1' => $deliveryPoint->getAddress1(),
        'address2' => $deliveryPoint->getAddress2(),
        'postcode' => $deliveryPoint->getPostcode(),
        'deliverer' => $deliveryPoint->getDeliverer(),
        'lat' => $deliveryPoint->getLat(),
        'lng' => $deliveryPoint->getLng(),
        'status' => $deliveryPoint->getStatus(),
        'del_photo' => $deliveryPoint->getDelPhoto()
    ];
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_edit'])){ //if the cancel button is pressed, close the edit form and redirect
    unset($_SESSION['editform']);
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_edit'])) { //admin confirms the edit with new information for the datapoints
    $id = filter_input(INPUT_POST, 'confirm_edit', FILTER_VALIDATE_INT);//filter input, make sure the sql query interprets the input as a string
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); // and not as part of the sql query, sql injection protection
    $address1 = filter_input(INPUT_POST, 'address_1', FILTER_SANITIZE_STRING); // this applies to all the variables here
    $address2 = filter_input(INPUT_POST, 'address_2', FILTER_SANITIZE_STRING);
    $postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);
    $deliverer = filter_input(INPUT_POST, 'deliverer', FILTER_VALIDATE_INT);
    $lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_STRING);
    $lng = filter_input(INPUT_POST, 'lng', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
    $del_photo = filter_input(INPUT_POST, 'del_photo', FILTER_SANITIZE_STRING);
    // sends the new info to model which UPDATES existing point
    $deliveryPointDataSet->updateDeliveryPoint($id, $name, $address1, $address2, $postcode, $deliverer, $lat, $lng, $status, $del_photo);
    $_SESSION['editSuccessMessage'] = 'You successfully edited the delivery'; //success message
    unset($_SESSION['editform']); //removes the edit form after completion
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['closeEditMessage'])){ //remove success message
    unset($_SESSION['editSuccessMessage']);
    header('Location: index.php');
}