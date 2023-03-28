<?php

//we must include mongoDB driver to our project to work.
// composer mongodb/mongodb:version is the command we use in CLI to install it in our project
// Then, we import autoload.php to the php code.
require './vendor/autoload.php';

// Get the user inputs
$name = $_POST['name'];
$age = $_POST['age'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$contact = $_POST['contact'];

// Connect to the MongoDB server
$mongo = new MongoClient();

// Select the database and collection -- -- 'regmongo' is the local mongoDB name and...
// 'user_profiles' is the collection that I use to store the user profile updating details.
$collection = $mongo->regmongo->user_profiles;

// Insert the document
$data = array(
    'name' => $name,
    'age' => $age,
    'dob' => $dob,
    'address' => $address,
    'contact' => $contact,
);

$insertOneResult = $collection->insertOne($data);

// Display a message to the user
if ($insertOneResult->getInsertedCount() == 1) {
    echo "Data has been successfully inserted!";
} else {
    echo "An error occurred while inserting the data.";
}

?>
