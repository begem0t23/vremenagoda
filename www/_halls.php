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
  .trash{margin: 5px; display:block; width:70px; height: 25px; border:1px; background-color: red; position:relative; float:right;}
  .table{width:30px; height:30px;  border:1px solid #ddd; background-color:#eee;  }
  .newtable{margin: 5px; display:block;width:44px; height:40px;  border:1px solid #ddd; background-color:#eee; position:relative; float:right;}
   .newchiar {margin: 5px; display:block; width:30px; height: 25px; border:1px; background-color: #AADDC0; position:relative; float:right; }

    .hallplace {display:block; width:700px; height: 350px; border:1px; background-color: #FFFFC0;margin:15px; }
   .chiar {display:block; width:11px; height: 11px; border:1px; background-color: #AADDC0; position:absolute;}
  
  .left-top{left:-16px; top:1px;}
  .left-bottom{left:-16px; bottom:1px;}

  .right-top{right:-16px; top:1px;}
  .right-bottom{right:-16px; bottom:1px;}

  .top-left{left:1px; top:-16px;}
  .top-right{right:1px; top:-16px;}

  .bottom-left{left:1px; bottom:-16px;}
  .bottom-right{right:1px; bottom:-16px;}

  .top-left-corner{left:-16px; top:-16px;}
  .top-right-corner{right:-16px; top:-16px;}

  .bottom-left-corner{left:-16px; bottom:-16px;}
  .bottom-right-corner{right:-16px; bottom:-16px;}
  
 
	.tabnum{font-size:22px; margin: -7px 0px 0 -10px;}
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
	
	
	?>
	<li><a href="#hall-0">+</a></li>

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

 			echo '<div class="trash" >Корзина</div>';
 			echo '<div class="newtable" tabid="0" >СТОЛ</div>';
			echo '<div class="newchiar" tabid="0" >стул</div>';

			echo '<div id="hallcontent-'.$row_hall['id'].'" class="hallcontent"></div>';
			echo '</div>';
					
		}
	
						echo '<div id="hall-0" >';
					echo '</div>';
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
	
		
	<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>


	<script>
	function add_table(hallid){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addtable', hallid: hallid}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				get_hall(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
	
	}
	
	
		function add_chiar(fromtabid, totabid){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addchiar', fromtabid: fromtabid, totabid: totabid}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				get_hall(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
	
	}
	

	
		
	function remove_table(hallid,tabid){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'removetable', hallid:hallid, tabid: tabid}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				get_hall(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});

	}
	
	
	
	function remove_chiar(tabid){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'removechiar', tabid: tabid}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				get_hall(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
	}

	
	
	
	
	
	function change_table(hallid,tabid,persons,ntop,nleft){

	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'changetable', tabid: tabid, tabpersons:persons, tabtop: ntop, tableft: nleft}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				get_hall(hallid);
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
	
	}
	



	function get_hall(hallid){

	  		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'gethall', hallid: hallid}
			})
			.done(function( msg ) {
				$("#hallcontent-"+hallid).html(msg);//закачали хтмл
				
				//присвоение дрэг и дроп
				$(".newchiar").draggable({
				helper: 'clone',
				revert:"invalid",
				stack: ".table"
				});
				$(".newtable").draggable({
				helper: 'clone',
				revert:"invalid"
				});
				$(".trash").droppable({  tolerance : 'touch', accept : '.table,.chiar', drop: totrash});

				$("#hallcontent-"+hallid+" .hallplace").droppable({  tolerance : 'touch',accept : '.newtable, .table',  drop: addtable});
				$("#hallcontent-"+hallid+" .table").draggable({ 
					grid:[ 15, 15 ],
					scroll:false, 
					snap:"#hallplace-"+hallid,
					revert:"invalid",
					snapTolerance: 10 ,
					stop: tabstop
				});
				
				$("#hallcontent-"+hallid+" .table").droppable({  tolerance : 'touch',accept : '.newchiar, .chiar',  drop: addchiar});				
				$("#hallcontent-"+hallid+" .table .chiar").draggable({ 
					scroll:false, 
					revert:"invalid",
					stack: ".table"

				});


				//расстановка столов по координатам
				$("#hallcontent-"+hallid+" .table").each(function()
					{
					ntop = parseInt($(this).attr('top'));
					nleft = parseInt($(this).attr('left'));
					ptop = $(this).parent().offset().top;
					pleft = $(this).parent().offset().left;
					
				$(this).offset({top:(ptop + ntop),left: (pleft + nleft)});
									
					});
					
					
					
				// расстановка стульев вокруг столов
				
					$("#hallcontent-"+hallid+" .table .chiar").each(function()
					{
						
							if(!$(this).parent().hasClass("left-top-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("left-top-ok");
								$(this).addClass("left-top");
								$(this).addClass("placed");
							}
							
							if(!$(this).parent().hasClass("left-bottom-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("left-bottom-ok");
								$(this).addClass("left-bottom");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("right-top-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("right-top-ok");
								$(this).addClass("right-top");
								$(this).addClass("placed");
							}
							
							if(!$(this).parent().hasClass("right-bottom-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("right-bottom-ok");
								$(this).addClass("right-bottom");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("top-left-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-left-ok");
								$(this).addClass("top-left");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("top-right-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-right-ok");
								$(this).addClass("top-right");
								$(this).addClass("placed");
							}


							if(!$(this).parent().hasClass("bottom-left-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-left-ok");
								$(this).addClass("bottom-left");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("bottom-right-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-right-ok");
								$(this).addClass("bottom-right");
								$(this).addClass("placed");
							}

							if(!$(this).parent().hasClass("top-left-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-left-corner-ok");
								$(this).addClass("top-left-corner");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("bottom-left-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-left-corner-ok");
								$(this).addClass("bottom-left-corner");
								$(this).addClass("placed");
							}

							if(!$(this).parent().hasClass("top-right-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-right-corner-ok");
								$(this).addClass("top-right-corner");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("bottom-right-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-right-corner-ok");
								$(this).addClass("bottom-right-corner");
								$(this).addClass("placed");
							}


					});

				
				
				
				normal_height();
			});
	
	}
	
	
	function addchiar( event, ui ) {
		fromtabid = ui.draggable.attr('tabid');

		totabid = $(this).attr('id');
		totabid = totabid.substr(5);

		add_chiar(fromtabid, totabid);
 	}
	
	
	function addtable( event, ui ) {
		tabid = ui.draggable.attr('tabid');
		hallid = $(this).attr('hallid');
		//alert(tabid +'_'+hallid);
		if(tabid == 0) add_table(hallid);
 	}
	
	
	function totrash( event, ui ) {
		tabid = ui.draggable.attr('tabid');
		hallid = ui.draggable.attr('hallid');
		if(ui.draggable.attr('ischiar'))
		
		{
			remove_chiar(tabid);
		} else
		{
			remove_table(hallid, tabid);
		}
		
	}
	
	
	
	
	function tabstop( event, ui ) {
	var tleft = $(this).offset().left ;
	var ttop = $(this).offset().top ;
  
	ptop = $(this).parent().offset().top;
	pleft = $(this).parent().offset().left;
  
	hallid = $(this).attr('hallid');
	tabid = $(this).attr('tabid');
	persons = $(this).attr('tabpersons');
	ntop = ttop - ptop;
	nleft = tleft - pleft;

	change_table(hallid, tabid, persons, ntop, nleft);
 	}

	
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
	
	function normal_height()
  {
  
 hallid = curmenu();
			
 newh = $( "#hallcontent-"+hallid ).height() + 100;
 //alert(newh);
$( ".tabContent" ).css("height", newh + "px")

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
	onShowTab:function(){get_hall(curmenu());}
	
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
	
	
	
		$( document ).on( "click", "button[name=addtable]", function() {
		hallid = $(this).attr("id");
		add_table(hallid)		
		});

		$( document ).on( "click", "button[name=addtable]", function() {
		tabid = $(this).attr("id");
		persons = $("#tabpersons"+id).val();
		top = $("#table"+id).parent
		left = 
		change_table(tabid,persons,top, left);		
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
