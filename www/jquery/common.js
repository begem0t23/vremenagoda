	function isDate(sDate) {
	   var re = /^\d{1,2}\.\d{1,2}\.\d{4}$/
	   if (re.test(sDate)) {
		  //var dArr = sDate.split(".");
		  //var d = new Date(sDate);
		  //return d.getMonth() + 1 == dArr[0] && d.getDate() == dArr[1] && d.getFullYear() == dArr[2];
		  return true;
	   }
	   else {
		  return false;
	   }
	}	

		function changehallstatus(hallid)
		{
	
		hallstatus=$("#hallstatus"+hallid+" :selected").val();
		dateevent=$("#hallstatus"+hallid).attr('dateevent');
			
				$.ajax({
					type: "POST",
					url: "functions.php",
					data: { operation: 'changehallstatus', hallid:hallid, dateevent:dateevent, hallstatus:hallstatus}
				})
				.done(function( msg ) {
						if(msg == 'yes'){
						alert("Статус зала обновлен.");
							} else {
						alert ('Что-то пошло не так. '+msg);
						
						}
				});
			
		}

		


		function count_dish_weight()
		{

		wfood = 0;
		wdrink1 = 0;
		wdrink2 = 0;
		wfood0 = 0;
		wdrink10 = 0;
		wdrink20 = 0;
		persons = $.cookie("guestcount") * 1;
		if(persons > 0) 
		{
			$(".btn-primary").each(function(){
				if ($(this ).text() == 'Удалить') 
				{

					id = $(this).attr('id');
					id = id.substr(7);

					quant = $("#quant"+id).val();

					if ($(this ).hasClass("weightfood"))
					{
						wfood+=$("#weightfood"+id).html() * 1 * quant;
					}
					if ($(this ).hasClass("weight1drink"))
					{
						wdrink1+=$("#weightdrink"+id).html() * 1 * quant;
					}
					if ($(this ).hasClass("weight2drink"))
					{
						wdrink2+=$("#weightdrink"+id).html() * 1 * quant;
					}
				}
			});

			$("#createform .btn-primary").each(function(){
				if ($(this ).text() == 'Удалить') 
				{

					id = $(this).attr('id');
					id = id.substr(7);
					quant = $("#quant"+id).val();

					if ($(this ).hasClass("weightfood"))
					{
						wfood0+=$("#weightfood"+id).html() * 1 * quant;
						
					}
					if ($(this ).hasClass("weight1drink"))
					{
						wdrink10+=$("#weightdrink"+id).html() * 1 * quant;
					}
					if ($(this ).hasClass("weight2drink"))
					{
						wdrink20+=$("#weightdrink"+id).html() * 1 * quant;
					}
				}
			});
		
		if (wfood0) wfood = wfood0;
		//wfood -= wfood0;
		if (wdrink10) wdrink1 = wdrink10;
		//wdrink1 -= wdrink10;
		if (wdrink20) wdrink2 = wdrink20;
		//wdrink2 -= wdrink20;
		
		
			wfa = Number(wfood/persons).toFixed(2);
			wfd1 = Number(wdrink1/persons).toFixed(2);
			wfd2 = Number(wdrink2/persons).toFixed(2);
			
			 $("#foodweight").html(" Блюда: " + Number(wfood).toFixed(2) +"г/"+wfa+"г");
			$("#drink1weight").html("Спиртное: " + Number(wdrink1).toFixed(2) +"г/"+wfd1+"г");
			$("#drink2weight").html(" Напитки: " + Number(wdrink2).toFixed(2) +"г/"+wfd2+"г");
			
		}
		else
		{

		}
		}

		


	function setvaluesincookie()
		{
			//aler($("body #clientfrom").val());
			
			if ((curpage==1) && (typeof $("body #clientname").val() != 'undefined'))
			{

		
				$.cookie("clientname", $("body #clientname").val(),{ expires: 1, path: '/' });
				$.cookie("clientid", $("body #clientid").val(),{ expires: 1, path: '/' });
				if ($("body #clientfrom").val()!="Укажите откуда пришел")
				{
					$.cookie("clientfrom", $("body #clientfrom").val(),{ expires: 1, path: '/' });
				}
				$.cookie("clientfrom4", $("body #clientfrom4").val(),{ expires: 1, path: '/' });
				$.cookie("clientphone", $("body #clientphone").val(),{ expires: 1, path: '/' });
				$.cookie("clientemail", $("body #clientemail").val(),{ expires: 1, path: '/' });
				$.cookie("dateevent", $("body #dateevent").val(),{ expires: 1, path: '/' });
				$.cookie("timeevent", $("body #timeevent").val(),{ expires: 1, path: '/' });
				$.cookie("guestcount", $("body #guestcount").val(),{ expires: 1, path: '/' });
				$.cookie("hall", $("body #hall").val(),{ expires: 1, path: '/' });
				
			}
			if (curpage==2)	{
	
			}
			if (curpage==3)	{
	
			}
			if (curpage==4)	{
	
			}
			if (curpage==5)	{
				$.removeCookie("eventtype");
				$.removeCookie("eventcomment");
				
				$.cookie("eventtype", $("#type").val(),{ expires: 1, path: '/' });
				$.cookie("eventcomment", $("#comment").val(),{ expires: 1, path: '/' });
			}
		}
		
	function setvaluesincookie2()
		{
					$.removeCookie("clientname");
				$.removeCookie("clientid");
				$.removeCookie("clientphone");
				$.removeCookie("clientfrom");
				$.removeCookie("clientfrom4");
				$.removeCookie("clientemail");
				$.removeCookie("dateevent");
				$.removeCookie("timeevent");
				$.removeCookie("guestcount");
				$.removeCookie("hall");
				$.removeCookie("tables");
					$.removeCookie("editclientid");
			
				$.cookie("editclientid", $("body #editclientid").val(),{ expires: 1, path: '/' });
				$.cookie("clientname", $("body #clientname").val(),{ expires: 1, path: '/' });
				$.cookie("clientid", $("body #clientid").val(),{ expires: 1, path: '/' });
				if ($("body #clientfrom").val()!="Укажите откуда пришел")
				{
					$.cookie("clientfrom", $("body #clientfrom").val(),{ expires: 1, path: '/' });
				}
				$.cookie("clientfrom4", $("body #clientfrom4").val(),{ expires: 1, path: '/' });
				$.cookie("clientphone", $("body #clientphone").val(),{ expires: 1, path: '/' });
				$.cookie("clientemail", $("body #clientemail").val(),{ expires: 1, path: '/' });
				$.cookie("dateevent", $("body #dateevent").val(),{ expires: 1, path: '/' });
				$.cookie("timeevent", $("body #timeevent").val(),{ expires: 1, path: '/' });
				$.cookie("guestcount", $("body #guestcount").val(),{ expires: 1, path: '/' });
				$.cookie("hall", $("body #hall").val(),{ expires: 1, path: '/' });
					var tables = "";
					var taball = {};
					var element = {};
					
								//tables_func($("body #hall").val(),'editor',$("body #dateevent").val(),'selectedhall')
				//	$("body  .table.primary2").each(function(){
		//alert('dd');
							//tabid1 = $(this).attr("tabid");
							//tabnum1 = $(this).html();
							//element = ({tabid:tabid1, tabnum:tabnum1});
							//taball[tabid1] = element ;
						//});
					//tables = $.toJSON(taball);
					//$.cookie("tables", tables,{ expires: 1, path: '/' });
			
	$.removeCookie("dishes");
			
					var dishes="";
					var dishall = {};
					var element = {};
					$("body  button[name=adddish]").each(function(){
							id = $(this).attr("id");
							id = id.substr(7);
							if ($(this).html()=="Удалить")
							{
								var quant = $("#quant"+id).val();
								var note = $("#note"+id).val();
								var selprice 	= $("#selprice"+id).html();
								element = ({quant:quant, note:note, selprice:selprice});
								dishall[id] = element ;
							}
						});
						dishes = $.toJSON(dishall);
						$.cookie("dishes", dishes,{ expires: 1, path: '/' });
	
	$.removeCookie("service");
					var services="";
					var serviceall = {};
					var element = {};
						$("body  button[name=addserv]").each(function(){
							id = $(this).attr("id");
							id = id.substr(7);
							if ($(this).html()=="Удалить")
							{
								priceserv 	= $("#priceserv"+id).val();
								quantserv 	= $("#quantserv"+id).val();
								discont 	= $("#discontserv"+id).val();
								comment 	= $("#commentserv"+id).val();
								element = ({priceserv:priceserv, quantserv:quantserv, discont:discont, comment:comment});
								serviceall[id] = element ;
							}
						});
						services = $.toJSON(serviceall);
						$.cookie("service", services,{ expires: 1, path: '/' });

				$.removeCookie("eventtype");
				$.removeCookie("eventcomment");
				
				$.cookie("eventtype", $("body #type").val(),{ expires: 1, path: '/' });
				$.cookie("eventcomment", $("body #comment").val(),{ expires: 1, path: '/' });
			
		}

		
			function shownextstep()
		{
		alladd = $("#createform  .btn-danger").length;			
		
	
			if(alladd > 0) 
			{
				//alert("Остались недобавленные позиции: " + alladd);
				$('body').animate({ scrollTop: $("#createform .btn-danger").offset().top - 100 }, 500);
			} else
			{
			
				if ($("body #guestcount").val()>0)
				{
					//хуй
				}
				else
				{
					var nn = noty({text: 'Заполните количество гостей', type: 'error', timeout:10000, onClick: function(){delete nn;}});											
					return false;
				}
				if (isDate($("body #dateevent").val()))
				{
					//хуй
				}
				else
				{
					var nn = noty({text: 'Заполните дату мероприятия', type: 'error', timeout:10000, onClick: function(){delete nn;}});											
					return false;
				}						
			setvaluesincookie();
			if (curpage<5) curpage = curpage + 1;
			$("#page"+curpage).click();

			count_dish_weight();
						
			
			}
		}	
		
		
			function convertdate(fulldate)
	{
		d = fulldate.substr(0,2);
		m = fulldate.substr(3,2);
		y = fulldate.substr(6,4);
		date = y+'-'+m+'-'+d;
		
		return date;
	}