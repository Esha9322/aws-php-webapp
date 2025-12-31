<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<body>
<h2>Add User</h2>
<form method="POST">
Name: <input type="text" name="name" required><br>
Email: <input type="email" name="email" required><br>
<input type="submit" name="submit">
</form>

<?php
if(isset($_POST['submit'])){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $conn->query("INSERT INTO users(name,email) VALUES('$name','$email')");
  header("Location: display.php");
}
?>
</body>
</html>

