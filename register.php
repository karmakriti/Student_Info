<?php
// create the connection of the database
// 4:parameter

$dbHost = 'localhost';
$dbUsername = 'root';
$dbpassword = '';
$dbusername = 'ilac';

//Create database connection

$conn = new mysqli($dbHost,$dbUsername, $dbpassword, $dbusername);

//Verification
//verify that the connection is built

if($conn ->connect_error){
    die("Connection failed".$conn ->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'] ;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //using hash takes two parameter

//now the connection is built, so we create query
    $sql ="INSERT INTO ilacstudents (username, password) VALUES ('$username','$password')";
    //checkc sql is executed

    $results= $conn ->query($sql);

    if ($results == TRUE){
        echo "Registration Successful";
        //take me back to the home page
        sleep(5);
        header( "Location: home.html");
    }
    else{
        echo "Error" . $sql ."<br>".$conn->error;
    }
    conn -> close();
}else{
    echo "Invalid request method";
}
