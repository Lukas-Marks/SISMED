<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sismed";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "erro", "message" => "Conexão falhou: " . $conn->connect_error]));
}


