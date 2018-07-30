<?php
session_start();
unset ($_SESSION['login_stu']) ;
unset ($_SESSION['cno']) ;
echo "<script language=javascript>alert('注销成功!');location.href='../html/login.html';</script>";
exit;
?>