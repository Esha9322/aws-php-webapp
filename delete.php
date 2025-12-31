<?php
require 'db.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

// 1️⃣ Fetch record (to get S3 file name)
$stmt = $conn->prepare("SELECT file_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Record not found");
}

$row = $result->fetch_assoc();
$fileName = $row['file_name'];
$email = $row['email'];

// 2️⃣ Delete file from S3 (if exists)
if (!empty($fileName)) {
    try {
        $s3 = new S3Client([
            'region'  => 'us-east-1',   // change if needed
            'version' => 'latest'
        ]);

        $s3->deleteObject([
            'Bucket' => 'webapp-files-youruniqueid',
            'Key'    => $fileName
        ]);

        // 🔹 CloudWatch log (S3 delete)
        error_log("DELETE | User=$email | File=$fileName");

    } catch (Exception $e) {
        error_log("S3 DELETE ERROR: " . $e->getMessage());
    }
}

// 3️⃣ Delete record from database
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// 4️⃣ Redirect back
header("Location: display.php");
exit;

