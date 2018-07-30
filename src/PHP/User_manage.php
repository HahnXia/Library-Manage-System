<?php
session_start();
if( !isset($_SESSION["login_admin"])){
 echo "你还没有登陆,无法操作!";
 exit;
}

if(isset($_POST["cno"]) && $_POST["cno"]!=""
        && isset($_POST["name"]) && $_POST["name"]!=""
        && isset($_POST["department"]) && $_POST["department"]!=""
        && isset($_POST["ctype"]) && $_POST["ctype"]!=""){
    $in_cno=$_POST["cno"];
    $name=$_POST["name"];
    $department=$_POST["department"];
    $ctype=$_POST["ctype"];
    $type="";
    if($ctype=='教职工'){
        $type=1;
    }elseif($ctype=='学生'){
        $type=0;
    }elseif($ctype=='其他'){
        $type=2;
    }
    include 'conn.php';
    $query="insert into card"
            . " values('$in_cno','1234567','$name','$department','$type')";
    if(mysqli_query($id, $query)){
        echo "<script language=javascript>alert('添加成功!');location.href='../php/User_manage.php';</script>";
    }else{
        echo "<script language=javascript>alert('添加失败!请检查借书证格式！');location.href='../php/User_manage.php';</script>";
    }
    mysqli_close($id);
}

if(isset($_POST["delete_cno"]) && $_POST["delete_cno"]!=""){
 $delete_cno=$_POST["delete_cno"];
include 'conn.php';
 $query="select * from card where cno='$delete_cno'";
 $result=mysqli_query($id,$query);
 if(mysqli_num_rows($result)<1){
    echo "<script language=javascript>alert('该借书证不存在,请重新输入卡号!');location.href='../php/User_manage.php';</script>";
 }
 else{
     $query2="delete from card where cno='$delete_cno'";
     mysqli_query($id,$query2);
     echo "<script language=javascript>alert('删除成功!');location.href='../php/User_manage.php';</script>";
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
        	<li><a href="../php/logout_admin.php">安全退出</a></li>
    	</ul>
  		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
                                    <li><a href="../php/Search_borrow_admin_input.php">借书查询</a></li>
					<li><a href="../php/Main_admin.php">图书入库</a></li>
					<li><a href="../php/User_manage.php">用户管理</a></li>
					<li><a href="../php/Select_book.php">图书查询</a></li>
				</ul>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h4 class="sub-header">
					<ul class="nav nav-tabs">
  					<li role="presentation" class="active"><a href="#">删除</a></li>
  					<li role="presentation"><a data-toggle="modal" data-target="#modal_adduser">添加</a></li>
					</ul>
				</h4>
                            <form class="form-horizontal" action="../php/User_manage.php" method="post">
				<div class="form-group">
    				<label for="cardid" class="control-label col-sm-1">卡号</label>
    				<div class="col-sm-5">
    				<input type="number" min="0" class="form-control " id="cardid" name="delete_cno">
    				</div>
    				<button type="submit" class="btn btn-default">删除</button>
 				 </div>
				</form>
			</div>
		</div>
	</div>
	<!-- 模态弹出窗内容 -->
<div class="modal" id="modal_adduser" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="top:20%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">添加用户</h4>
			</div>			
			<div class="modal-body">
			<form id="userlogin" class="form-horizontal" role="form" action="../php/User_manage.php" method="post">
				<div class="form-group">
    					<label for="cardid" class="col-sm-3 control-label">卡号</label>
    					<div class="col-sm-9">
      						<input type="number" min="0" class="form-control" id="cardid" name="cno">
    					</div>
  					</div>
  					<div class="form-group">
    					<label for="name" class="col-sm-3 control-label">姓名</label>
    					<div class="col-sm-9">
      						<input type="text" class="form-control" id="name" name="name">
    					</div>
  					</div>
  					<div class="form-group">
    					<label for="department" class="col-sm-3 control-label">单位</label>
    					<div class="col-sm-9">
      						<input type="text" class="form-control" id="department" name="department">
    					</div>
  					</div>
  					<div class="form-group">
    					<label for="grouptype" class="col-sm-3 control-label">类别</label>
    					<div class="col-sm-9">
      					<select class="form-control" id="booktype" name="ctype">
  							<option>教职工</option>
  							<option>学生</option>
  							<option>其他</option>
						</select>	
    					</div>
  					</div>
  					<button type="submit" class="btn btn-primary col-sm-offset-5">添加</button>
			</form>
			</div>
		</div>
	</div>
</div>
        
</body>
</html>

