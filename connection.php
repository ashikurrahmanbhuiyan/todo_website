<?php
$conn = mysqli_connect("localhost","root","","notes");
    if(!$conn){
        die("Sorry we failed to connect: ".mysqli_connect_error());
    }
?>