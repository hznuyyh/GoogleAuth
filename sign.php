<?php
/**
 * Created by PhpStorm.
 * User: Yeyuhang
 * Date: 2016/11/26
 * Time: 17:29
 */
require "GoogleAuthenticator.php";
if($_POST["sign"]){
	$ga = new PHPGangsta_GoogleAuthenticator();

	$account = $_POST['account'];
	$password = $_POST['password'];
	$phone = $_POST['phone'];
	$db = mysqli_connect('**数据库地址**'.':'.'***数据库端口***','***account***','****account key*****','**数据库名称**');
	if($db){
		$secret = $ga->createSecret();
		$sql = "INSERT INTO user (user_name,password,secert,phone) VALUES ('$account','$password','$secret','$phone')";
		if (mysqli_query($db, $sql)) {
			echo "<script>";
			echo "alert('注册成功');";
			echo "window.location='index.php';";
			echo "</script>";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($db);
		}
	}

}
?>