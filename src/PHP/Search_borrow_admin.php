<?php
session_start();
if( !isset($_SESSION["login_admin"])){
 echo "你还没有登陆,无法操作!";
 exit;
}
if(isset($_GET["param"]) && $_GET["param"]!=""){
    $cno=$_GET["param"];
    include 'conn.php';
    $query="select distinct * from book where exists (select bno from borrow where borrow.bno = book.bno and cno = $cno);";
    $result=mysqli_query($id,$query);
    $datanum=mysqli_num_rows($result);  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>阡陌图书管理系统</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bootstrap/css/dashboard.css">

	<script src="../bootstrap/js/jquery-3.2.0.min.js"></script>

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
				<h3 class="page-header">已借书目</h3>
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
                       
                        for($i=1;$i<=$datanum;$i++){
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
