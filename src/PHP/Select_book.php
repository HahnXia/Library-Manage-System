<?php
session_start();
if( !isset($_SESSION["login_stu"])
   && !isset($_SESSION["login_admin"])){
 echo "你还没有登陆,无法操作!";
 exit;
}
$datanum="";
if(isset($_POST["select"]) && $_POST["select"]!=""
        && isset($_POST["content"]) && $_POST["content"]!=""){
    $select=$_POST["select"];
    $content=$_POST["content"];
    include 'conn.php';
    if($select=='类别'){
        $query="select * from book"
                . " where category = '$content'";
        $result=mysqli_query($id,$query);
        if(mysqli_num_rows($result)<1){
            echo "<script language=javascript>alert('没有查询到符合条件的图书!');location.href='../php/Select_book.php';</script>";
        }else{
            $datanum=mysqli_num_rows($result);  
        }
    }elseif ($select=='书名'){
        $query="select * from book"
                . " where title like '%$content%'";
        $result=mysqli_query($id,$query);
        if(mysqli_num_rows($result)<1){
            echo "<script language=javascript>alert('没有查询到符合条件的图书!');location.href='../php/Select_book.php';</script>";
        }else{
            $datanum=mysqli_num_rows($result);  
        }
    }elseif($select=='出版社'){
        $query="select * from book"
                . " where press like '%$content%'";
        $result=mysqli_query($id,$query);
        if(mysqli_num_rows($result)<1){
            echo "<script language=javascript>alert('没有查询到符合条件的图书!');location.href='../php/Select_book.php';</script>";
        }else{
            $datanum=mysqli_num_rows($result);  
        }
    }elseif($select=='作者'){
        $query="select * from book"
                . " where author like '%$content%'";
        $result=mysqli_query($id,$query);
        if(mysqli_num_rows($result)<1){
            echo "<script language=javascript>alert('没有查询到符合条件的图书!');location.href='../php/Select_book.php';</script>";
        }else{
            $datanum=mysqli_num_rows($result);  
        }
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
                <li><a href=
                       <?php
                       if(isset($_SESSION["login_stu"])){
                           echo "../php/Main_stu.php";
                       }elseif(isset($_SESSION["login_admin"])){
                           echo "../php/Main_admin.php";
                       }
                       ?>
                       >返回</a></li>
        	<li><a href=
                       <?php
                       if(isset($_SESSION["login_stu"])){
                           echo "../php/Logout_stu.php";
                       }elseif(isset($_SESSION["login_admin"])){
                           echo "../php/Logout_admin.php";
                       }
                       ?>
                       >安全退出</a></li>
    	</ul>
  		</div>
	</nav>
	<div >
	<div class="container">
	  <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li><a href="../php/Select_book.php">简单查询</a></li>
            <li><a href="../php/Select_book_com.php">多字段查询</a></li>
        </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <form class="form-horizontal" action="../php/Select_book.php" method="post">  
            <div class="form-group">
            <div class="col-xs-2">
            <select class="form-control" id="selecttype" name="select">
              <option>类别</option>
              <option>书名</option>
              <option>出版社</option>
              <option>作者</option>
            </select>
            </div>
            <div class="col-xs-7">
            <input type="text" class="form-control" id="selectcontent" placeholder="请选择查询类别" name="content">
            </div>
            <button type="submit" class="btn btn-default col-md-2">查找</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped">
              <tr>
                <th>书号</th>
                <th>类别</th>
                <th>书名</th>
                <th>出版社</th>
                <th>年份</th>
                <th>作者</th>
                <th>价格</th>
                <th>总藏书量</th>
                <th>库存</th>
              </tr>
              <?php                   
              include 'conn.php';
                        for($i=1;$i<=$datanum&&$i<=50;$i++){
                            echo "<tr>";
                            $info=mysqli_fetch_array($result,MYSQLI_ASSOC);
                            echo "<th>".$info['bno']."</th>";
                            echo "<th>".$info['category']."</th>";
                            echo "<th>".$info['title']."</th>";
                            echo "<th>".$info['press']."</th>";
                            echo "<th>".$info['YEAR']."</th>";
                            echo "<th>".$info['author']."</th>";
                            echo "<th>".$info['price']."</th>";
                            echo "<th>".$info['total']."</th>";
                            echo "<th>".$info['stock']."</th>";
                            echo "</tr>";
                           }
                             mysqli_close($id);
                ?>
            </table>
          </div>
    </div>
	</div>
</body>
</html>