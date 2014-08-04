<?php
date_default_timezone_set ("Europe/Moscow");

function table($tname, $tcols, $thead, $tbody, $tsql, $tdate, $tbuts )
{

$curdate = new DateTime("now");
$curdate = $curdate->format('Y-m-d');

$sqldate = ';';
$date_out = '';

if($tdate) {

$date = explode(',',$tdate);

$date1 = date('Y-m-d',strtotime($curdate)-24*3600*$date[1]);
$date2 = date('Y-m-d',strtotime($curdate)+24*3600*$date[2]);

if (strtotime($date1) < strtotime($date2)) {
$fromdate = $date1;
$todate = $date2;
} else {
$fromdate = $date2;
$todate = $date1;
}

$sqldate = " AND ".$date[0]." >= '".$fromdate."' AND ".$date[0]." <= '".$todate."';";
//echo $sqldate ;

$date_out = 'За период с '.$fromdate.' по '.$todate.'.';
}


echo '<h3>'.$tname.'</h3>'.chr(10);
echo '<strong>'.$date_out.'</strong>'.chr(10);



$body = explode(',',$tbody);
$head = explode(',',$thead);
$cols = explode(',',$tcols);
$buts = explode(';',$tbuts);

$empty_out = '<strong>За выбранный период данные не найдены</strong>';



//ширина колонок
$cols_out = '<colgroup>'.chr(10);
foreach ($cols as $key => $val) 
	{
     $cols_out = $cols_out.'<col width="'.$val.'" />'.chr(10);
	}
	
	foreach ($buts as $key => $val)	
		{
		$cols_out = $cols_out.'<col width="50" />'.chr(10);
		}

$cols_out = $cols_out.'</colgroup>'.chr(10);


//заголовки
$head_out ='<thead><tr>'.chr(10);
foreach ($head as $key => $val) 
	{
     $head_out = $head_out.'<th>'.$val.'</th>'.chr(10);
	}
	
	foreach ($buts as $key => $val)	
		{
		$head_out = $head_out.'<th class="filter-false sorter-false"></th>';
		}

$head_out = $head_out.'</tr></thead>'.chr(10);




$rezult = mysql_query($tsql.$sqldate);


if ( mysql_num_rows($rezult) > 0){
	$body_out = '<tbody>'.chr(10);
	
	while ($rows = mysql_fetch_array($rezult))
	{
	//print_r($rows);
	$body_out = $body_out.'<tr>'.chr(10);
					
	foreach ($body as $key => $val) 
		{
		$body_out = $body_out.'<td>'.chr(10);
		$body_out = $body_out.$rows[$val].chr(10);
		$body_out = $body_out.'</td>'.chr(10);
		}
		
		foreach ($buts as $key => $val)	
			{
			$but = explode(',',$val);
			$body_out = $body_out.'<td><button type="button" class="'.$but[0].'" title="'.$but[1].'">'.$but[2].'</button></td>';
			}
			
	$body_out = $body_out.'</tr>'.chr(10);
	}


echo '<table  class="tablesorter">'.chr(10);

echo $cols_out.$head_out.$body_out;

echo '</tbody></table>'.chr(10);

} else {
echo $empty_out;
}

?>
 <br />   
<br />   

<?php

}



function fixedbotbar()
{
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
