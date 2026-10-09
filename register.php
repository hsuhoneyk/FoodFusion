<?php 
include "db.php";

/* Registration only accepts POST submissions from the Join Us form */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = password_hash ($_POST['password'], PASSWORD_DEFAULT);
$role = ($_POST['role'] ?? 'member') === 'admin' ? 'admin' : 'member';

$sql = "INSERT INTO users (first_name, last_name, email, password, role)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $role);

if ($stmt->execute()){
    echo "Registration successful. <a href='index.php'>Go Back</a>";
}else {
    echo "Email already exists. <a href='index.php'>Try again</a>";
}

?>
