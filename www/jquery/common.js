		function count_dish_weight()
		{

		wfood = 0;
		wdrink = 0;
		persons = $.cookie("guestcount") * 1;
		if(persons > 0) 
		{
			$("#createform .btn-primary").each(function(){
				if ($(this ).text() == 'Удалить') 
				{
					id = $(this).attr('id');
					id = id.substr(7);
					quant = $("#quant"+id).val();

					if ($(this ).hasClass("weightfood"))
					{
						wfood+=$("#weightfood"+id).html() * 1 * quant;
					}
					if ($(this ).hasClass("weightdrink"))
					{
						wdrink+=$("#weightdrink"+id).html() * 1 * quant;
					}
				}
			});

			wfa = Number((wfood/persons).toFixed(2));
			wfd = Number((wdrink/persons).toFixed(2));
			
			$("#foodweightall").html("Общий вес:" + wfood);
			$("#foodweightaver").html("Средний вес:" + wfa);
			$("#drinkweightall").html("Общий литраж:" + wdrink);
			$("#drinkweightaver").html("Средний литраж:" + wfd);
		}
		else
		{

		}
		}
