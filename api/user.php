<?php

// connection with database 
$conn = mysqli_connect("localhost", "root", "", "mining-db");

// check connection 
if (!$conn) {
    die("not connected");
}



if (isset($_GET['uid'])) {
    $id = trim($_GET['uid']);
    if ($id == null || $id == "") {
        echo json_encode(array("message" => "uid value is empty"));
    } else {
        $users = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = $id");
        if (mysqli_num_rows($users) > 0) {
            $result = mysqli_fetch_all($users, MYSQLI_ASSOC);
            echo json_encode($result);
        } else {
            echo json_encode(array("message" => "no data"));
        }
    }
} else {
    echo json_encode(array("message" => "User Id Required with key name uid"));
}



?>