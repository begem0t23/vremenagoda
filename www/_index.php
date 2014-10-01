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
	?> :: Мероприятия</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <script src="/jquery/jquery.min.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>

   <link href="/css/sticky-footer-navbar.css" rel="stylesheet">

    <link href="/jquery/jquery-ui.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.theme.min.css" rel="stylesheet">
	<link href="/jquery/smarttab/styles/smart_tab.css" rel="stylesheet" type="text/css">	
	<link rel="stylesheet" href="/jasny-bootstrap/css/jasny-bootstrap.min.css">	
<link href='css/fullcalendar.css' rel='stylesheet' />
<script src='jquery/moment.min.js'></script>
<script src='jquery/fullcalendar.min.js'></script>
<script src='jquery/ru.js'></script>
	<script src="/jquery/smarttab/js/jquery.smartTab.min.js"></script>

<style>

</style>
<script>


function get_orders(startdate,enddate)
{

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'getordersbydate', startdate:startdate, enddate:enddate}
		})
		.done(function( msg ) {
				if(msg){
				$("#list").html(msg);
				
				  $(".baseview")
  .tablesorter(
  {
      theme: 'blue',
       widgets: ['zebra','filter']
    });
					} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
}

function curdate()
{
 var moment = $('#calendar').fullCalendar('getDate');
	month = moment.month() +1;
	year = moment.year();
	 $("#linkeventview1").html("Список Заказов "+$(".fc-center h2").html() );
	 $("#linkeventview2").html("Календарь Заказов "+$(".fc-center h2").html() );
	 dayCount = new Date(year, month , 0).getDate();
	 if (month < 10) month = '0'+month;
	 start = year+'-'+month+'-01';
	 end = year+'-'+month+'-'+dayCount;
	 		get_orders(start,end);

	}
	

	function normal_height(tab)
{
newh =550;
if (tab == 2) newh = $( "#eventview"+tab ).height() + 30;
$( ".stContainer" ).css("height", newh +"px")
$( ".stMain" ).css("height", newh +"px")

  }
 
	$(document).ready(function() {
	
$('#tabs2').smartTab({
    selected: 0,  // Selected Tab, 0 = first tab
    saveState:false, // Remembers tab selection 
    contentURL:null, // content url, Enables Ajax content loading. ex: 'service.php'   
    contentCache:true, // Cache Ajax content
    keyNavigation:true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
    autoProgress:false, // Auto navigate tabs on interval
    progressInterval: 3500, // Auto navigate Interval (used only if "autoProgress" is set to true)
    stopOnFocus:false, // Stop auto navigation on focus and resume on outfocus
    transitionEffect:'none', // Effect on navigation, none/hslide/vslide/slide/fade
    transitionSpeed:'400', // Transition animation speed
    transitionEasing:'easeInOutExpo', // Transition animation easing
    autoHeight:false, // Automatically adjust content height
    onLeaveTab: null, // triggers when leaving a tab
    onShowTab: null  // triggers when showing a tab
});  
			$('#external-events .fc-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});
	

	
	
	
	  $('#calendar').fullCalendar({
	   aspectRatio: 1.5,
	  height: 470,
	  	header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
	 eventClick: function(event) {
        if (event.url) {
            window.open(event.url);
            return false;
        }
    },
	    eventAfterRender: function(event, element) {
		
 },
			selectable: false,
			selectHelper: true,
			select: addevent,

			editable: false,
			droppable: false, // this allows things to be dropped onto the calendar !!!
			drop: function(date) { // this function is called when something is dropped
			
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');
				
				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);
				
				// assign it the date that was reported
				copiedEventObject.start = date;
				
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
				
				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}
				
			},
			eventLimit: true, // allow "more" link when too many events
			events: {
        url: 'functions.php',
        type: 'POST',
        data: {
            operation: 'getallorders',
            custom_param2: 'somethingelse'
        },
        error: function() {
            alert('there was an error while fetching events!');
        },
        color: 'yellow',   // a non-ajax option
        textColor: 'black' // a non-ajax option
    },
			  eventClick: viewevent,
			
			eventDrop: refreshevents,
			
			
        // put your options and callbacks here
    });
	
			$( document ).on( "click", ".fc-button", function() {
			curdate();
			normal_height(1);
			});
curdate();
	
	$('#newpaydate').datepicker({ maxDate: "+0D" });
$('#otkazdate').datepicker({ maxDate: "+0D" });

 $("#allpaytab")
  .tablesorter(
  {
      theme: 'blue',
       widgets: ['zebra']
    });
	
$(".report_client2")
  .tablesorter(
  {
      theme: 'blue',
       widgets: ['zebra']
    });
	

	
  
		$('table').delegate('button.view', 'click' ,function(){
			location.href ="?view/"+$(this).closest('tr').children().first().html()+"/";
		});

   

 
	var orderid = $("#newpayment").attr('orderid');
	
	$('#calendar').fullCalendar( 'refetchEvents' );	
	normal_height(1);
});
	
	
	function showst()
	{
	
	}
	
	
	function refreshevents(calEvent, jsEvent, view)
	{

		$("#title").val(calEvent.title);
	$("#todo").val(calEvent.todo);
	$("#date").val(normdate(calEvent.start));
	$("#id").val(calEvent.id);
	
	
		saveevent();

	
	}
	
	
	
		function addevent(start)
	{
	$("#id").val('0');
		$("#date").val(normdate(start));
		//dialog.dialog('option', 'title', 'Добавление нового мероприятия');
		//dialog.dialog("open");
	}
	
	
	function viewevent ( calEvent, jsEvent, view){
	

	$("#title").val(calEvent.title);
	$("#todo").val(calEvent.todo);
	$("#date").val(normdate(calEvent.start));
	$("#id").val(calEvent.id);
//	$("#complete").val(calEvent.complete);

		}
	
	function saveevent()
	{

		id = $("#id").val();
		title = $("#title").val();
		todo = $("#todo").val();
		start = $("#date").val();
	//	complete = $("#complete").val();


alert (id);
		
				$('#calendar').fullCalendar('unselect');
	}
	
	function normdate(fulldate)
	{
		var ed = new Date(fulldate);
		d = ('0'+ed.getDate()).slice(-2);
		m = ('0'+(ed.getMonth() +1)).slice(-2) ;
		y = ed.getFullYear();
		date = y+'-'+m+'-'+d;
		return date;
	}
	
</script>
</head>
<body>
  
<?php
	global $userroles;
fixednavbar();

?>

    <!-- Begin page content -->
    <div class="container">
 
   <div id="tabs2" style="min-width: 700px; width: 100%;">
    <ul>
	<li><a  style="font-size:18px ; line-height:1.2"  href="#eventview1" onclick="$('#calendar').fullCalendar( 'refetchEvents' );normal_height(1);"  id="linkeventview2">Календарь Заказов</a></li>
	<li ><a   style="font-size:18px ; line-height:1.2" href="#eventview2" onclick="normal_height(2);" id="linkeventview1">Список Заказов</a></li>
	</ul>
	<div id="eventview1" >
	<div id='calendar'></div>
	</div>
	<div id="eventview2" style="width:100%;">
	<div id='list'>
	
	</div>
	</div>
 </div>
<?php

//fixedbotbar();

?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>

    <!-- Placed at the end of the document so the pages load faster -->



 </div>
 </body>
</html>
