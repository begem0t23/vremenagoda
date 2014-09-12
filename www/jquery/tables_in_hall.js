	function hall_resize(hallid,nwidth,nheight){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'hallresize', hallid: hallid, nwidth:nwidth, nheight: nheight}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				get_hall(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
	
	}
	
	function change_tabnum(tabid,tabnum){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'changetabnum', tabid:tabid, tabnum: tabnum}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				get_hall(curmenu());
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
	
	}
	
	function add_table(hallid,ntop,nleft,typeid,place,dateevent){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addtable', hallid: hallid, ntop:ntop, nleft:nleft, typeid:typeid, place:place, dateevent:dateevent}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				if(place=='halleditor') get_hall(hallid);
				if(place=='order') get_selected_hall(hallid,dateevent);
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
	

	
		
	function remove_table(hallid,tabid,place,dateevent){

	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'removetable', hallid:hallid, tabid: tabid, place:place, dateevent:dateevent}
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

	
	
	
	
	
	function change_table(hallid,tabid,persons,ntop,nleft,place,dateevent){

	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'changetable', tabid: tabid, tabpersons:persons, tabtop: ntop, tableft: nleft, place:place, dateevent:dateevent}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				if(place=='halleditor') get_hall(hallid);
				if(place=='order') get_selected_hall(hallid,dateevent);
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});
	
	}
	



	function get_hall(hallid){

	  		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'gethall', hallid: hallid, place:'halleditor'}
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
				revert:"invalid",
				  stop: addtable
				});
				
				$(".trash").droppable({  tolerance : 'touch', accept : '.table,.chiar', drop: totrash});

				$("#hallcontent-"+hallid+" .hallplace").droppable({  tolerance : 'fit',accept : '.newtable, .table'}).resizable({grid:10, resize: normal_height, stop: hallresize});
				$("#hallcontent-"+hallid+" .table").draggable({ 
					grid:[ 10, 10 ],
					scroll:false, 
					snap:"#hallplace-"+hallid,
					revert:"invalid",
					snapTolerance: 5,
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
				
				 $.contextMenu({
					selector: '.context-menu-one', 
					callback: function(key, options) {
						var m = "clicked: " + key;
						window.console && console.log(m) || alert(m); 
					},
					items: {
						"edit": {name: "Изменить название", icon: "edit"},
						"rot90": {name: "Повернуть на 90%", icon: "cut"},
						"rot+45": {name: "На 45 по часовой", icon: "copy"},
						"rot-45": {name: "На 45 против часовой", icon: "paste"}

					}
				});
			
	
			});
	
	}
	
		function normal_height()
  {
  
 hallid = curmenu();
			
 newh = $( "#hallplace-"+hallid ).height() + 100;
 //alert(newh);
$( ".stContainer" ).css("height", newh + "px");

 }
	
	function addchiar( event, ui ) {
		fromtabid = ui.draggable.attr('tabid');

		totabid = $(this).attr('id');
		totabid = totabid.substr(5);

		add_chiar(fromtabid, totabid);
 	}
	
	
	function addtable( event, ui ) {
	hallid = $(this).attr('hallid');
	place = $(this).attr('place');
	dateevent = $(this).attr('dateevent');


	tleft = ui.offset.left ;
	ttop = ui.offset.top ;

 	tabid = $(this).attr('tabid');
  	typeid = $(this).attr('typeid');

	pleft = $("#hallplace-"+hallid).offset().left;
	ptop = $("#hallplace-"+hallid).offset().top;

	ntop = ttop - ptop;
	nleft = tleft - pleft;

	
	if(tabid == 0) add_table(hallid,ntop,nleft,typeid, place, dateevent);

		
 	}
	
	
	function totrash( event, ui ) {
		tabid = ui.draggable.attr('tabid');
		hallid = ui.draggable.attr('hallid');
	place = ui.draggable.attr('place');
	dateevent = ui.draggable.attr('dateevent');
		if(ui.draggable.attr('ischiar'))	
		{
			remove_chiar(tabid);
		} else
		{
			remove_table(hallid, tabid, place, dateevent);
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
	place = $(this).attr('place');
	dateevent = $(this).attr('dateevent');

	change_table(hallid, tabid, persons, ntop, nleft, place, dateevent);
 	}


	
	function hallresize( event, ui ) {

hall_resize(curmenu(), ui.size.width, ui.size.height);

 	}

		function get_selected_hall(hallid,dateevent)
		{

	  		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'gethall', hallid: hallid, dateevent:dateevent, place:'order'}
			})
			.done(function( msg ) {
				//alert(msg);
				$("#selectedhall").html(msg);//закачали хтмл

				//расстановка столов по координатам
				$("#selectedhall .table").each(function()
				{
					ntop = parseInt($(this).attr('top'));
					nleft = parseInt($(this).attr('left'));
					ptop = $(this).parent().offset().top;
					pleft = $(this).parent().offset().left;
					
					$(this).offset({top:(ptop + ntop),left: (pleft + nleft)});
				});

				//раскраска выбранных столов
				tables = "";
				if (typeof $.cookie("tables") != 'undefined') tables = $.cookie("tables");
				if (tables) 
				{
					var taball = $.parseJSON(tables);
					$.each(taball, function(index, value) 
					{
						//console.log(index + " "+ value['tabnum']);
						if (index)
						{
							$("#table"+index).removeClass("btn-success");
							$("#table"+index).addClass("btn-primary");
						}					
					});
				}
				
				
				
				
								//присвоение дрэг и дроп
				$(".newtable").draggable({
				helper: 'clone',
				revert:"invalid",
				  stop: addtable
				});
				
				$(".trash").droppable({  tolerance : 'touch', accept : '.table.btn-success,.chiar', drop: totrash});

				$(".hallplace").droppable({  tolerance : 'fit',accept : '.newtable, .table.btn-primary,.table.btn-success'});
				
				
				$("#hallplace-"+hallid+" .table").draggable({ 
					grid:[ 10, 10 ],
					scroll:false, 
					snap:"#hallplace-"+hallid,
					revert:"invalid",
					snapTolerance: 5,
					stop: tabstop
				});
				
				checkhallselect();
				
				
				  $.contextMenu({
        selector: '.context-menu-one', 
        callback: function(key, options) {
            var m = "clicked: " + key;
            window.console && console.log(m) || alert(m); 
        },
        items: {
            "edit": {name: "Edit", icon: "edit"},
            "cut": {name: "Cut", icon: "cut"},
            "copy": {name: "Copy", icon: "copy"},
            "paste": {name: "Paste", icon: "paste"},
            "delete": {name: "Delete", icon: "delete"},
            "sep1": "---------",
            "quit": {name: "Quit", icon: "quit"}
        }
    });
			});
				
		}
		


