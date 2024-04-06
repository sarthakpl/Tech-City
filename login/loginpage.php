<?php

require_once "database.php";

$email_error = $password_error = "";

$email = $password = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty(trim($_POST['email']))) {
        $email_error = "Please enter your email";
    } else {
        $email = $_POST['email'];
    }

    if (empty(trim($_POST['password']))) {
        $password_error = "Please enter your password";
    } else {
        $password = $_POST['password'];
    }

    if (empty($email_error) and empty($password_error)) {

        $sql = "SELECT id, email, pwd FROM user_tbl WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, 's', $param_email);

        $param_email = $email;

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {

                mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);

                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {

                        session_start();

                        $_SESSION['email'] = $email;
                        $_SESSION['id'] = $id;
                        $_SESSION['isLoggedIn'] = true;

                        header("location: ../index.php");
                    } else {
                        $password_error = "Incorrect Password";
                    }
                }
            } else {
                $email_error = "Email not registered";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <title>Login Page with Background Image Example</title>
     <link rel="stylesheet" href="./style.css">

     <style>
     .form-field {
          flex-direction: column;
     }
     </style>

</head>

<body>
     <div id="bg"></div>

     <form action="#" method="post">

          <div class="form-field">
               <input type="email" placeholder="Email / Username" required name="email">
               <div style="color: red; width: 100%; margin-top: 4px;"><?php echo $email_error; ?></div>
          </div>


          <div class="form-field">
               <input type="password" placeholder="Password" required name="password">
               <div style="color: red; width: 100%; margin-top: 4px;"><?php echo $password_error; ?></div>
          </div>

          <div class="form-field" style="flex-direction: row;">
               <button class="btn" type="submit" name="lo">Login</button>
               <a class="btn" style="text-decoration: none;" href="./Register/register.php">Register</a>
          </div>
     </form>
</body>

</html>