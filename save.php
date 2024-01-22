<?php
session_start();
include_once('functions.php');
include_once('database.php');

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
unset($_SESSION['errors']);
// $data = filterData($data, $allowedData);
// $errors = validate($data, $rules);

if (!empty($errors)) {
    // foreach ($errors as $key => $err) {
    //     echo '<div>'. $err . '</div>';
    // }

    $_SESSION['errors'] = $errors;
    header('Location: index.php');    
    exit;
}


// save the data to database
// $result = saveAddress($data);
$result = saveAddressWithPreparedStatement($data);


if ($result === true) {
    $_SESSION['success'] = true;
    $_SESSION['email'] = $data['email'];
}
elseif (is_string($result)) {
    $errors[] = $result;
    $_SESSION['errors'] = $errors;
}
else {
    $errors[] = 'Error saving address to database';
    $_SESSION['errors'] = $errors;
}

header("Location: index.php");
exit;
