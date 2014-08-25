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
   <p class="validateTips">Блюда этого раздела доступные для добавления в меню.</p>
							<button class=" btn btn-primary" type="button" name="editdish" id="0" title="Создать блюдо">Создать новое блюдо</button>

<table id = "dishes"  class="tablesorter dishestoadd" style="width: 100%;"><colgroup>
						<col width="450">
						<col width="350">
						<col width="100">
						<col width="100">
						<col width="30">
						<col width="30">
						<col width="30">
						</colgroup><thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Вес</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false" colspan="3">Действия</th>
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
							
<br>							
<p class="validateTips">Блюда этого раздела  добавленные в другие меню</p>

<table id = "dishes2"  class="tablesorter dishestoadd" style="width: 100%;"><colgroup>
						<col width="450">
						<col width="350">
						<col width="100">
						<col width="100">
						<col width="150">
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
							<th class="sorter-false" colspan="3">Действия</th>
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
							<button class="btn  btn-primary" type="button" name="editdish" id="0" title="Создать блюдо">Создать новое блюдо</button>
</div>
 
 <div id="dialog-editdish" title="Заполните информацию о блюде">
 
</div>

 <div id="dialog-editsection" title="Заполните информацию о разделе">
 
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
    <script src="/bootstrap/js/bootstrap-button.js"></script>
	
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

	
	function get_edit_section_form(sectionid)
	{
	
		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'geteditsectionform',sectionid: sectionid}
		})
		.done(function( msg ) {
			$( "#dialog-editsection" ).html(msg);
			});	
	}
	
	
	
	function tree_hide(el,id)
 {
 view = "und";
 if ($("button[name=viewall]").hasClass("active")) view = "";
 if ($("button[name=viewfull]").hasClass("active")) view = ".full";
 if ($("button[name=viewsect]").hasClass("active")) view = ".zero";

 
 			$(".dis_"+id).each(function(i,elem) 
			{
					if($(elem).attr("id"))
					{
						elid = $(elem).attr("id");
						elid = elid.substr(4);
						
						tree_hide($("#tree_" + elid),elid);
					}
					
			});
	if(el) 
		{
			$(el).removeClass("glyphicon-minus");
			$(el).addClass("glyphicon-plus");
		}
			$(".dis_"+id).hide() ;

normal_height()

 }
 
 
 
 	function tree_show(el,id)
 {
 
 view = "und";
 if ($("button[name=viewall]").hasClass("active")) view = "";
 if ($("button[name=viewfull]").hasClass("active")) view = "full";
 if ($("button[name=viewsect]").hasClass("active")) view = "zero";

 			$(".dis_"+id).each(function(i,elem) 
			{
			
					if($(elem).attr("id"))
					{
					
						elid = $(elem).attr("id");
						elid = elid.substr(4);
						//alert(elid);
						tree_show($("#tree_" + elid),elid);
					}
					
			});
			
			if(el) 
			{
 			$(el).removeClass("glyphicon-plus");
			$(el).addClass("glyphicon-minus");
			}
			
			$(".dis_"+id).show();

			
			normal_height()
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
 
 function curmenutitle() 
 {
  $('a').each(function(i,elem) 
  {
	if ($(this).hasClass("sel")) {
		menutitle = $(this).text();
		return false;
		}
	});
	return menutitle;
}
 
 function normal_height()
  {
  
 menuid = curmenu();
			
 newh = $( "#menu_"+menuid ).height() + 30;
$( ".stContainer" ).css("height", newh + "px")

 }
 
 
 
	function delete_section(secid){
	
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'deletesection', sectionid: secid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				alert ('Раздел удалён из системы.');
				print_menu_tree(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
	
	}
	

 function delete_dish(dishid,sectionid){
	
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'deletedish', dishid: dishid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				alert ('Блюдо удалено из системы.');
				get_dishes_for_add(curmenu(),sectionid);
				print_menu_tree(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
	
	}
	
	
	
	function get_edit_dish_form(dishid,menuid,sectionid){
	
		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'geteditdishform',dishid: dishid, menuid: menuid, sectionid: sectionid}
		})
		.done(function( msg ) {
			$( "#dialog-editdish" ).html(msg);
			});	
	}
	
	
	
		function print_menu_tree(cnt){

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'printmenutree'}
		})
		.done(function( msg ) {
			$( "#menutree" ).html(msg);
			$(".menus")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});
			$('#tabs').smartTab({selected: cnt});
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
	
	
			
