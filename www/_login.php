<?
//var_dump($_SESSION);
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
	?> :: Login</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">
<?php 
var_dump($_SESSION);
var_dump(@$_COOKIES);
?>
      <form action="/" method='POST' class="form-signin" role="form">
		<input type='hidden' value="<?php echo rand();?>" name=dosend>
        <h2 class="form-signin-heading">Введите ваш email и пароль от портала</h2>
        <input name = 'email' type="email" class="form-control" placeholder="Email address" required autofocus>
        <input name = 'pass' type="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input name='remember' type="checkbox" value="remember-me"> Запомнить меня
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
