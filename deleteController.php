<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
use Models\DeliveryPointDataSet;

require_once 'Models/DeliveryPointDataSet.php';
$deliveryPointDataSet = new DeliveryPointDataSet();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) { // if delete button is pressed, take the id value from the button
    $deliveryPointDataSet->deleteDeliveryPoint($_POST['delete']); // and pass it to the model to delete from database
    $_SESSION['deleteMessage'] = "You successfully deleted delivery " . htmlspecialchars($_POST['delete']) . "."; // send success message to view
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['closeDeleteMessage'])){ //close the message
    unset($_SESSION['deleteMessage']);
    header('Location: index.php');
}

