<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Models/LoginSystem.php';
require_once 'Models/Database.php';
$view = new stdClass();
$view->pageTitle = 'Login';
// Include the user model and database connection files

// Instantiate the database connection and user model
$dbInstance = Models\Database::getInstance();
$dbConnection = $dbInstance->getdbConnection();
$loginSystem = new \Models\LoginSystem($dbConnection);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use the user model to get user data by username
    $user = $loginSystem->getUserByUsername($username);
    // Validate the password and check if the user exists
    if ($user && $loginSystem->verifyPassword($user['password'], $password)) {
        // Set user session with user ID and type
        // Store the user type name
        $_SESSION['user_data'] = [
            'user_id' => $user['userid'],
            'user_name' => $user['username'],
            'user_type' => $user['usertype'],
            'user_type_name' => $user['usertypename']
        ];

        // Redirect to the dashboard if authentication is successful
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['login_error'] = 'Either the username or the password is incorrect.';
        // if log in fails redirect to login page
        header('Location: index.php');
        exit();
    }
}
require ('Views\index.phtml');