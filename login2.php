<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/27
 * Time: 21:11
 */
$_pass_ = $_POST['confirm'];
if($_pass_== $oneCode){
	echo "<scipt>";
	echo "alert('登录成功')";
	echo "</script>";
}
else{
	echo "<scipt>";
	echo "alert('验证失败')";
	echo "</script>";
}
?>