$('#tabs').smartTab({selected: 0});		

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
		var	name = $( "#name" ),
		description = $( "#description" ),
		weight = $( "#weight" ),
		price = $( "#price" ),
		menu_section = $( "#menu_section" ),
		dish_id = $( "#dish_id" ),
		menu_id = $( "#menu_id" ),
		allFields = $( [] ).add( name ).add( description ).add( price ).add( weight ).add( menu_section ).add( dish_id ).add( menu_id ),
		tips = $( ".validateTips" );


      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "названия", 3, 250 );
      valid = valid && checkLength( description, "описания", 0, 250 );
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
			data: { operation: 'adddish', dishname: name.val(), dishdescription: description.val(), dishweight: weight.val(), dishprice: price.val(), dishid: dish_id.val(), menu_section: menu_section.val(), menuid: menu_id.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Информация о блюде сохранена.');
				menuid1 = curmenu();
				get_dishes_for_add(menuid1,menu_section.val());
				print_menu_tree(menuid1);
				menutitle = curmenutitle();
				sectiontitle = $( "#menu_section option:selected").text().replace('-','');
				dialog2.dialog('option', 'title', 'Добавление блюд в:  "'+menutitle + '" / раздел: "' + sectiontitle + '"');
				dialog3.dialog( "close" );
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
		
		
		
	}
      return valid;
    }
 
 
 
 
 
   function addsection() {

		var	section_id = $( "#section_id" ),
		sectionname = $( "#sectionname" ),
		sectionparent = $( "#sectionparent" ),
		allFields = $( [] ).add( sectionname ).add( sectionparent ).add( section_id),
		tips = $( ".validateTips" );
		
		operation = 'addsection';
		if(section_id.val() > 0) {operation = 'editsection';}
		
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( sectionname, "названия", 3, 250 );
  
      if ( valid ) 
	  {

		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: operation,  sectionname: sectionname.val(), sectionparent: sectionparent.val(), sectionid: section_id.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Информация о разделе сохранена.');
				print_menu_tree(curmenu());
				dialog4.dialog( "close" );
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
		
		
		
	}
      return valid;
    }
 
 
 
 	     dialog4 = $( "#dialog-editsection" ).dialog({
      autoOpen: false,
	  position: [100,100],
      height: '450',
      width: '100%',
      modal: true,
      buttons: {
   "Сохранить": addsection,
        "Отмена": function() {
          dialog4.dialog( "close" );

        }
      },
    });
	
	
	
	
     dialog2 = $( "#dialog-adddish" ).dialog({
      autoOpen: false,
	  position: [100,100],
     height: '450',
      width: '100%',
      modal: true,
      buttons: {
        "Отмена": function() {
          dialog2.dialog( "close" );
        }
      },
      open: function() {
    }
    });
 
      dialog3 = $( "#dialog-editdish" ).dialog({
      autoOpen: false,
	  position: [100,100],
      height: '450',
      width: '100%',
      modal: true,
      buttons: {
        "Сохранить": adddish,
        "Отмена": function() {
          dialog3.dialog( "close" );

        }
      },
      close: function() {
	  dialog2.dialog( "open" );
     },
      open: function() {
  
	  
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
								if (confirm("Вы уверены что ходите убрать блюдо из меню?")) {
					dish_from_menu(dishid, menuid, sectionid);
				} else {
				}
				
    });

	$( document ).on( "click", "button[name=deletedish]", function() {
				dishid = $(this).attr("id");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");
				if (confirm("Вы уверены что ходите удалить блюдо из системы?")) {
					delete_dish(dishid,sectionid);
				} else {
				}

				
    });

	
	$( document ).on( "click", "button[name=adddish]", function() {
				id = $(this).attr("id");					
				menutitle = curmenutitle();					
				menuid = id.substr(7,1);
				sectionid = id.substr(9);
				sectiontitle = $("#sectiontitle_"+sectionid).val();					
				get_dishes_for_add(menuid,sectionid);
				dialog2.dialog('option', 'title', 'Добавление блюд в:  "'+menutitle + '" / раздел: "' + sectiontitle + '"');

				$( ".ui-dialog" ).css("margin-top", "70px");
				dialog2.dialog( "open" );
		
    });
	

	$( document ).on( "click", "button[name=editdish]", function() {
				dishid = $(this).attr("id");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");
				get_edit_dish_form(dishid, menuid, sectionid);
			dialog2.dialog( "close" );
				$( ".ui-dialog" ).css("margin-top", "70px");

				dialog3.dialog( "open" );
    });
	
		$( document ).on( "click", ".tree", function() {
				secid = $(this).attr("id");
				secid =  secid.substr(5);
				menuid = $(this).attr("menuid");
				if ($(this).hasClass("glyphicon-minus"))
				{			
				tree_hide(this,secid)
				} else {
					tree_show(this,secid)
						}					
    });
	
	
	$( document ).on( "click", "button[name=viewfull]", function() {
			
				$(".fullrow").show();
			$(".glyphicon-plus").addClass("glyphicon-minus");
			$(".glyphicon-plus").removeClass("glyphicon-plus");
normal_height()
				});
	
		$( document ).on( "click", "button[name=viewsect]", function() {
			
			$(".glyphicon-minus").addClass("glyphicon-plus");
			$(".glyphicon-minus").removeClass("glyphicon-minus");
			$(".dis_0 span").removeClass("glyphicon-plus");
			$(".dis_0 span").addClass("glyphicon-minus");

				$(".fullrow").hide();
				normal_height()
    });
	


	
	
		$( document ).on( "click", "button[name=addsection]", function() {
				secid = $(this).attr("sectionid");

				get_edit_section_form(secid);
				$( ".ui-dialog" ).css("margin-top", "70px");
				dialog4.dialog( "open" );
		
    });
	
			$( document ).on( "click", "button[name=editsection]", function() {
				secid = $(this).attr("sectionid");
				secid = secid.substr(1);
				get_edit_section_form(secid);
				$( ".ui-dialog" ).css("margin-top", "70px");
				dialog4.dialog( "open" );
		
    });
	
	
	$( document ).on( "click", "button[name=deletesection]", function() {
			secid = $(this).attr("sectionid");
			secid = secid.substr(1);
			alldishes = $(this).attr("alldishes");

			if (alldishes > 0) {
				alert("Этот раздел удалить не возможно, так как к нему привязано " + alldishes + " блюд. \n Перенесите блюда в другие разделы или удалите их из системы.");
			} else {
					if (confirm("Вы уверены что ходите удалить раздел из системы?")) {
						delete_section(secid);
						} else {
								}
					}
    });
	
	
	
  });
  
 
 
	</script>
  </body>
</html>
