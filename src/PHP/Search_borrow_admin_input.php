
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
				<h3 class="page-header">借书查询</h3>
				<div class="table-responsive">
            		<div class=" main">
				<h4 class="sub-header">
					<ul class="nav nav-tabs">
                                            <li role="presentation" class="active"><a href="#">查询</a></li>
					</ul>
				</h4>
				<form class="form-horizontal" method="get" action="../php/Search_borrow_admin.php">
                                    <div class="form-group">
                                    <label for="cardid" class="control-label col-sm-1">卡号</label>
                                    <div class="col-sm-5">
                                    <input type="number" name="param" class="form-control " id="cardid">
                                    </div>
                                    <button type="submit" class="btn btn-default">查询</button>
                                     </div>
				</form>
            	</div>
            </div>
        </div>
    </div>
</body>
</html>
