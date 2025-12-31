<?php
$conn = new mysqli(
    "RDS-ENDPOINT",
    "admin",
    "PASSWORD",
    "webappdb"
);

if ($conn->connect_error) {
    die("Database connection failed");
}
?>

