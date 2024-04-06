<?php
$hostname="localhost";
$dbuser="root";
$dbpassword="";
$dbname="techcity";

$conn = mysqli_connect($hostname,$dbuser,$dbpassword,$dbname);
if(!$conn){
    die("check later");
}
?>