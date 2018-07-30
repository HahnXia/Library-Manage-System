<?php
session_start();
if( !isset($_SESSION["login_stu"])
   && !isset($_SESSION["login_admin"])){
 echo "你还没有登陆,无法操作!";
 exit;
}
$datanum="";
if(isset($_POST["category"]) && $_POST["category"]!=""){
    $category=$_POST["category"];
    include 'conn.php';
    $query="select * from book"
            . " where category='$category'";
    if(isset($_POST["title"]) && $_POST["title"]!=""){
        $title=$_POST["title"];
        $query.=" and title like '%$title%'";
    }
    if(isset($_POST["press"]) && $_POST["press"]!=""){
        $press=$_POST["press"];
        $query.=" and press like '%$press%'";
    }
    if(isset($_POST["author"]) && $_POST["author"]!=""){
        $author=$_POST["author"];
        $query.=" and author like '%$author%'";
    }
    if(isset($_POST["startyear"]) && $_POST["startyear"]!=""
            && isset($_POST["endyear"]) && $_POST["endyear"]!=""){
        $startyear=$_POST["startyear"];
        $endyear=$_POST["endyear"];
        $query.=" and YEAR>=$startyear"
                . " and YEAR<=$endyear";
    }
    if(isset($_POST["minprice"]) && $_POST["minprice"]!=""
            && isset($_POST["maxprice"]) && $_POST["maxprice"]!=""){
        $minprice=$_POST["minprice"];
        $maxprice=$_POST["maxprice"];
        $query.=" and price>=$minprice"
                . " and price<=$maxprice";
    }
    $result=mysqli_query($id,$query);
    if(mysqli_num_rows($result)<1){
        echo "<script language=javascript>alert('没有查询到符合条件的图书!');location.href='../php/Select_book_com.php';</script>";
    }else{
        $datanum=mysqli_num_rows($result);
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
        <form class="form-horizontal" action="../php/Select_book_com.php" method="post"> 
          <div class="form-group">
            <label for="booktype" class="col-sm-2 control-label">类别</label>
              <div class="col-sm-8">
                <select class="form-control" id="booktype" name="category">
                  <option>文学</option>
                  <option>教辅</option>
                  <option>艺术</option>
                  <option>生活</option>
                  <option>科学</option>
                </select>
              </div>
          </div>
          <div class="form-group">
            <label for="bookname" class="col-sm-2 control-label">书名</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="bookname" name="title">
              </div>
          </div>
          <div class="form-group">
            <label for="bookpublish" class="col-sm-2 control-label">出版社</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="bookpublish" name ='press'>
              </div>       
          </div>
          <div class="form-group">
            <label for="bookauthor" class="col-sm-2 control-label">作者</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="bookauthor" name="author">
              </div>       
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">年份区间</label>
            <div class="col-sm-3">
             <input type="number" class="form-control" id="yearrange1" placeholder="起始年份" name="startyear">
            </div>
            <div class="col-sm-1">-</div>
            <div class="col-sm-3">
            <input type="number" class="form-control" id="yearrange2" placeholder="截至年份" name="endyear">
            </div>    
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">价格区间</label>
            <div class="col-sm-3">
             <input type="number" class="form-control" id="pricerange1" placeholder="最低价" name="minprice">
            </div>
            <div class="col-sm-1">-</div>
            <div class="col-sm-3">
            <input type="number" class="form-control" id="pricerange2" placeholder="最高价" name="maxprice">
            </div>    
          </div>
          <button type="submit" class="btn btn-primary col-sm-offset-4 col-sm-3">查询</button>
        </form>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
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
</div>
</body>
</html>