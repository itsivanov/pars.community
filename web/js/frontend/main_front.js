// < Link more (articles)
		$(document).ready(function(){
			$("#imgPreload").hide();

		});

		var num = 15;
		var end = false;
		var inProgress = false;
			// <<< Scroll for ajax
					$(window).scroll(function() {

							// Если нет записей в бд, то функция не запускается
							if(! end)
							{

							   if($(window).scrollTop() + $(window).height() >= $(document).height() - 50 && !inProgress) {
						 		 //$(".latest__more").click(function(){

								 			inProgress = true;

											$("#imgPreload").show();

											setTimeout(function() {

												$.ajax({
													url: "/site/link-more/",
													type: "GET",
													data: {"num": num},
													cache: false,
													success: function(response){

														if(response == 0){
															alert("0");
															$("#imgPreload").hide();
														}else{
															$("#grid").append(response);

															// Css for new li
															var cg = new content_grid();
															cg.init();

															num = num + 9;
															$("#imgPreload").hide();


																	// < Проверяем, есть ли еще записи в бд
																	$.ajax({
																		url: "/site/link-more/",
																		type: "GET",
																		data: {"num": num},
																		cache: false,
																		success: function(response){
																			if(response == 0){
																				end = true;
																			}
																		}
																	});
																	// >


															inProgress = false;

														}
													}
												});

											},500);


							 		//});
								 }
						 }
					});
			// >>>

// >
