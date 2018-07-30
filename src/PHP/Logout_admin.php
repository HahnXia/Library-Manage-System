<?php
session_start();
unset ($_SESSION['login_admin']) ;
unset ($_SESSION['aid']) ;
echo "<script language=javascript>alert('注销成功!');location.href='../html/login.html';</script>";
exit;
?>