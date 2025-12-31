<?php
$conn = new mysqli(
  "RDS-ENDPOINT",
  "DB-USERNAME",
  "DB-PASSWORD",
  "DB-NAME"
);

if ($conn->connect_error) {
  die("Database connection failed");
}
?>

