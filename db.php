<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "login_app";

$conn = mysqli_connect("localhost", "root", "", "section_19_login_app");

if(!$conn){

    die("Connection failed" . mysqli_connect_error());

} else {
//       echo "Connected";
}

function check_query($result){
    global $conn;
    if(!$result){
        return "Error" . mysqli_error($conn);
    }
    return true;
}



