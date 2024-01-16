<?php
session_start();
include_once('functions.php');

if (empty($_POST)) {
    header("Location: index.php");
    exit();
}

$data = $_POST['data'];

// var_dump($data);
$allowedData = [
    'firstname',
    'lastname',
    'street',
    'street_number',
    'postcode',
    'city',
    'email',
    'phone'
];

$rules = [
    'firstname' => 'required',
    'lastname' => 'required',
    'street' => 'required',
    'street_number' => 'number',
    'postcode' => 'number',
    'city' => 'required',
    'email' => 'email',
    'phone' => 'phone' 
];

$errors = [];
$data = filterData($data, $allowedData);
$errors = validate($data, $rules);
// var_dump($data);
// exit;
    // if (empty($value)) {
    //     $errors[$key] = 'This field is required';
    // }




// if (!is_numeric($data['street_number'])) {
//     $errors['street_number'] = 'Street number must be a number';
// }
// if (!is_numeric($data['postcode'])) {
//     $errors['postcode'] = 'Postcode must be a number';
// }
// if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
//     $errors['email'] = 'Email is not valid';
// }
// if (!preg_match('/^\+421[0-9]{9}/', $data['phone'])) {
//     $errors['phone'] = 'Phone is not valid';
// }

if (!empty($errors)) {
    // foreach ($errors as $key => $err) {
    //     echo '<div>'. $err . '</div>';
    // }

    include_once('index.php');    
    exit;
}

$_SESSION['success'] = true;
header("Location: index.php");
exit;
