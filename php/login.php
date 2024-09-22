<?php
session_start();
include_once "config.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($email) && !empty($password)) {
    // Check if the email exists in the database
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    if (mysqli_num_rows($sql) > 0) { // if the email exists
        $row = mysqli_fetch_assoc($sql);
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['unique_id'] = $row['unique_id']; // store user unique_id in session
            echo "Success!";
        } else {
            echo "Email or Password is incorrect!";
        }
    } else {
        echo "Email or Password is incorrect!";
    }
} else {
    echo "All input fields are required!";
}
?>
