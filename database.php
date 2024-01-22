<?php

/*
CREATE TABLE address (
	id int(10) unsigned not null PRIMARY KEY AUTO_INCREMENT,
	firstname varchar(50) not null,
	lastname varchar(50) not null,
	street varchar(50) not null,
	street_number varchar(10) not null,
	postcode varchar(5) not null,
	city varchar(50) not null,
	email varchar(50) not null,
	phone varchar(20) not null
) 
 */

include_once('config.php');

/**
 * Connect to database
 * @return mysqli
 */
function connect()
{
    global $host, $username, $password, $dbname, $port;
    $mysqli = new mysqli($host, $username, $password, $dbname, $port);
    
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    return $mysqli;
}

/**
 * Save address to database without prepared statements
 * 
 * @param array $data
 * @return bool
 */
function saveAddress($data)
{
    $mysqli = connect();

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($value);
    }

    $sql = 'INSERT INTO address(firstname, lastname, street, street_number, postcode, city, email, phone) 
        VALUES("' . $data['firstname'] . '", "' . $data['lastname'] . '", "' . $data['street'] . '", "' . $data['street_number'] . '", 
        "' . $data['postcode'] . '", "' . $data['city'] . '", "' . $data['email'] . '", "' . $data['phone'] . '")';    

    $result = $mysqli->query($sql);
    if ($result === false) {
        return $mysqli->error;        
    }

    return $result;
}

/**
 * Save address to database with prepared statement
 * 
 * @param array $data
 */
function saveAddressWithPreparedStatement($data)
{
    $mysqli = connect();
    $sql = 'INSERT INTO address(firstname, lastname, street, street_number, postcode, city, email, phone) VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssssss', $data['firstname'], $data['lastname'], $data['street'], $data['street_number'], $data['postcode'], $data['city'], $data['email'], $data['phone']);
    $result = $stmt->execute();
    $stmt->close();
    $mysqli->close();
    return $result;
}

/**
 * Get address for email without proper escaping
 * 
 * @param string $email
 * @return array
 */
function unsafeGetAddressForEmail($email)
{
    $result = [];
    $mysqli = connect();
    // $email = $mysqli->real_escape_string($email);    
    $sql = 'SELECT id, firstname, lastname FROM address where email = "' . $email . '"';
    // echo $sql . "<br>";
    
    // $dbResult = $mysqli->query($sql);
    // if ($dbResult) {
    //     while ($row = $dbResult->fetch_assoc()) {            
    //         $result[] = [$row['id'], $row['firstname'], $row['lastname']];
    //     }
    // }

    $mysqli->multi_query($sql);
    do {
        if ($dbResult = $mysqli->store_result()) {
            while ($row = $dbResult->fetch_assoc()) {
                $result[] = [$row['id'], $row['firstname'], $row['lastname']];
            }
        }
    } while ($mysqli->next_result());

    $mysqli->close();
    return $result;
}

/**
 * Get address for email with prepared statement
 * 
 * @param string $email
 * @return array
 */
function getAddressForEmail($email)
{
    $result = [];
    $mysqli = connect();
    $sql = 'SELECT id, firstname, lastname FROM address WHERE email = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($id, $firstname, $lastname);

    while ($stmt->fetch()) {
        $result[] = [$id, $firstname, $lastname];
    }
    
    $stmt->close();
    $mysqli->close();
    return $result;
}
