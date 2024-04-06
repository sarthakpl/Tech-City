<?php
 $email =$_POST['email'];
 $password =$_POST['password'];

 $conn = new mysqli('localhost','root','','log');
 if($conn->connect_error){
    die('connection fail :' .$conn->connect_error);
}
else{
    $stmt =$conn->prepare("inster into login(email,password)
    values(?,?)");
    $stmt->bind_param("ss",$email,$password);
    $stmt->execute();
    echo "login successfull";
    $stmt->close();
    $conn->close();
}
?>