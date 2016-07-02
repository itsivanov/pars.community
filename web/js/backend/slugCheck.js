function slugChecker(title, path, checker, url)
{
	var $title    = title;
	var $path     = path;
	var $checker  = checker;

	function setRightSlug(slug) {
		$.ajax({
			url  : Host + url,
			data : {title:slug},
			method : 'GET',
			dataType : 'json',
		}).done(function(req){

			if (req.slug) {
				$path.val(req.slug);
			}

		});
	}

	$checker.change(function(){
		if ($(this).prop('checked') == true) {
			$path.attr('readonly',true);
		} else {
			$path.attr('readonly',null);
		}
	});

	$title.change(function(){
		setRightSlug($title.val());
	});

	$path.change(function(){
		setRightSlug($path.val());
	});
}
