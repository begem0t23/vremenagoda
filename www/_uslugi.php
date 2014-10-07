<?
if ($_SESSION["curuserrole"]<6) die("У вас нет прав на доступ к этому разделу");
?>
<<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php
	echo PRODUCTNAME;
	?> :: Услуги</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">

    <link href="/jquery/jquery-ui.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.theme.min.css" rel="stylesheet">
	<link href="/jquery/smarttab/styles/smart_tab_vertical.css" rel="stylesheet" type="text/css">	
	<link rel="stylesheet" href="/jasny-bootstrap/css/jasny-bootstrap.min.css">	

<style>
.rouble {
  position: relative; }

.rouble:before {
  display: block;
  content: "–";
  position: absolute;
  top: 0.15em; }
  
  .level_0{
  background-color: #A7FDBE !important;
  }
    .level_1{
  background-color: #FFB8BE !important;
  }
    .level_2{
  background-color: #F5F5A3 !important;
  }
</style>  


  <style>
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>

</head>
<body>
  
<?php

fixednavbar();

?>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h3>Редактирование услуг</h3>
      </div>
<button  class = "btn btn-primary" tocalc="0" type="button" name="changeserv" id="changeserv0" title="Добавить услугу">Добавить услугу</button>
 <?php		

$bgs[0] = 'Нет';
$bgs[1] = 'Да';

 $tsql = "SELECT * FROM `services` WHERE `tocalculate` = '0' AND `isactive` = '1' ORDER BY `orderby` ASC;";
	$r_serv = mysql_query($tsql);
	if (mysql_num_rows($r_serv)>0)
	{	
				echo '<table id = "uslugi" class = "tablesorter uslugi"  style="width: 100%;">';
				echo 	'<colgroup>
						<col width="35%" />
						<col width="35%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						</colgroup>';

				echo  '<thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false">От кол-ва гостей</th>
							<th class="sorter-false">Действия</th>
							</tr>
							</thead>';

			while ($row_serv = mysql_fetch_array($r_serv))
		{
				echo '<tr>';

							echo '
							<td><span id="servname'.$row_serv["id"].'">'.$row_serv["name"].'</span></td>
							<td><span id="servdescr'.$row_serv["id"].'">'.$row_serv["description"].'</span></td>
							<td><span id="servprice'.$row_serv["id"].'">'.$row_serv["price"].'</span></td>
							<td><span id="byguestcount'.$row_serv["id"].'">'.$bgs[$row_serv["byguestcount"]].'</span></td>
							<td><button class = "btn btn-primary" type="button" tocalc="0" name="changeserv" id="changeserv'.$row_serv["id"].'" title="Изменить услугу"><span class="glyphicon glyphicon-pencil"></span></button>
							<button class = "btn btn-primary" type="button" name="deleteserv" id="deleteserv'.$row_serv["id"].'" title="Удалить услугу"><span class="glyphicon glyphicon-trash"></span></button></td>';
												
				echo '</tr>';
					
		}
				echo '</table>';
	}		
		
      echo '<br><h4>Системные скидки и наценки</h4>';
	  
		$tsql = "SELECT * FROM `services` WHERE `tocalculate` = '1' AND `isactive` = '1' ORDER BY `orderby` ASC;";
	$r_serv = mysql_query($tsql);
	if (mysql_num_rows($r_serv)>0)
	{	
				echo '<table id = "uslugi" class = "tablesorter uslugi"  style="width: 100%;">';
				echo 	'<colgroup>
						<col width="35%" />
						<col width="35%" />
						<col width="10%" />
						<col width="10%" />
						</colgroup>';

				echo  '<thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false">Действия</th>
							</tr>
							</thead>';
	?>
<?php
			while ($row_serv = mysql_fetch_array($r_serv))
		{
				echo '<tr>';

							echo '
							<td><span id="servname'.$row_serv["id"].'">'.$row_serv["name"].'</span></td>
							<td><span id="servdescr'.$row_serv["id"].'">'.$row_serv["description"].'</span></td>
							<td><span id="servprice'.$row_serv["id"].'">'.$row_serv["price"].'</span></td>
							<td><button class = "btn btn-primary" type="button" tocalc="1" name="changeserv" id="changeserv'.$row_serv["id"].'" title="Изменить услугу"><span class="glyphicon glyphicon-pencil"></span></button></td>';
												
				echo '</tr>';
					
		}
				echo '</table>';


	}
