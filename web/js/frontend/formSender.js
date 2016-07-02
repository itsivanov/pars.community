var formSender = {

	send : function()
	{
		var errorBlocks = $("#error-block");

		var data = {
			'email' 	 : $('#email-input').val(),
			'email-text' : $('#email-text').val(),
			'ajax'		 : 1
		}

		$.ajax({
		  method: "POST",
		  url: Host + 'site/email-send',
		  data : data,
		  dataType : 'json',
		  success : function(data) {
			  	if(data.success)
			  		errorBlocks.removeClass('error').addClass('success');
			  	else
			  		errorBlocks.removeClass('success').addClass('error');

		  		errorBlocks.text(data.text);
			}
		 });
	}

}
