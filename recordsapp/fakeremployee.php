<?php

// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'recordapp_db';

$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Include the Faker library
require_once 'vendor/autoload.php';

// Create a new instance of the Faker generator
$faker = Faker\Factory::create();

// Generate and insert records into the employee table
$employeeRecords = 200;

$query = "INSERT INTO employee (lastname, firstname, office_id, address) VALUES (?, ?, ?, ?)";
$statement = $mysqli->prepare($query);

for ($i = 0; $i < $employeeRecords; $i++) {
    $lastname = $faker->lastName;
    $firstname = $faker->firstName;
    $officeId = $faker->numberBetween(1, 10); // Assuming office IDs range from 1 to 10
    $address = $faker->address;

    $statement->bind_param('ssis', $lastname, $firstname, $officeId, $address);

    if (!$statement->execute()) {
        echo "Error: " . $mysqli->error . "<br>";
    }
}

// Close the database connection
$statement->close();
$mysqli->close();

?>
