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
	?> :: Меню</title>
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
    div#users-contain { width: 450px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>

</head>
<body>
 

 
 
 <div id="dialog-adddish" title="Добавление блюда в меню">
   <p class="validateTips">Блюда доступные для добавления в этой секции</p>

<table id = "dishes"  class="tablesorter dishestoadd" style="width: 800px;"><colgroup>
						<col width="250">
						<col width="250">
						<col width="50">
						<col width="50">
						<col width="30">
						<col width="30">
						<col width="30">
						</colgroup><thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Вес</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false"></th>
							<th class="sorter-false"></th>
							<th class="sorter-false"></th>
							</tr>
							</thead>
							<tbody><tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr></tbody></table>
							
<p class="validateTips">Блюда занятые в этой секции</p>

<table id = "dishes2"  class="tablesorter dishestoadd" style="width: 800px;"><colgroup>
						<col width="250">
						<col width="250">
						<col width="50">
						<col width="50">
						<col width="50">
						<col width="30">
						<col width="30">
						<col width="30">
						</colgroup><thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Вес</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false">Меню</th>
							<th class="sorter-false"></th>
							<th class="sorter-false"></th>
							<th class="sorter-false"></th>
							</tr>
							</thead>
							<tbody><tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr></tbody></table>						
							<button class="level_1" type="button" name="editdish" id="0" title="Создать блюдо">Создать новое блюдо</button>
</div>
 
 <div id="dialog-editdish" title="Заполните информацию о блюде">
   <p class="validateTips">Все поля должны быть заполнены.</p>

  <form>

	<input type="text" id="name" placeholder="Название" class="form-control" value="">

	

	<input type="text" id="description" placeholder="Описание" class="form-control" value="">

	<input type="text" id="weight" placeholder="Вес в граммах" class="form-control" value="">


	<input type="text" id="price" placeholder="Цена" class="form-control" value="">
	<input type="hidden" id="menu_section"  value="">
	<input type="hidden" id="dish_id"  value="0">


  </form>
</div>
<?php

fixednavbar();


?>

    <!-- Begin page content -->
    <div class="container">
		<div class="page-header">
        <h3>Редактирование Меню</h3>
		</div>
		
		<div id="menutree">


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
	
		
	<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>


	<script>

		function print_menu_tree(cnt){

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'printmenutree'}
		})
		.done(function( msg ) {
			$( "#menutree" ).html(msg);
			
			$('#tabs').smartTab({selected: cnt});
		
			
						$(".menus")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});
				
		});
	
	}
	
	function dish_to_menu (dishid,menuid,sectionid){
	
				$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'dishtomenu', menuid: menuid, dishid: dishid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				alert ('Блюдо добавлено в меню.');
				get_dishes_for_add(menuid,sectionid);
				print_menu_tree(menuid);
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
	}
	
	function dish_from_menu (dishid,menuid,sectionid){
	
				$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'dishfrommenu', menuid: menuid, dishid: dishid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				alert ('Блюдо удалено из меню.');
				get_dishes_for_add(menuid,sectionid);
				print_menu_tree(menuid);
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
	}
	

	
	function get_dishes_for_add(menuid,sectionid){
	
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'getdishesforadd', menuid: menuid, sectionid: sectionid, toadd: 'free'}
		})
		.done(function( msg ) {
			$( "#dishes tbody" ).html(msg);

		});
	
	
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'getdishesforadd', menuid: menuid, sectionid: sectionid, toadd: 'notfree'}
		})
		.done(function( msg ) {
			$( "#dishes2 tbody" ).html(msg);
		});
	
	
	}
	
		$(document).ready(function(){
			// когда страница загружена

	
			$(".menus")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});
			
			$(".dishestoadd")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});


print_menu_tree(1);			
			
$('#tabs').smartTab({selected: 1});		

    var id, dialog, form, 
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
		emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
		name = $( "#name" ),
		description = $( "#description" ),
		weight = $( "#weight" ),
		price = $( "#price" ),
		menu_section = $( "#menu_section" ),
		dish_id = $( "#dish_id" ),
		allFields = $( [] ).add( name ).add( description ).add( price ).add( weight ).add( menu_section ),
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
        updateTips( "Количество сивмолов " + n + " должна быть между " +
          min + " и " + max + "."+o.val().length );
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
 
    function adddish() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "названия", 3, 250 );
      valid = valid && checkLength( description, "описания", 10, 250 );
      valid = valid && checkLength( weight, "веса", 2, 5 );
     valid = valid && checkLength( price, "цена", 1, 10 );
 
      //valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\(\)\s])+$/i, "Недопустимые символы." );
     //valid = valid && checkRegexp( description, /^[a-z]([0-9a-z_\s])+$/i, "Недопустимые символы." );
       valid = valid && checkRegexp( price, /^([0-9.])+$/, "Цена может состоять только из цифр : 0-9 и точки" );
       valid = valid && checkRegexp( weight, /^([0-9])+$/, "Цена должна состоять только из цифр : 0-9" );
 
      if ( valid ) 
	  {

		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'adddish', dishname: name.val(), dishdescription: description.val(), dishweight: weight.val(), dishprice: price.val(), dishid: dish_id.val(), menu_section: menu_section.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Информация о блюде сохранена.');
				get_dishes_for_add(menuid,sectionid);
				print_menu_tree(menuid);
dialog3.dialog( "close" );
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
		
		
		
	}
      return valid;
    }
 
     dialog2 = $( "#dialog-adddish" ).dialog({
      autoOpen: false,
      height: 450,
      width: 850,
      modal: true,
      buttons: {
        "Отмена": function() {
          dialog2.dialog( "close" );
        }
      },
      close: function() {

        allFields.removeClass( "ui-state-error" );
      }
    });
 
      dialog3 = $( "#dialog-editdish" ).dialog({
      autoOpen: false,
      height: 350,
      width: 400,
      modal: true,
      buttons: {
        "Сохранить": adddish,
        "Отмена": function() {
          dialog3.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
		   dialog2.dialog( "open" );
      }
    });
	
 
 
    form = dialog3.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      adddish();
    });
 

	
	$( document ).on( "click", "button[name=dishtomenu]", function() {
				dishid = $(this).attr("id");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");
				dish_to_menu(dishid, menuid, sectionid);
    });

	
	$( document ).on( "click", "button[name=dishfrommenu]", function() {
				dishid = $(this).attr("id");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");
				dish_from_menu(dishid, menuid, sectionid);
    });

	
	$( document ).on( "click", "button[name=adddish]", function() {
				id = $(this).attr("id");					
				menuid = id.substr(7,1);
				sectionid = id.substr(9);
				get_dishes_for_add(menuid,sectionid);
				dialog2.dialog('option', 'title', 'Добавление блюда в меню - '+menuid + ' раздел - ' + sectionid);
				dialog2.dialog( "open" );
    });

	$( document ).on( "click", "button[name=editdish]", function() {
				dishid = $(this).attr("id");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");

				$('#name').val($('#dishname'+dishid).html());
				$('#description').val($('#dishdescr'+dishid).html());
				$('#price').val($('#dishprice'+dishid).html());
				$('#weight').val($('#dishweight'+dishid).html());
				$('#menu_section').val(sectionid);
				$('#dish_id').val(dishid);
	
				dialog2.dialog( "close" );
				dialog3.dialog( "open" );
    });
	
	
  });
	</script>
  </body>
</html>
