<?php
require 'db.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($email)) {
        $message = "Name and Email required";
    } else {

        $fileNameInS3 = null;

        /* ===============================
           FILE VALIDATION (SECURITY)
           =============================== */

        if (!empty($_FILES['file']['name'])) {

            // 1️⃣ File size limit (2 MB)
            $MAX_SIZE = 2 * 1024 * 1024; // 2MB
            if ($_FILES['file']['size'] > $MAX_SIZE) {
                die("File too large. Max allowed size is 2MB.");
            }

            // 2️⃣ File type validation
            $allowedTypes = ['jpg','jpeg','png','pdf'];
            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedTypes)) {
                die("Invalid file type. Only PDF, JPG, PNG allowed.");
            }

            // 3️⃣ Safe + unique file name
            $safeFileName = time() . "_" .
                preg_replace("/[^a-zA-Z0-9._-]/", "", $_FILES['file']['name']);

            /* ===============================
               S3 UPLOAD
               =============================== */

            try {
                $s3 = new S3Client([
                    'region'  => 'us-east-1',   // change if needed
                    'version' => 'latest'
                ]);

                $s3->putObject([
                    'Bucket'      => 'webapp-files-youruniqueid',
                    'Key'         => $safeFileName,
                    'Body'        => fopen($_FILES['file']['tmp_name'], 'rb'),
                    'ACL'         => 'private',
                    'ContentType' => mime_content_type($_FILES['file']['tmp_name'])
                ]);

                $fileNameInS3 = $safeFileName;

                // ✅ CloudWatch log (upload)
                error_log("UPLOAD | User=$email | File=$fileNameInS3");

            } catch (AwsException $e) {
                error_log("S3 ERROR: " . $e->getMessage());
                die("File upload failed");
            }
        }

        /* ===============================
           SAVE TO DATABASE
           =============================== */

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, file_name) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $email, $fileNameInS3);
        $stmt->execute();

        header("Location: display.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Add User + Upload File</h2>

<p style="color:red;"><?php echo $message; ?></p>

<form method="POST" enctype="multipart/form-data">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    File: <input type="file" name="file"><br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>

