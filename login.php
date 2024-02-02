<?php
session_start();
include "db_conn.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($email) || empty($pass)) {
        header("Location: index.php?error=Email Address and Password are required");
        exit();
    } else {
        $sql = "SELECT * FROM admin WHERE email='$email' AND password='$pass' ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];

            // Redirect to Admin/index.php
            header("Location: Admin/index.php");
            exit();
        } else {
            header("Location: index.php?error=Incorrect Email or password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
