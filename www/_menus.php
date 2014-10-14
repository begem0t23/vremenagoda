<?
global $accesdenied;
if ($_SESSION["curuserrole"]<6) die($accessdenied);
?>
<!DOCTYPE html>
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
  
  .fromarhiv {
	color: #000;
  background-color: #11FFC0 !important;
  }
  .basic {
	color: #000;
  background-color: #FAAFE6 !important;
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
 


 
 <div id="dialog-editdish" title="Заполните информацию о блюде">
 
</div>

 <div id="dialog-editsection" title="Заполните информацию о разделе">
 
</div>
<?php

fixednavbar();

$select = "SELECT  DATE_FORMAT(startdate,'%d.%m.%Y') as dstart,  DATE_FORMAT(enddate,'%d.%m.%Y') as dend FROM `special_prices_period` ORDER BY `id` DESC LIMIT 0,1 ;";
$rezult = mysql_query($select);
$row = mysql_fetch_array($rezult);
$dstart = $row['dstart'];
$dend = $row['dend'];


?>

    <!-- Begin page content -->
    <div class="container">
		<div class="page-header">
        <h3>Редактирование Меню</h3>
		</div>
<div class="input-group" style="width:400px;">
 <span class="input-group-addon"><span>Специальные цены </span></span>
 <input value = "<?php echo $dstart; ?>"  data-mask="99.99.9999" maxlength="10" type="text" id="specpricestart" onchange="newspecpriceperiod();" onclick="$('#specpricestart' ).datepicker( 'show' );" class="form-control" placeholder="Начало периода">
 <input  value = "<?php echo $dend; ?>"  data-mask="99.99.9999" maxlength="10" type="text" id="specpriceend" onchange="newspecpriceperiod();" onclick="$('#specpriceend' ).datepicker( 'show' );" class="form-control" placeholder="Конец периода">
  </div>	
		<br>
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
	function viewtree(key) {
	if(key == 1) 
	{
					$.cookie("viewtree", '1',{ expires: 1, path: '/' });
			$(".fullrow").show();
			$(".glyphicon-plus").addClass("glyphicon-minus");
			$(".glyphicon-plus").removeClass("glyphicon-plus");
			normal_height()
	}
	
	if(key == 0) 
	{
					$.cookie("viewtree", '0',{ expires: 1, path: '/' });
			$(".glyphicon-minus").addClass("glyphicon-plus");
			$(".glyphicon-minus").removeClass("glyphicon-minus");
			$(".dis_0 span").removeClass("glyphicon-plus");
			$(".dis_0 span").addClass("glyphicon-minus");

			$(".fullrow").hide();
			normal_height()
    }
}
	
	
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
 
 
 function viewfromarchiv()
 {
 viewtree(0);
 $(".fromarhiv").show();
 normal_height();
 }
 
  function viewbasic()
 {
 viewtree(0);
 $(".basic").show();
 normal_height();
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
			data: { operation: 'printmenutree', typetree: 'menu'}
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
			viewtree($.cookie("viewtree"));
		});
	
	}

	
	function dish_from_menu (dishid,menuid,sectionid){
	
		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'dishfrommenu', menuid: menuid, dishid: dishid, sectionid:sectionid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				//alert ('Блюдо удалено из меню.');
				//get_dishes_for_add(menuid,sectionid);
				print_menu_tree(menuid);
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
	}
	

	

		$(document).ready(function(){
			// когда страница загружена


			
			
			
			
			
			$('#specpricestart').datepicker({  });
			$('#specpriceend').datepicker({  });


$( document ).on( "click", "button[name=dishfrommenu]", function() {
				dishid = $(this).attr("dishid");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");
								if (confirm("Вы уверены что хотите убрать блюдо из меню?")) {
					dish_from_menu(dishid, menuid, sectionid);
				} else {
				}
				
    });
	
	
	
	
			$(".menus")
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
		specialprice = $( "#specialprice" ),
		menu_section = $( "#menu_section" ),
		dish_id = $( "#dish_id" ),
		allFields = $( [] ).add( name ).add( description ).add( price ).add( specialprice ).add( weight ).add( menu_section ),
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
		specialprice = $( "#specialprice" ),
		isbasic = $( "#isbasic" ),
		menu_section = $( "#menu_section" ),
		dish_id = $( "#dish_id" ),
		menu_id = $( "#menu_id" ),
		allFields = $( [] ).add( name ).add( isbasic ).add( description ).add( price ).add( specialprice ).add( weight ).add( menu_section ).add( dish_id ).add( menu_id ),
		tips = $( ".validateTips" );


      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "названия", 3, 250 );
      valid = valid && checkLength( description, "описания", 0, 250 );
      valid = valid && checkLength( weight, "веса", 2, 5 );
     valid = valid && checkLength( price, "цена", 1, 10 );
     valid = valid && checkLength( specialprice, "специальная цена", 1, 10 );
 
      //valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\(\)\s])+$/i, "Недопустимые символы." );
     //valid = valid && checkRegexp( description, /^[a-z]([0-9a-z_\s])+$/i, "Недопустимые символы." );
       valid = valid && checkRegexp( price, /^([0-9.])+$/, "Цена может состоять только из цифр : 0-9 и точки" );
       valid = valid && checkRegexp( specialprice, /^([0-9.])+$/, "Цена может состоять только из цифр : 0-9 и точки" );
       valid = valid && checkRegexp( weight, /^([0-9])+$/, "Цена должна состоять только из цифр : 0-9" );
 
      if ( valid ) 
	  {

		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'adddish', dishname: name.val(),isbasic: isbasic.prop("checked"), dishdescription: description.val(), dishweight: weight.val(), dishprice: price.val(), dishspecialprice: specialprice.val(), dishid: dish_id.val(), menu_section: menu_section.val(), menuid: menu_id.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				//alert ('Информация о блюде сохранена.');
				menuid1 = curmenu();
				//get_dishes_for_add(menuid1,menu_section.val());
				print_menu_tree(menuid1);
				menutitle = curmenutitle();
				sectiontitle = $( "#menu_section option:selected").text().replace('-','');
				dialog3.dialog( "close" );
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
		
	}
      return valid;
    }
 

 
	

      dialog3 = $( "#dialog-editdish" ).dialog({
      autoOpen: false,
      height: '450',
      width: '800',
      modal: true,
      buttons: {
        "Сохранить": adddish,
        "Отмена": function() {
          dialog3.dialog( "close" );

        }
      }
    });
	
 

	$( document ).on( "click", "button[name=editdish]", function() {
				dishid = $(this).attr("dishid");
				menuid = $(this).attr("menuid");
				sectionid = $(this).attr("sectionid");
				get_edit_dish_form(dishid, menuid, sectionid);

				$(".ui-dialog-buttonset button").each(function(){
					if($(this).html() == "Сохранить")
					{
						$(this).attr("disabled","disabled");
						$(this).removeClass("btn-danger");
					}			 
				});
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



	
  });
  
 function changeform()
 {
	$(".ui-dialog-buttonset button").each(function(){
 
		if($(this).html() == "Сохранить")
			{
				$(this).removeAttr("disabled");
				$(this).addClass("btn-danger");
			}
 
	});
 
 }
 
 function newspecpriceperiod()
 {
 
 startdate = $('#specpricestart' ).val();
 enddate = $('#specpriceend' ).val();
 
if(startdate != "" & enddate != "")
{
 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'newspecpriceperiod', startdate: startdate, enddate: enddate}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				alert("Период обновлен.");
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
 
 }
 }
 
	</script>
  </body>
</html>
