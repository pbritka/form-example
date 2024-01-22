<?php 
session_start();
include_once('database.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Your address</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="container mx-auto p-5 text-center">
            <?php
                if (!empty($_SESSION['email'])) {
                    $addressData = getAddressForEmail($_SESSION['email']);
                    if (!empty($addressData)) {
                        echo 'Address data for email <b>' . $_SESSION['email'] . '</b><br><br>';
                        foreach ($addressData as $address) {
                            echo $address[0] . ': ' . $address[1] . ' ' . $address[2] . '<br>';
                        }
                    }
                }

                if (!empty($_SESSION['errors'])) {
                    foreach ($_SESSION['errors'] as $key => $err) {
                        echo '<div>'. $err . '</div>';
                    }
                }
                if (!empty($_SESSION['success'])) {
                    unset($_SESSION['success']);
                    echo '<div>Success!</div>';
                }
            ?>
            <h1 class="text-3xl font-bold underline">Enter your address</h1>
            <form action="save.php" method="post" class="p-5 mx-auto w-3/4">
                <input type="text" name="data[firstname]" placeholder="First Name" class="border-2 border-gray-400 p-2 w-3/4 rounded-lg my-2">
                <input type="text" name="data[lastname]" placeholder="Last Name" class="border-2 border-gray-400 p-2 w-3/4 rounded-lg my-2">
                <div class="flex w-3/4 mx-auto gap-1">
                    <input type="text" name="data[street]" placeholder="Street" class="border-2 border-gray-400 p-2 w-3/4 rounded-lg my-2">
                    <input type="number" name="data[street_number]" placeholder="Street number" class="border-2 border-gray-400 p-2 w-1/4 rounded-lg my-2">                
                </div>
                <div class="flex w-3/4 mx-auto gap-1">
                    <input type="text" name="data[postcode]" placeholder="Postcode" class="border-2 border-gray-400 p-2 w-1/4 rounded-lg my-2">
                    <input type="text" name="data[city]" placeholder="City" class="border-2 border-gray-400 p-2 w-3/4 rounded-lg my-2">                
                </div>
                <input type="email" name="data[email]" placeholder="Email" class="border-2 border-gray-400 p-2 w-3/4 rounded-lg my-2">
                <input type="phone" name="data[phone]" placeholder="Telephone" class="border-2 border-gray-400 p-2 w-3/4 rounded-lg my-2">
                <input type="submit" value="Submit" class="border-2 border-gray-400 p-2 w-1/4 rounded-lg my-2 bg-blue-300 hover:bg-blue-400">
            </form>
        </div>                
    </body>
</html>