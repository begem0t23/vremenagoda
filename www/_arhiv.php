<?
global $accesdenied;
if ($_SESSION["curuserrole"]!=9) die($accesdenied);
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
	?> :: Архив Блюда и Напитки</title>
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
.left{
float:left;
}

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
  
  table {
}
caption, th, td {
text-align:left;
font-weight:normal;
}
blockquote:before, blockquote:after,
q:before, q:after {
content:"";
}
blockquote, q {
quotes:"" "";
}




.simple-little-table {
width:700px;
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	_text-shadow: 1px 1px 0px #fff;
	background:#fff;
	_margin:15px;
	border:#ccc 1px solid;
	border-collapse:separate;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	_box-shadow: 0 1px 2px #d1d1d1;
	border-collapse:collapse;
border-spacing:0;

}

.simple-little-table th {
	font-weight:bold;
	_padding:10px 13px 11px 13px;
	_border-top:1px solid #2E2E2E;
	_border-bottom:1px solid #2E2E2E;

	background: #99bfe6;
	_background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	_background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
.simple-little-table th:first-child{
	text-align: left;
	padding-left:20px;
}
.simple-little-table tr:first-child th:first-child{
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
.simple-little-table tr:first-child th:last-child{
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
.simple-little-table tr{
	text-align: center;
	padding-left:20px;
}
.simple-little-table tr td:first-child{
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
.simple-little-table tr td {
	 padding:4px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	
	_background: #fFFFFF;
	_background: -webkit-gradient(linear, left top, left bottom, from(#FFFFFF), to(#FFFFFF));
	_background: -moz-linear-gradient(top,  #FFFFFF,  #FFFFFF);
}

.simple-little-table tr:nth-child(even) td{
	_background: #ebf2fa;                                                                                                                
	_background: -webkit-gradient(linear, left top, left bottom, from(#ebf2fa), to(#ebf2fa));
	_background: -moz-linear-gradient(top,  #ebf2fa,  #ebf2fa);
}
.simple-little-table tr:last-child td{
	border-bottom:0;
}
.simple-little-table tr:last-child td:first-child{
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
.simple-little-table tr:last-child td:last-child{
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
.simple-little-table tr:hover td{
	background: #f2f2f2;
	_background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	_background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}

.simple-little-table a:link {
	color: #666;
	font-weight: bold;
	text-decoration:none;
}
.simple-little-table a:visited {
	color: #999999;
	font-weight:bold;
	text-decoration:none;
}
.simple-little-table a:active,
.simple-little-table a:hover {
	color: #bd5a35;
	text-decoration:underline;
}

 
	
  .level_0{
  _padding:5px;
  background-color: #FFD141 !important;
  }
    .level_1{
	_padding:4px;
  background-color: #FFF368 !important;
  }
    .level_2{
	_padding:3px;
  background-color: #FFFFC0 !important;
  }
  
  	.report_columns_head{
	font-size:12px;
	 padding:10px;
	color: #000;
  background-color: #c1d2e4 !important;
   	border-left: 1px solid #e0e0e0;

  }
  
	.report_section{
	font-size:14px;
	 padding:10px;
	color: #fff;
  background-color: #66a6e7 !important;
  }

	.summary_section{
	font-size:14px;
	 padding:10px;
	color: #fff;
  background-color: #6bcf5d !important;
 
  }
 	.lite_summary_section{
	font-size:12px;
	 padding:1px;
	color: #fff;
  background-color: #6bcf5d !important;
 
  }
   
    ._second_row {
   	background-color: #ebf2fa;                                                                                                                
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
 
<table id = "dishes"  class="tablesorter dishestoadd" style="width: 100%;"><colgroup>
						<col width="45%">
						<col width="35%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
					
						</colgroup><thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Вес</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Действия&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							</tr>
							</thead>
							<tbody><tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
			
							</tr></tbody></table>
							
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
        <h3>Архив Блюд и Напитков</h3>
		</div>
				<div id="types" class="left">		
		<select id="arhivtype" onchange="changetype();">
		<option value="0" all="0">Удаленные</option>
		<option value="" all="0" disabled>---просмотр истории---</option>
		<option value="1" all="1">Удаление в архив</option>
		<option value="2" all="1">Восстановление из архива</option>
		<option value="3" all="1">Возврат в меню</option>
		<option value="4" all="1">Создание нового</option>
		<option value="5" all="1">Изменение цены</option>
		<option value="55" all="1">Изменение Спец цены</option>
		<option value="6" all="1">Изменение веса</option>
		<option value="7" all="1">Изменение названия</option>
		<option value="8" all="1">Изменение описания</option>
		<option value="9" all="1">Изменение типа меню</option>
		<option value="10" all="1">Изменение раздела</option>
		<option value="99" all="1">Любые изменения</option>
		
		</select>

		</div>
		
		<div id="periods" class="left">		</div>
	  
		<div id="menutree">		</div>
	
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
	<script src="/jquery/jquery.session.js"></script>	
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
	
	var curyear = '2014';
	function viewtree(key) {
	if(key == 1) 
	{
			$.session.set("viewtree", '1');
			$(".fullrow").show();
			$(".glyphicon-plus").addClass("glyphicon-minus");
			$(".glyphicon-plus").removeClass("glyphicon-plus");
			normal_height()
	}
	
	if(key == 0) 
	{
			$.session.set("viewtree", '0');
			$(".glyphicon-minus").addClass("glyphicon-plus");
			$(".glyphicon-minus").removeClass("glyphicon-minus");
			$(".dis_0 span").removeClass("glyphicon-plus");
			$(".dis_0 span").addClass("glyphicon-minus");

			$(".fullrow").hide();
			normal_height()
    }
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
 
 
	
		function print_periods(type){
		
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'printperiodsforarhiv', type: type}
		})
		.done(function( msg ) {
			$( "#periods" ).html(msg);
			});
	}
	
		
		function print_menu_tree(period,value,type,year){
		
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'printarhivtree', period: period, value: value, type: type,year: year}
		})
		.done(function( msg ) {
			$( "#menutree" ).html(msg);
			$(".menus").tablesorter({
				theme: 'blue',
				widgets: ['zebra']
			});

			});
	
	}
	
	
	
	function dish_to_menu (dishid,menuid,sectionid){
	
		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'dishtomenu', menuid: menuid, dishid: dishid,sectionid:sectionid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
					changeperiod('2014');
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
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


	changetype();	
	
	
			
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
		isbasic = $( "#isbasic" ),
		menu_section = $( "#menu_section" ),
		dish_id = $( "#dish_id" ),
		menu_id = $( "#menu_id" ),
		allFields = $( [] ).add( name ).add( isbasic ).add( description ).add( price ).add( weight ).add( menu_section ).add( dish_id ).add( menu_id ),
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
			data: { operation: 'adddish', dishname: name.val(),isbasic: isbasic.val(), dishdescription: description.val(), dishweight: weight.val(), dishprice: price.val(), dishid: dish_id.val(), menu_section: menu_section.val(), menuid: menu_id.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				//alert ('Информация о блюде сохранена.');
				menuid1 = curmenu();
				get_dishes_for_add(menuid1,menu_section.val());
		changeperiod('2014');
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
		isdrink = $( "#isdrink" ),
		allFields = $( [] ).add( sectionname ).add( sectionparent ).add( section_id).add( isdrink),
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
			data: { operation: operation,  sectionname: sectionname.val(), sectionparent: sectionparent.val(), sectionid: section_id.val(), isdrink: isdrink.prop('checked')}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Информация о разделе сохранена.');
				changeperiod('2014');
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
      }
    });
	
 
 
    form = dialog3.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      adddish();
    });
 

	
	$( document ).on( "click", "button[name=dishtomenu]", function() {
				dishid = $(this).attr("dishid");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");
								if (confirm("Вы уверены что хотите вернуть блюдо в меню?")) {
					dish_to_menu(dishid, menuid, sectionid);
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
				sectionid = $(this).attr("secid");
				get_edit_dish_form(dishid, menuid, sectionid);
				//dialog2.dialog( "close" );
				//$( ".ui-dialog" ).css("margin-top", "70px");

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
  
   function changetype()
 {
 
	type = $("#arhivtype :selected").val();
	print_periods(type);
	changeperiod(curyear);
 }
  
 function changeperiod(year)
 {
	period = $("#arhivdate"+year+" :selected").attr("period");
	value = $("#arhivdate"+year+" :selected").val();
	type = $("#arhivtype :selected").val();
	//alert(value);
	
	print_menu_tree(period,value,type,year);
	
 }
 
	</script>
  </body>
</html>
