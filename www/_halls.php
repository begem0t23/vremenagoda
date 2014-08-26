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
	global $userroles;
fixednavbar();

?>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h3>Редактирование Списка Залов</h3>
      </div>
<button  class = "btn btn-primary"  type="button" role="1" name="addhall" id="0" title="Добавить Зал">Добавить Зал</button>
 <?php		

$bgs[0] = 'Нет';
$bgs[1] = 'Да';

 $tsql = "SELECT * FROM `hall` WHERE `isactive` = 1 ORDER BY `id` ASC;";
	$r_serv = mysql_query($tsql);
	if (mysql_num_rows($r_serv)>0)
	{	
				echo '<table id = "halls" class = "tablesorter halls"  style="width: 100%;">';
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
							<th class="sorter-false">Количество персон</th>
							<th class="sorter-false" >Действия</th>
							</tr>
							</thead>';
	?>
<?php
			while ($row_serv = mysql_fetch_array($r_serv))
		{
				echo '<tr>';

							echo '
							<td><span id="hallname'.$row_serv["id"].'">'.$row_serv["name"].'</span></td>
							<td><span id="halldescr'.$row_serv["id"].'">'.$row_serv["description"].'</span></td>
							<td><span id="hallcnt'.$row_serv["id"].'" >'.$row_serv["countofperson"].'</span></td>
							<td><button  class = "btn btn-primary" type="button"  name="changehall" id="'.$row_serv["id"].'" title="Изменить данные"><span class="glyphicon glyphicon-pencil"></span></button>
							<button  class = "btn btn-primary" type="button"  name="deletehall" id="'.$row_serv["id"].'" title="Удалить Зал"><span class="glyphicon glyphicon-trash"></span></button></td>';
												
				echo '</tr>';
					
		}
				echo '</table>';
		
?>
<?php		
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
	
	
		$(document).ready(function(){
			// когда страница загружена

	
			$(".halls")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});


    var id, dialog, form, 
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      hallid = $( "#hallid" ),
      name = $( "#name" ),
      descr = $( "#descr" ),
      cnt = $( "#cnt" ),
      allFields = $( [] ).add( name ).add( descr ).add( cnt ).add( hallid ),
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
 

    function checkVal( o, n, min, max) {
		
      if ( o.val() > max || o.val() < min ) {

        o.addClass( "ui-state-error" );
        updateTips( "Значение " + n + " должно быть между " +
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
 
    function addhall() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
	
		valid = valid && checkLength( name, "Название Зала", 3, 50 );
		//valid = valid && checkLength( descr, "Описание Зала", 10, 100 );
		valid = valid && checkLength( cnt, "Количество Персон", 1, 3 );
		valid = valid && checkVal( cnt, "Количество Персон", 1, 777 );
		operation = "changehall";
	 
  	if (hallid.val() == 0)
	{
		operation = "addhall";
	}

       valid = valid && checkRegexp( cnt, /^([0-9])+$/, "Цена должна состоять только из цифр : 0-9" );


	   if ( valid ) 
	  {

	  
		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: operation, hallname: name.val(), halldescr: descr.val(), hallcnt: cnt.val(), hallid: hallid.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Изменения в список залов внесены.');
				location.href="?halls";
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
        "Сохранить": addhall,
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
	
  });
	</script>
 <div id="dialog-form" title="Заполните информацию по залу.">
  <p class="validateTips">Все поля должны быть заполнены.</p>
  <form>
	<input type="text" id="name" placeholder="Название Зала" class="form-control" value="">
	<input type="text" id="descr" placeholder="Описание Зала" class="form-control" value="">
	<input type="text" id="cnt" placeholder="Количество Персон" class="form-control" value="">
		<input type="hidden" id="hallid"  class="form-control" value="">


 </form>
</div>
 </body>
</html>
