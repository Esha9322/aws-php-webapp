<?php
require 'db.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;

// Create S3 client (uses EC2 IAM role)
$s3 = new S3Client([
    'region'  => 'us-east-1',   // change if needed
    'version' => 'latest'
]);
?>

<!DOCTYPE html>
<html>
<body>

<h2>Users List</h2>

<table border="1" cellpadding="8">
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Email</th>
  <th>File</th>
  <th>Date</th>
  <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");

while ($row = $result->fetch_assoc()) {

    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['email']}</td>";

    /* ---------- FILE DOWNLOAD ---------- */
    if (!empty($row['file_name'])) {

        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'webapp-files-youruniqueid', // 🔴 replace with your bucket
            'Key'    => $row['file_name']
        ]);

        $request = $s3->createPresignedRequest($cmd, '+10 minutes');
        $signedUrl = (string) $request->getUri();

        echo "<td>
                <a href='$signedUrl' target='_blank'>Download</a>
              </td>";
    } else {
        echo "<td>No File</td>";
    }

    echo "<td>{$row['uploaded_at']}</td>";

    /* ---------- DELETE BUTTON ---------- */
    echo "<td>
            <a href='delete.php?id={$row['id']}'
               onclick=\"return confirm('Are you sure you want to delete this record?');\"
               style='color:red; font-weight:bold;'>
               Delete
            </a>
          </td>";

    echo "</tr>";
}
?>

</table>

</body>
</html>

