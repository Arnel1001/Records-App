<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recordapp_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once 'vendor/autoload.php'; // Include the Faker autoloader

// Create a new instance of the Faker generator
$faker = Faker\Factory::create();

// Prepare the SQL statement
$sql = "INSERT INTO office (name, contactnum, email, address, city, country, postal) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

// Populate the 'office' table
for ($i = 0; $i < 200; $i++) {
    $name = $faker->company;
    $contactnum = $faker->phoneNumber;
    $email = $faker->email;
    $address = $faker->address;
    $city = $faker->city;
    $country = $faker->country;
    $postal = $faker->postcode;

    // Bind the parameters to the statement
    $stmt->bind_param("sssssss", $name, $contactnum, $email, $address, $city, $country, $postal);

    if ($stmt->execute()) {
        echo "Record inserted into 'office' table successfully.<br>";
    } else {
        echo "Error inserting record: " . $stmt->error . "<br>";
    }
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
