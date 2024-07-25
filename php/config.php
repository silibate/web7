<?php
 $hostname = "localhost";
 $username = "root";
 $password = "";
 $dbname = "chat";

 $conn = mysqli_connect($hostname, $username, $password, $dbname);
 if(!$conn){
  echo "Ошибка базы данных: ".mysqli_connect_error();
 }
?>