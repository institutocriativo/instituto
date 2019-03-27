<?php

# CREATE TABLE admin2018 (username VARCHAR(255) PRIMARY KEY, password VARCHAR(255) NOT NULL, session VARCHAR(255));

$Database_Name = 'instit93_concurso2018';
$Database_Username = 'instit93_con2018';
$Database_Password = 'u^i{o~U$G422';

$password = "";
$session = "";

$Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
if($Database_connection === false) {
    $status = "Error connecting to DB";
} else {
    mysqli_set_charset($Database_connection,"utf8");
    $selectquery = mysqli_query($Database_connection, 'SELECT password, session FROM admin2018 WHERE username LIKE "admin";');
    if(mysqli_num_rows($selectquery)>0) {
        while($row = mysqli_fetch_assoc($selectquery)) {
            $password = $row["password"];
            $session = $row["session"];
        }
    } else {
        $status = "Error in query";
    }
}

?>