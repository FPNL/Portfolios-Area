<?php
	
	// 連接資料庫的Server、帳號、密碼、資料庫
	$db = new mysqli("localhost","peter3036","0910ptad","newmap") or die("數據庫連接失敗!".$mysqli->errno);

	// 設定UTF8相關的選項
	mysqli_query($db,"SET NAMES utf8");
    mysqli_query($db,"CHARACTER SET utf8");
    mysqli_query($db,"SET COLLATION_CONNECTION=utf8_general_ci");
    mysqli_query($db,"SET CHARACTER_SET_CLIENT =utf8");
    mysqli_query($db,"SET CHARACTER_SET_RESULTS =utf8");
    mysqli_query($db,"SET CHARACTER_SET_SERVER = utf8");
    mysqli_query($db,"SET character_set_connection=utf8");
// $servername = "localhost";
// $username = "root";
// $password = "qwer1234";
// $database = "newmap";

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     // echo "Connected successfully"; 
//     }
// catch(PDOException $e)
//     {
//     echo "Connection failed: " . $e->getMessage();
//     }
?>
