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

// Generate and insert records into the transaction table
$transactionRecords = 200;

for ($i = 0; $i < $transactionRecords; $i++) {
    $employeeId = $faker->numberBetween(1, 200); // Assuming you have 200 employees
    $officeId = $faker->numberBetween(1, 200); // Assuming you have 200 offices
    $dateLog = $faker->dateTimeThisYear()->format('Y-m-d H:i:s');
    $action = $faker->randomElement(['In', 'Out']);
    $remarks = $faker->realText(50);
    $documentCode = $faker->randomNumber(6);

    $query = "INSERT INTO transaction (employee_id, office_id, datelog, action, remarks, documentcode) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $statement = $mysqli->prepare($query);
    $statement->bind_param('iisssi', $employeeId, $officeId, $dateLog, $action, $remarks, $documentCode);
    
    if (!$statement->execute()) {
        echo "Error: " . $mysqli->error . "<br>";
    }
}

// Close the database connection
$mysqli->close();

?>