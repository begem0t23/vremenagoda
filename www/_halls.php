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
	?> :: Залы</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">

    <link href="/jquery/jquery-ui.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.theme.min.css" rel="stylesheet">
	<link href="/jquery/smarttab/styles/smart_tab_vertical.css" rel="stylesheet" type="text/css">	
	<link href="/css/jquery.contextMenu.css" rel="stylesheet" type="text/css">	
	<link href="/css/tables_in_hall.css" rel="stylesheet" type="text/css">	
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
	color: #000;
  background-color: #FFD141 !important;
  }
    .level_1{
	color: #000;
  background-color: #FFF368 !important;
  }
    .level_2{
	color: #000;
  background-color: #FFFFC0 !important;
  }
  
  .tocalcrow{
     background-color: #DDFFC0 !important;
  }
  
 tr.odd  td.tocalcrow{
     background-color:  #FFD141 !important;
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
	global $userroles;
fixednavbar();

?>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h3>Редактирование Залов</h3>
      </div>
	  
	    <div id="halls" style="min-width: 700px; width: 100%;">
    <ul>
	
	<?php
	
	 $tsql = "SELECT * FROM `hall` WHERE `isactive` = 1 ORDER BY `id` ASC;";
	$rez_hall = mysql_query($tsql);
	if (mysql_num_rows($rez_hall)>0)
	{	
			while ($row_hall = mysql_fetch_array($rez_hall))
		{
			echo '<li><a href="#hall-'.$row_hall['id'].'">'.$row_hall['name'].'</a></li>'.chr(10);;
		}
	}
	
	//echo '<li><a href="#hall-0">+</a></li>';
	
	?>

	</ul>


 <?php		

$bgs[0] = 'Нет';
$bgs[1] = 'Да';

 $tsql = "SELECT * FROM `hall` WHERE `isactive` = 1 ORDER BY `id` ASC;";
	$rez_hall = mysql_query($tsql);
	if (mysql_num_rows($rez_hall)>0)
	{	
			while ($row_hall = mysql_fetch_array($rez_hall))
		{
			echo '<div id="hall-'.$row_hall['id'].'" >';

			echo '<div id="hallcontent-'.$row_hall['id'].'" class="hallcontent"></div>';
			echo '</div>';
					
		}
	
						//echo '<div id="hall-0" >';
						//echo ' <div id="dialog-form" title="Заполните информацию по залу.">
  //<p class="validateTips">Для создания нового зала заполните форму.</p>
  //<form>
//	<input type="text" id="hallname" placeholder="Название Зала" class="form-control" value="">
//	<input type="text" id="halldescr" placeholder="Описание Зала" class="form-control" value="">
//	<input type="text" id="hallcnt" placeholder="Количество Персон" class="form-control" value="">
//	<br>
//	<button class="btn btn-default" onclick="addhall();">Создать</button>
//	<button class="btn btn-default right" onclick="form[ 0 ].reset(); " >Очистить</button>
// </form>
//</div>';

					//echo '</div>';
	}
?>		  

    </div>
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
	<script src="/jquery/tables_in_hall.js"></script>
	<script src="/jquery/jquery.ui.position.js"></script>
	<script src="/jquery/jquery.contextMenu.js"></script>
		
	<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>


	<script>

	
	function delete_hall(hallid){
	
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'deletehall', hallid: hallid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				alert ('Зал удалён из системы.');
				location.href="?halls";
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
	
	}
	

				
	 function curmenu() 
 {
  $('a').each(function(i,elem) 
  {
	if ($(this).hasClass("sel")) {
		menuid = $(this).attr("href");
		menuid = menuid.substr(6);
		return false;
		}
	});
	return menuid;
}		
			
			
			
		$(document).ready(function(){
			// когда страница загружена
			
				
	$('#halls').smartTab({
	selected: 0,
	autoHeight:false,
	onShowTab:function(){
	get_hall(curmenu());

	}
	
	});		


	
	
			
			var $startEl = $(".start"),
$dragEl = $(".drag"),
$stopEl = $(".stop");
var counts = [0, 0, 0];

//Делаем элемент с id = draggable перетаскиваемым и устанавливаем обработчики
$(".draggable").draggable({
  start: function(){
    counts[0]++;
    $("span.count", $startEl).text(counts[0]);
  },
  drag: function(){
    counts[1]++;
    $("span.count", $dragEl).text(counts[1]);
  },
  stop: function(){
  alert($(this).draggable('option', 'cursorAt'));
    counts[2]++;
    $("span.count", $stopEl).text(counts[2]);
  }
});
			
			
	
	
	
			$(".halls")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});


    var id, dialog, form, 
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name = $( "#name" ),
      descr = $( "#descr" ),
      cnt = $( "#cnt" ),
      allFields = $( [] ).add( name ).add( descr ).add( cnt ),
      tips = $( ".validateTips" );
 
 
 
    form = $( "#dialog-form" ).find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
    });

    $( document ).on( "click", "button[name=changehall]", function() {
		id = $(this).attr("id");
				
		$('#name').val($('#hallname'+id).html());
		$('#descr').val($('#halldescr'+id).html());
		$('#cnt').val($('#hallcnt'+id).html());
		$('#hallid').val(id);
		dialog.dialog( "open" );
    });
	

	
		  $( document ).on( "click", "button[name=addhall]", function() {
		id = $(this).attr("id");
				
		dialog.dialog( "open" );
    });
	
	
	$( document ).on( "click", "button[name=deletehall]", function() {
		id = $(this).attr("id");
				
				if (confirm("Вы уверены что ходите удалить зал " + $('#hallname'+id).html() + "?")) {
					delete_hall(id);
				} else {
				}

    });
	
	
	

		$( document ).on( "click", ".tabnum", function() {
		tabid = $(this).parent().attr("tabid");
		tabnum = $(this).html();
	
		newtabnum = prompt('Новое значение',tabnum)
		if(newtabnum) change_tabnum(tabid, newtabnum);
		});
	
	
  });
  

    function addhall() {
		name = $('#hallname').val();
		descr = $('#halldescr').val();
		cnt = $('#hallcnt').val();
	
		if (name != '' & descr != '' & cnt != '') {

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addhall', hallname: name, halldescr: descr, hallcnt: cnt}
			})
			.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Добавлен новый зал. Отредактируте расположение посадочных мест');
				location.href="?halls";
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
		
		} else { alert('Заполните все поля');}	
		
	}

 

	</script>

 </body>
</html>
