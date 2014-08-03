<?php

function fixedbotbar()
{
	global $userroles;
?>
    <div class="footer">
      <div class="container">
        <p class="text-muted">
<?php
if (@$userroles[$_SESSION["curuserrole"]])
{
	echo "Роль: ";
	echo $userroles[$_SESSION["curuserrole"]];
}
?>		
		</p>
      </div>
    </div>
<?php
}

function fixednavbar()
{
	global $userroles,$qq;
?>
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <a class="navbar-brand" href="#">Времена года</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php
			if ($qq=="") echo 'class="active"';
			?>><a href="/">Заказы</a></li>
            <li <?php
			if ($qq=="create") echo 'class="active"';
			?>><a href="?create">Создать заказ</a></li>
            <li <?php
			if ($qq=="profile") echo 'class="active"';
			?>><a href="?profile">Мои настройки</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Отчеты<span class="caret"></span></a>
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
            <li><a href="?logout">Выйти (<?php
echo $_SESSION["curusername"];
?>)</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
<?php
}

function checklogin()
{
	$curusermd5 		= "";
	$curusersessionmd5 	= "";
	
	if (@$_COOKIE["curuser"]) 
	{
		$curusermd5 = $_COOKIE["curuser"];
		return true;
	}
	else
	{
		if (@$_SESSION["curuser"])
		{
			$curusermd5 		= $_SESSION["curuser"];
			$curusersessionmd5 	= $_SESSION["curusersession"];
			$tsql = "select * from users where MD5(concat(login,pass,'" . $_SERVER['REMOTE_ADDR'] . "'))='" . $curusersessionmd5 . "';";
			$r_notasigned = mysql_query($tsql);
			if (mysql_num_rows($r_notasigned)>0)
			{	
				return true;
			}			
			else
			{
				return false;			
			}
		}
		else
		{
			return false;
		}	
	}
}

// Alexey Bogachev aabogachev@gmail.com +74955084448
?>