?>		  

    </div>

<?php

//fixedbotbar();

?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/jquery/jquery.min.js"></script>
	<script src="/jquery/jquery.ui.datepicker-ru.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/jquery/validator.js"></script>
	<script src="/jquery/jquery.cookie.js"></script>
	<script src="/jquery/smarttab/js/jquery.smartTab.min.js"></script>
	<script src="/jquery/jquery.json-2.4.js"></script>
	
		
	<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>


	<script>
	function delete_serv(servid){
	
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'deleteservice', servid: servid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				alert ('Услуга удалена из системы.');
				location.href="?uslugi";
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
	
	}
	
	
	
		$(document).ready(function(){
			// когда страница загружена

	
			$(".uslugi")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});


    var id, dialog, form, 
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name = $( "#name" ),
     byguestcount = $( "#byguestcount" ),
      description = $( "#description" ),
      price = $( "#price" ),
      to_calc = $( "#tocalc" ),
      allFields = $( [] ).add( name ).add( to_calc ).add( description ).add( price ).add( byguestcount ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Длина " + n + " должна быть между " +
          min + " и " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "username", 3, 100 );
      //valid = valid && checkLength( description, "description", 10, 200 );
      valid = valid && checkLength( price, "price", 1, 10 );
 
      //valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\(\)\s])+$/i, "Недопустимые символы." );
     //valid = valid && checkRegexp( description, /^[a-z]([0-9a-z_\s])+$/i, "Недопустимые символы." );
       valid = valid && checkRegexp( price, /^([0-9.])+$/, "Цена должна состоять только из цифр : 0-9" );
 
      if ( valid ) 
	  {

		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addservice', servname: name.val(), servdescription: description.val(), servprice: price.val(), servid: id, byguestcount: byguestcount.prop('checked'), tocalc: to_calc.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Изменения в список услуг внесены.');
				location.href="?uslugi";
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
		
		
		
	}
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 350,
      width: 400,
      modal: true,
      buttons: {
        "Сохранить": addUser,
        "Отмена": function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( document ).on( "click", "button[name=changeserv]", function() {
					id = $(this).attr("id");
					tocalc = $(this).attr("tocalc");
				id = id.substr(10);
				bgs = $('#byguestcount'+id).html();
				if (bgs == 'Да') 
					{
					$('#byguestcount').prop('checked','true');
					}
					
				if (tocalc == 1) 	{
				$('#name').attr("readonly","readonly");
				$('#bgs').hide();
				}
				if (tocalc == 0) 	{
				$('#name').removeAttr("readonly");
				$('#bgs').show();
				}
				
				$('#name').val($('#servname'+id).html());
				$('#description').val($('#servdescr'+id).html());
				$('#price').val($('#servprice'+id).html());
				$('#price').val($('#servprice'+id).html());
				$('#tocalc').val(tocalc);
				
      dialog.dialog( "open" );
    });
	
	
	    $( document ).on( "click", "button[name=deleteserv]", function() {
					id = $(this).attr("id");
				id = id.substr(10);
				bgs = $('#byguestcount'+id).html();
				sn = $('#servname'+id).html();				
			if (confirm("Вы уверены что хотите удалить услугу " + $('#servname'+id).html() + "?")) {
					delete_serv(id);
				} else {
				}

    });
	
	
  });
	</script>
 <div id="dialog-form" title="Заполните информацию по услуге">
  <p class="validateTips">Поля название и цена должны быть заполнены.</p>
  <form>
	<input type="text" id="name" placeholder="Название" class="form-control" value="">
	<input type="text" id="description" placeholder="Описание" class="form-control" value="">
	<input type="text" id="price" placeholder="Цена" class="form-control" value="">
	<div class="checkbox" id="bgs"> <label> <input id="byguestcount" type="checkbox" value="yes">Расчитывать цену по количству гостей.</label></div>
 	<input type="hidden" id="tocalc"  class="form-control" value="">
 </form>
</div>
 </body>
</html>
