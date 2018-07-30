<?php
session_start();
if( !isset($_SESSION["login_admin"])){
 echo "你还没有登陆,无法操作!";
 exit;
}

if(isset($_POST["bno"]) && $_POST["bno"]!=""
        && isset($_POST["category"]) && $_POST["category"]!=""
        && isset($_POST["title"]) && $_POST["title"]!=""
        && isset($_POST["press"]) && $_POST["press"]!=""
        && isset($_POST["year"]) && $_POST["year"]!=""
        && isset($_POST["author"]) && $_POST["author"]!=""
        && isset($_POST["price"]) && $_POST["price"]!=""
        && isset($_POST["number"]) && $_POST["number"]!=""){
    $bno=$_POST["bno"];
    $category=$_POST["category"];
    $title=$_POST["title"];
    $press=$_POST["press"];
    $year=$_POST["year"];
    $author=$_POST["author"];
    $price=$_POST["price"];
    $number=$_POST["number"];
    
    include 'conn.php';
    $query="select * from book"
            . " where bno = $bno";
    $result=mysqli_query($id,$query);
    if(mysqli_num_rows($result)<1){
        $query2="insert into book"
           . " values('$bno','$category','$title','$press','$year','$author','$price','$number','$number')";
        if(mysqli_query($id, $query2)){
            echo "<script language=javascript>alert('入库成功!');location.href='../php/Main_admin.php';</script>";
        }else{
            echo "<script language=javascript>alert('入库失败!请检查图书信息！');location.href='../php/Main_admin.php';</script>";
        }
    }else{
        $info=mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($category==$info['category'] && $title==$info['title']
                && $press==$info['press'] && $year==$info['YEAR']
                && $author==$info['author'] && $price==$info['price']
                && $number>0){
            $query3="update book"
                    . " set total=total+$number,stock=stock+$number"
                    . " where bno='$bno'";
            if(mysqli_query($id, $query3)){
                echo "<script language=javascript>alert('入库成功!');location.href='../php/Main_admin.php';</script>";
            }else{
                echo "<script language=javascript>alert('入库失败!');location.href='../php/Main_admin.php';</script>";
            }
        }else{
            echo "<script language=javascript>alert('入库失败!请检查图书信息!');location.href='../php/Main_admin.php';</script>";
        }
    }
    mysqli_close($id);
}

if(isset($_FILES["file"]) && $_FILES["file"]["size"]!=0){
    $temp= explode(".", $_FILES["file"]["name"]);
    $extension=end($temp);
    $filename=$_FILES["file"]["name"];
    if(($_FILES["file"]["type"]=="text/plain")
            && $extension=="txt"){
        move_uploaded_file($_FILES["file"]["tmp_name"], "../Upload/" . $_FILES["file"]["name"]);
    }else{
        echo "<script language=javascript>alert('文件扩展名必须是.txt!');location.href='../php/Main_admin.php';</script>";
    }
    $file=fopen("../Upload/".$filename,"r");
    include 'conn.php';
    while(!feof($file)){
        $line=fgets($file);
        $encode = mb_detect_encoding($line, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5')); 
        $line = mb_convert_encoding($line, 'UTF-8', $encode);
        $book= explode(",", $line);
        $bno=$book[0];
        $category=$book[1];
        $title=$book[2];
        $press=$book[3];
        $year=$book[4];
        $author=$book[5];
        $price=$book[6];
        $number=$book[7];
        
        $query="select * from book"
            . " where bno = $bno";
        $result=mysqli_query($id,$query);
        if(mysqli_num_rows($result)<1){
            $query2="insert into book"
                . " values('$bno','$category','$title','$press','$year','$author','$price','$number','$number')";
            if(mysqli_query($id, $query2)){
                echo "<script language=javascript>alert('入库成功!');location.href='../php/Main_admin.php';</script>";
            }else{
                echo "<script language=javascript>alert('入库失败!请检查图书信息!');location.href='../php/Main_admin.php';</script>";
            }
        }else{
            $info=mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($category==$info['category'] && $title==$info['title']
                && $press==$info['press'] && $year==$info['YEAR']
                && $author==$info['author'] && $price==$info['price']
                && $number>0){
                $query3="update book"
                    . " set total=total+$number,stock=stock+$number"
                    . " where bno='$bno'";
                if(mysqli_query($id, $query3)){
                    echo "<script language=javascript>alert('入库成功!');location.href='../php/Main_admin.php';</script>";
                }else{
                    echo "<script language=javascript>alert('入库失败!');location.href='../php/Main_admin.php';</script>";
                }
            }else{
                echo "<script language=javascript>alert('入库失败!请检查图书信息!');location.href='../php/Main_admin.php';</script>";
            }
        }
    }
    mysqli_close($id);
    fclose($file);
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
				<h3 class="sub-header">批量入库</h3>
				<form action="../php/Main_admin.php" method="post" enctype="multipart/form-data">
				 <div class="form-group">
                                    <input type="file" id="exampleInputFile" name="file">
                                </div>
    				<button type="submit" class="btn btn-default">上传</button> 				
  				</form>

  				<h3 class="sub-header">单本入库</h3>
  				<form class="form-horizontal" action="../php/Main_admin.php" method="post">
  				 	<div class="form-group">
    					<label for="bookid" class="col-sm-1 control-label">书号</label>
    					<div class="col-sm-5">
      						<input type="text" class="form-control" id="bookid" name="bno">
    					</div>
  					</div>
  					<div class="form-group">
    					<label for="booktype" class="col-sm-1 control-label">类别</label>
    					<div class="col-sm-5">
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
   						<label for="bookname" class="col-sm-1 control-label">书名</label>
    					<div class="col-sm-5">
      						<input type="text" class="form-control" id="bookname" name="title">
    					</div>
  					</div>
  					<div class="form-group" >
   						<label for="bookpublish" class="col-sm-1 control-label">出版社</label>
    					<div class="col-sm-5">
      						<input type="text" class="form-control" id="bookpublish" name="press">
    					</div>
  					</div>
  					<div class="form-group">
   						<label for="bookyear" class="col-sm-1 control-label">年份</label>
    					<div class="col-sm-5">
      						<input type="number" class="form-control" id="bookyear"  name="year" min="0" step="1">
    					</div>
  					</div>
  					<div class="form-group">
   						<label for="bookauthor" class="col-sm-1 control-label">作者</label>
    					<div class="col-sm-5">
      						<input type="text" class="form-control" id="bookauthor" name="author">
    					</div>
  					</div>
  					<div class="form-group">
   						<label for="bookprice" class="col-sm-1 control-label">价格</label>
    					<div class="col-sm-5">
      						<input type="number" min="0" class="form-control" id="bookprice" name="price">
    					</div>
  					</div>
  					<div class="form-group">
   						<label for="booknumber" class="col-sm-1 control-label">数量</label>
    					<div class="col-sm-5">
      						<input type="number" min="1" step="1" class="form-control" id="booknumber" name="number">
    					</div>
  					</div>
  					<button type="submit" class="btn btn-default">执行</button>
  				</form>
			</div>
		</div>
	</div>
</body>
</html>