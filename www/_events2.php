<?php
require_once("config.inc.php");
require_once("functions.inc.php");
$qq = @$_SERVER['QUERY_STRING'];
if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
	    <script src="/jquery/jquery.min.js"></script>
<script>

	$(document).ready(function() {
	
	   dialog = $( "#viewevent-form" ).dialog({
      autoOpen: false,
      height: 350,
      width: 400,
      modal: true,
      buttons: {
        "Закрыть": function() {
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
		/* initialize the external events
		-----------------------------------------------------------------*/
	
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
	
	
		/* initialize the calendar
		-----------------------------------------------------------------*/
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
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
			events: [
<?php
	$tsql01 = "select * from `events_in_orders`  ;";
	//echo $tsql01; 
	$result01 = mysql_query($tsql01);
	if (mysql_num_rows($result01)>0)
	{	
		$sortid = mysql_num_rows($result01) + 1; 
		while ($rows01 = mysql_fetch_array($result01))
		{
	
		$startdate = $rows01['targetdate'];
		if($rows01['targettime'] > 0) 
		{
			$time = explode($rows01['targettime'],":");
			$start = $startdate."T".$rows01['targettime'];
		}
			else
		{
			$start = $startdate;
		}
		

		echo "{".chr(10);
		echo "id: '".$rows01['orderid']."',".chr(10);
		echo "title: '".$rows01['title']."',".chr(10);
		echo "start: '".$start."',".chr(10);
		echo "description: '".$rows01['todo']."'".chr(10);
		echo "},".chr(10);
		
		}
	}



?>


			],
			  eventClick: viewevent,
			
			
			
			
			
		});
		
		
	});

	function addevent(start)
	{
		alert(start);
	
					eventData = {
						title: title,
						start: start
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
					
				$('#calendar').fullCalendar('unselect');
	}
	
	
	function viewevent (calEvent, jsEvent, view){
	
				alert('Event: ' + calEvent.description);
			alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
			alert('View: ' + view.name);

			// change the border color just for fun
			$(this).css('border-color', 'red');
		}
</script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	}
		
	#wrap {
		width: 1100px;
		margin: 0 auto;
	}
		
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		border: 1px solid #ccc;
		background: #eee;
		text-align: left;
	}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}
		
	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
		float: left;
		width: 600px;
	}

</style>
</head>
<body>
 
<?php
	global $userroles;
fixednavbar();

?>

	<div id='wrap'>


		<div id='calendar'></div>

		<div style='clear:both'></div>

	</div>
	<div id="viewevent-form" title="Просмотр мероприятия">
  <form>
	<input type="text" id="title" placeholder="Заголовок" class="form-control" value="">
	<input type="text" id="todo" placeholder="Описание" class="form-control" value="">
	<input type="text" id="date" placeholder="Дата" class="form-control" value="">
	<input type="text" id="time" placeholder="Время" class="form-control" value="">
	<input type="text" id="comments" placeholder="Комментарии" class="form-control" value="">
  </form>
</div>


  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

	<script src="/jquery/jquery.ui.datepicker-ru.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/jquery/validator.js"></script>
	<script src="/jquery/jquery.cookie.js"></script>
	<script src="/jquery/smarttab/js/jquery.smartTab.min.js"></script>
	<script src="/jquery/jquery.json-2.4.js"></script>
	
</body>
</html>
