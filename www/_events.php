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

	$(document).ready(function() {
	
	$('#tabs2').smartTab({selected: 0});		

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
	
	   dialog = $( "#viewevent-form" ).dialog({
      autoOpen: false,
      height: 350,
      width: 400,
      modal: true,
      buttons: {
	  "Сохранить": saveevent,
        "Закрыть": function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        
      }
    });
	
	
	 form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
	
	
	
	  $('#calendar').fullCalendar({
	   aspectRatio: 1.5,
	  height: 470,
	  	header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			selectable: true,
			selectHelper: true,
			select: addevent,

			editable: true,
			droppable: true, // this allows things to be dropped onto the calendar !!!
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
            operation: 'getallevents',
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
	
	
});
	
	
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
		dialog.dialog('option', 'title', 'Добавление нового мероприятия');
		dialog.dialog("open");
	}
	
	
	function viewevent ( calEvent, jsEvent, view){
	

	$("#title").val(calEvent.title);
	$("#todo").val(calEvent.todo);
	$("#date").val(normdate(calEvent.start));
	$("#id").val(calEvent.id);
//	$("#complete").val(calEvent.complete);

	dialog.dialog('option', 'title', 'Просмотр и редактирование мероприятия');

	dialog.dialog("open");
		}
	
	function saveevent()
	{

		id = $("#id").val();
		title = $("#title").val();
		todo = $("#todo").val();
		start = $("#date").val();
	//	complete = $("#complete").val();



			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'saveevent', eventid: id, eventtitle: title, eventtodo: todo, eventdate: start}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
			dialog.dialog("close");
				
			$('#calendar').fullCalendar( 'refetchEvents' );		
	        form[ 0 ].reset();

		} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
		
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
	<li><a href="#eventview1">Календарь</a></li>
	<li><a href="#eventview2" >Список</a></li>
	</ul>
	<div id="eventview1" >
	<div id='calendar'></div>
	</div>
	<div id="eventview2" >
	<div id='list'></div>
	</div>
 </div>
<?php

//fixedbotbar();

?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

	
	<div id="viewevent-form" title="Просмотр мероприятия">
  <form>
	<input type="text" id="title" placeholder="Заголовок" class="form-control" value="">
	<input type="text" id="todo" placeholder="Описание" class="form-control" value="">
	<input type="text" id="date" placeholder="Дата" class="form-control" value="">
	<!-- <div class="checkbox"> <label> <input id="complite" type="checkbox" value="yes">Завершено</label></div> -->
 	<input type="hidden" id="id" class="form-control" value="">
 </form>
</div>
 </div>
 </body>
</html>
