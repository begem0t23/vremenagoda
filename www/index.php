<?php

require_once("config.php");
require_once("functions.php");
if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());

//die($_POST["dosend"]);
if (@$_POST["dosend"])
{
	//die(($_POST["email"]) ."=". (@$_POST["pass"]));
	if ((@$_POST["email"]) && (@$_POST["pass"]))
	{
		$tsql = "select * from users where login='".mysql_escape_string($_POST["email"])."' and pass=MD5('".$_POST["pass"]."');";
		//die($tsql);
		$r_user = mysql_query($tsql);
		if (mysql_num_rows($r_user)>0)
		{	
			//
			if (@$_POST["remember"])
			{
				setcookie ("curuser", md5($_POST["email"] . md5($_POST["pass"])));
			}
			$row_user = mysql_fetch_array($r_user);
			session_start ();
			$_SESSION["curusersession"] = md5($_POST["email"] . md5($_POST["pass"]) . $_SERVER['REMOTE_ADDR']);
			$_SESSION["curuser"] = md5($_POST["email"] . md5($_POST["pass"]));
			$_SESSION["curusername"] = $row_user["realname"];
		}
	}
}

if (checklogin())
{

?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php
	echo PRODUCTNAME;
	?></title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Sticky footer with fixed navbar</h1>
      </div>
<?php
echo $_SESSION["curusername"];
?>
    </div>

    <div class="footer">
      <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
<?php
}
else
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php
	echo PRODUCTNAME;
	?> :: Login</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <form method='POST' class="form-signin" role="form">
		<input type='hidden' value=1 name=dosend>
        <h2 class="form-signin-heading">������� ��� email � ������ �� �������</h2>
        <input name = 'email' type="email" class="form-control" placeholder="Email address" required autofocus>
        <input name = 'pass' type="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input name='remember' type="checkbox" value="remember-me"> ��������� ����
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">�����</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
<?php
}
?>

