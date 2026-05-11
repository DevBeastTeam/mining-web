<?php

// connection with database 
$conn = mysqli_connect("localhost", "root", "", "mining-db");

// check connection 
if (!$conn) {
    die("not connected");
}


$users = mysqli_query($conn, "SELECT * FROM `users`");

if (mysqli_num_rows($users) > 0) {
    $result = mysqli_fetch_all($users, MYSQLI_ASSOC);
    echo json_encode($result);
} else {
    echo json_encode(array("message" => "no data"));
}



?>