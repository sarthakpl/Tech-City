<?php

require_once "database.php";


$fname_error = $email_error = $pwd_error = $c_pwd_error = "";
$fname = $email = $pwd = $cpwd = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (empty(trim($_POST['fname']))) {
    $fname_error = "Please Enter your first name";
  } else {
    $fname = $_POST['fname'];
  }


  if (empty(trim($_POST['email']))) {
    $email_error = "Please Enter your Email address";
  } else {
    $email = $_POST['email'];
    $stmt = mysqli_prepare($conn, "SELECT id FROM user_tbl WHERE email = ?");

    if ($stmt) {

      mysqli_stmt_bind_param($stmt, 's', $p_email);

      $p_email = $email;

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
          $email_error = "Email already registered";
        }
      }
    }
  }

  if (empty(trim($_POST['password']))) {
    $pwd_error = "Please Create a password";
  } else {
    if (strlen($_POST['password']) < 6) {
      $pwd_error = "Password length must be between 6 to 12 charactors";
    } else {
      $pwd = $_POST['password'];
    }
  }

  if (empty(trim($_POST['c_password']))) {
    $pwd_error = "Please Create a password";
  } else {
    if (strlen($_POST['c_password']) != strlen($_POST['password'])) {
      $c_pwd_error = "Password must be same";
    } else {
      $cpwd = $_POST['c_password'];
    }
  }


  if (empty($fname_error) and empty($email_error) and empty($pwd_error) and empty($c_pwd_error)) {


    $query = "INSERT INTO user_tbl(fname, email, pwd) VALUES (?,?,?)";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {

      mysqli_stmt_bind_param($stmt, "sss", $p_name, $p_email, $p_pwd);

      $p_name = $fname;
      $p_email = $email;
      $p_pwd = password_hash($pwd, PASSWORD_DEFAULT);


      if (mysqli_stmt_execute($stmt)) {
        header("location: ../loginpage.php");
      } else {
        echo "Someting went wrong";
        echo "
          <script>
          alert('Someting went wrong');
          <script>
        ";
      }
    } else {
      echo "";
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

     <form action="#" method="POST">
          <div class="form-field">
               <input type="text" name="fname" id="fname" placeholder="Enter Full name" value="<?php echo $fname; ?>">
               <div style="color: red; width: 100%; margin-top: 4px;"><?php echo $fname_error; ?></div>
          </div>

          <div class="form-field">
               <input type="email" name="email" placeholder="Enter Email" value="<?php echo $email; ?>" />

               <div style="color: red; width: 100%; margin-top: 4px;"><?php echo $email_error; ?></div>
          </div>

          <div class="form-field">
               <input type="password" name="password" placeholder="Enter Password" id="inputPassword4"
                    value="<?php echo $pwd; ?>">
               <div style="color: red; width: 100%; margin-top: 4px;"><?php echo $pwd_error; ?>
               </div>
          </div>

          <div class="form-field">
               <input type="password" name="c_password" placeholder="Confirm Password" value="<?php echo $cpwd; ?>" />
               <div style="color: red; width: 100%; margin-top: 4px;"><?php echo $c_pwd_error; ?></div>
          </div>

          <div class="form-field">
               <button class="btn" type="submit" value="register" name="submit">Register</button>
          </div>
     </form>

</body>

</html>