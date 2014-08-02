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
<?php

fixednavbar();

?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
<?php
//var_dump($_SESSION);
//var_dump(@$_COOKIES);
?>
        <h2>Новые заказы</h2>
      </div>
    </div>

<?php
fixedbotbar()
?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
