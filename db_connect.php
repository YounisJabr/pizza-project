<?php
// concocting to database
$conn= mysqli_connect("localhost","root","","pizza_stor"); # after making the connection
if(!$conn){
    echo "Connection error".mysqli_connect_error();
}

