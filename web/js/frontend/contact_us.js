// < Sending data from the form into the database and e-mail
$('.contact__send').on('click', function(){

    var fullName = $('.send_full_name').val();
    var eMail = $('.send_e_mail').val();
    var webSite = $('.send_web_site').val();
    var subject = $('.send_subject').val();
    var message = $('.send_message').val();

		$.ajax({
				type: "POST",
				url: "/contact-us/index",
				data: {fullName:fullName,
               eMail:eMail,
               webSite:webSite,
               subject:subject,
               message:message},
		}).success(function(data)
			{
					//console.log(data);
			});

});
// >
