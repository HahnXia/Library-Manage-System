<?php
session_start();
if( !isset($_SESSION["login_stu"])){
 echo "你还没有登陆,无法操作!";
 exit;
}
if(isset($_POST["borrowbooknum"]) && $_POST["borrowbooknum"]!=""){
    $borrowbooknum=$_POST["borrowbooknum"];
    include 'conn.php';
    $query="select * from book where bno='$borrowbooknum'";
    $result=mysqli_query($id,$query);
    $info=mysqli_fetch_array($result, MYSQLI_ASSOC);
 
    $query5="select * from borrow where bno='$borrowbooknum' and return_date is null and cno=".$_SESSION['cno'].";";
    $result5=mysqli_query($id,$query5);
 
    if(mysqli_num_rows($result)<1){
        echo "<script language=javascript>alert('该书本不存在!请重新输入正确书号!');location.href='../php/main_stu.php';</script>";
    }else if($info['stock']==0){
       $query2="select * from borrow where bno='$borrowbooknum' and return_date is not null order by return_date DESC;";
       $result2=mysqli_query($id,$query2);
       $info2=mysqli_fetch_array($result2, MYSQLI_ASSOC);
       echo "<script language=javascript>alert('该书本库存不足!最近归还时间：".$info2['return_date']."');location.href='../php/main_stu.php';</script>";
    }else if(mysqli_num_rows($result5)>0){
       echo "<script language=javascript>alert('此本书你已经借过一次且未归还!');location.href='../php/main_stu.php';</script>";
    }
    else{
        $query3="update book set stock=stock-1 where bno='$borrowbooknum'";
        mysqli_query($id,$query3);
        $date = date('Y-m-d H:i:s');
        $query4="insert into borrow values('".$_SESSION['cno']."','$borrowbooknum','$date',NULL);";
        mysqli_query($id,$query4);
        echo "<script language=javascript>alert('借书成功!');location.href='../php/main_stu.php';</script>";
    }
    mysqli_close($id);
}

if(isset($_POST["returnbooknum"]) && $_POST["returnbooknum"]!=""){
 $returnbooknum=$_POST["returnbooknum"];
include 'conn.php';
 $query="select * from book where bno='$returnbooknum'";
 $result=mysqli_query($id,$query);
 $info=mysqli_fetch_array($result, MYSQLI_ASSOC);
 $query4="select * from borrow where cno=".$_SESSION['cno']." and bno='$returnbooknum' and return_date is NULL;" ;
 $result4=mysqli_query($id,$query4);
 if(mysqli_num_rows($result)<1){
    echo "<script language=javascript>alert('该书本不存在!请重新输入正确书号!');location.href='../php/main_stu.php';</script>";
 }else if(mysqli_num_rows($result4)<1){
     echo "<script language=javascript>alert('你没借过这本书（或者已归还）！');location.href='../php/main_stu.php';</script>";
 }
 else{
     $query2="update book set stock=stock+1 where bno='$returnbooknum'";
     mysqli_query($id,$query2);
     $date = date('Y-m-d H:i:s');
     $query3="update borrow set return_date='$date' where bno='$returnbooknum' and return_date is null and cno=".$_SESSION['cno'].";";
     mysqli_query($id,$query3);
     echo "<script language=javascript>alert('还书成功!');location.href='Main_stu.php';</script>";
 }
 mysqli_close($id);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>阡陌图书管理系统</title>
	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bootstrap/css/dashboard.css">
	<!-- jQuery文件 -->
	<script src="../bootstrap/js/jquery-3.2.0.min.js"></script>
	<!-- Bootstrap 核心 JavaScript 文件 -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
  		<div class="container">
  		<div class="navbar-header navbar-brand">
  			<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
 		</div>
 		<ul class="nav navbar-nav navbar-left">
    		<h class="navbar-brand" style="font-weight:bold;font-size: 1.5em;">阡陌图书管理系统</h>
		</ul>
    	<ul class="nav navbar-nav navbar-right">
        	<li><a href="../php/logout_stu.php">安全退出</a></li>
    	</ul>
  		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					<li><a href="../php/Search_borrow_stu.php?param=<?php echo $_SESSION['cno']?>">已借图书</a></li>
                                        <li><a href="../php/Main_stu.php">书目操作</a></li>
                                        <li><a href="Select_book.php">图书查询</a></li>
				</ul>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h3 class="sub-header">借书</h3>
				<form class="form-horizontal" action="../php/Main_stu.php" method="post">
				<div class="form-group">
    				<label for="bookid" class="control-label col-sm-1">书号</label>
    				<div class="col-sm-5">
    				<input type="text" class="form-control " id="bookid" name="borrowbooknum">
    				</div>
    				<button type="submit" class="btn btn-default">确定</button>
 				 </div>
				</form>
				<h3 class="sub-header" >还书</h3>
				<form class="form-horizontal"action="../php/Main_stu.php" method="post">
				<div class="form-group">
    				<label for="bookid" class="control-label col-sm-1">书号</label>
    				<div class="col-sm-5">
    				<input type="text" class="form-control " id="bookid" name="returnbooknum">
    				</div>
    				<button type="submit" class="btn btn-default">确定</button>
 				 </div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>


<!--<HTML>
<HEAD>
<TITLE>学生操作主界面</TITLE>
</HEAD>
<BODY>
<table border=1 cellspacing=0 cellspadding=0 style="border-collapse:collapse" align=center width=400 bordercolor=black height="358">
<tr><td height=100 bgcolor=#6C6C6C>
<font style="font-size:30px" color=#ffffff face="黑体">学生操作主界面</font>
</td>

<tr><td height=178>
        <form method="POST" action="Main_stu.php">
	<table border="1" width="95%" id="table1" cellspacing="0" cellpadding="0" bordercolor="#808080" style="border-collapse: collapse" height="154">
		<tr>
			<td colspan="2" height="29">
			<p align="center">借书</td>
		</tr>
		<tr>
			<td width="32%">
			<p align="right">借书_输入书号</td>
			<td width="67%"><input type="text" name="borrowbooknum" size="20"></td>
		</tr>
		<tr>
			<td width="99%" colspan="2">
				<p align="center"><input type="submit" value="确定" name="B1"></p>		
			</td>
		</tr>
	</table>
	</form>
	</td></tr>
<tr><td height=178>
        <form method="POST" action="Main_stu.php">
	<table border="1" width="95%" id="table1" cellspacing="0" cellpadding="0" bordercolor="#808080" style="border-collapse: collapse" height="154">
		<tr>
			<td colspan="2" height="29">
			<p align="center">还书</td>
		</tr>
	
		<tr>
			<td width="32%">
			<p align="right">还书_输入书号</td>
			<td width="67%"><input type="text" name="returnbooknum" size="20"></td>
		</tr>
		<tr>
			<td width="99%" colspan="2">
				<p align="center"><input type="submit" value="确定" name="B1"></p>		
			</td>
		</tr>
	</table>
	</form>
	</td></tr>
<tr><td height=78>
        <a href="Search_borrow_stu.php?param=">[查询本书借书记录]</a>
	</td></tr>
<tr><td height=78>
        <a href="Logout_stu.php">[登出]</a>
	</td></tr>
<tr><td height=58 bgcolor=#6c6c6c align=center>
<font color=#FFFFFF>版权所有：夏涵<br>E-mail:987240783@qq.com
</td></tr>
</table>
</body>
</html>-->