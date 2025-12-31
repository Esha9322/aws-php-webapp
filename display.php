<?php
include 'db.php';
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
</head>
<body>
<h2>Stored Users</h2>
<table border="1">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
</tr>
<?php } ?>

</table>
<br>
<a href="index.php">Add New User</a>
</body>
</html>

