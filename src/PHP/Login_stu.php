<?php

if(isset($_POST["cno"]) && $_POST["cno"]!=""){
    $cno=$_POST["cno"];
 $password=$_POST["password"];
include 'conn.php';
 $query="select * from card where cno='$cno'";
 $result=mysqli_query($id,$query);
 if(mysqli_num_rows($result)<1){
 echo "该用户不存在!请重新登陆!";
 }else{
 $info=mysqli_fetch_array($result, MYSQLI_ASSOC);
 if($info['pass']!=$password){
 echo "密码输入错误!请重新登陆!";
 }else{
  session_start();
  $_SESSION["login_stu"]="YES";
  $_SESSION["cno"]=$cno;
  echo "<script language=javascript>alert('登陆成功!');location.href='../php/main_stu.php';</script>";
  exit;
   }
 }
 mysqli_close($id);
}
?>
