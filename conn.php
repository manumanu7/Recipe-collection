<?php

    $host="localhost";
    $user="root";
    $pass="";
    $database="recipe";

    $conn=mysqli_connect($host,$user,$pass,$database);
    if(!$conn){
        die("connection Failed");
    }

?>