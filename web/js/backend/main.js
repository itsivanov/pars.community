// < All values for links
$('.add-link-ajax').on('click', function(e){

		e.preventDefault();
    var id = $('.id-for-link').val();

		var links = {};
		$(".ln").each(function(){
		   links[$(this).attr('id')] = $(this).val();
		});

		$.ajax({
				type: "POST",
				url: "/admin/links/setlinks",
				data: {id:id, links:links},
		}).success(function(data)
			{
					//console.log(data);
					$("#w0").submit();
			});
});
// >

$('.art_cat_for_banner').on('change', function(){
	var cat_id = $(this).attr('value');
	var art_id = $(".id-for-link").val();
	var checked = $(this).prop('checked');

	$.ajax({
			type: "POST",
			url: "/admin/articles/set-cathegory",
			data: {art_id:art_id, cat_id:cat_id, checked:checked},
	}).success(function(data)
	{

	});

});



// < Add categories for banners
$('.select_all').on('click', function(){
		$(".cat_for_banner").prop("checked", true);
		$(".cat_for_banner:first").trigger('change');
});
$('.unselect_all').on('click', function(){
		$(".cat_for_banner").prop("checked", false);
		$(".cat_for_banner:first").trigger('change');
});

/*
$('.add-cat-for-banner').on('click', function(e){

		e.preventDefault();

		var id = $(".id_m").val()

		var categories = {};
		categories[0] = id;
		$(".cat_for_banner:checked").each(function(){
		   categories[$(this).attr('value')] = $(this).val();
		});

		var cats = src = 0;

		$.ajax({
				type: "POST",
				url: "/admin/bnrs/add-cat-for-banner",
				data: {categories:categories},
		}).success(function(data)
		{
				cats = 1;
				if(cats && src)
					$("#update_banner").submit();
		});


		var sources = $('#sourceChoosen').val();
		$.ajax({
				type: "POST",
				url: "/admin/bnrs/add-src-for-banner",
				data: {sources:sources, bnrid: id},
		}).success(function(data)
		{
				src = 1;
				if(cats && src)
					$("#update_banner").submit();
		});


});
*/
// >


var MakeSortable = function(ul) {
		$(ul).sortable({
				items:'li',
				axis:'y',
				cursor: 'move',
				update: function(event,ui) {
					var parent = $(ui.item[0].parentNode);
					var data = {};
					var order = 0;

					if(parent.hasClass('innerUl'))
					{
						parent.find('li').each(function(){
							data[$(this).attr('id')] = order;
							order++;
						});
					}
					else {
						$('.tree_cat>ul>li').each(function()
						{
							data[$(this).attr('id')] = order;
							order++;
						});
					}

					$.ajax({
							type: "POST",
							url: "/admin/categories/sorting-category",
							data: {data:data},
					}).success(function(data){

					});

				}
		});
};



var sorting = false;
$('.sortByName').on('click', function()
{
	if(sorting)
		return false;

	var sort = $(this).find('span').text().toLowerCase();

	sorting = true;
	$.ajax({
			type: "POST",
			url: "/admin/categories/sort",
			data: {sort:sort},
	}).done(function(data)
		{
			sorting = false;
			$('.outerUl').remove();
			$('.tree_cat').append(data);
			setTimeout(function(){
				MakeSortable('.outerUl');
				MakeSortable('.innerUl');
			},100);
		});
});

$('.add-cat-for-sources').on('click', function(e){

		e.preventDefault();

		var id = $(".id_m").val()


		if(!id)
		{
			$("#update_sources").submit();
			return;
		}

		var categories = {};
		categories[0] = id;
		$(".cat_for_banner:checked").each(function(){
			 categories[$(this).attr('value')] = $(this).val();
		});

		$.ajax({
				type: "POST",
				url: "/admin/sources/add-cat-for-sources",
				data: {categories:categories},
		}).success(function(data)
			{
					//console.log(data);
					$("#update_sources").submit();
			});
});
//>



// <<< All for category

		$(document).ready(function(){
				$('.tree_cat > ul').first().css("padding", "0");
				hoverStart();
		});

		var firstPlus = '<span class="main_cat"><span class="glyphicon glyphicon-plus gl-plus-first" onClick="addMainInput()"></span></span>';


		// Visible buttons plus and trash
		function hoverStart()
		{
				var $hoverLi = $( ".tree_cat>ul>li" );
				$hoverLi.hover(
				  function() {
							var id = $(this).attr('id');
							$('.activeButtons').hide();
							$('#buttom_plus_trash_' + id).show();
				  }, function() {
						$('.activeButtons').hide();
				  }
				);

				var $hoverLi = $( ".innerUl div" );
				$hoverLi.hover(
				  function() {
							var id = $(this).attr('id');

							$('.activeButtons').hide();
							$('#buttom_plus_trash_' + id).show();
				  }
				);
		}


		function addFormInput(id, name) {
			if(!name)
				name = '';

			$("#cat_id").val(0);
			$("#parent_cat").val(id);
			$("#cat_name").val(name);
			$("#cat_title, #cat_keywords, #cat_description, #cat_text_above").val('');
			modalJS.showModal();
		}

		// Add input for add new category
		var sending = false;
		function editCategoryForm(id, parent_id)
		{
			if(sending)
				return false;

				if(!parent_id)
					parent_id = 0;

				sending = true;
				$.ajax({
						type: "POST",
						url: "/admin/categories/get-all-info",
						data: {id:id},
						dataType : 'json',
				}).success(function(data){
					if(data)
					{
						$("#cat_name").val(data.category);
						$("#cat_title").val(data.title);
						$("#cat_id").val(data.id);
						$("#cat_keywords").val(data.meta_description);
						$("#cat_description").val(data.meta_keywords);
						$("#cat_text_above").val(data.text_above_content);
						$("#parent_cat").val(parent_id);
						modalJS.showModal();
					}
					sending = false;
				});
		}


		// Add input for main category
		function addMainInput()
		{
				/*
				$('.main_cat').append(
						'<form id="main_cat_mainform" onsubmit="addFirstCategory();return false;">' +
							'<input type="text" id="t0" class="form-control tree_cat_inp" required="required" />' +
							'<input type="submit" class="btn btn-primary tree_cat_sub" value="add" />' +
						'</form>'
				);

				$(document).on('mouseup.maininput', function (e) {

					var container = $("#main_cat_mainform");

					if (container.has(e.target).length === 0){
						container.remove();
					}

					$(document).off('mouseup.maininput');
				});
				*/

		}

		var firstForm = '<form id="main_cat_mainform2" onsubmit="addFirstCategory();return false;">\
											 <input type="text" id="t0" class="form-control tree_cat_inp" required="required" placeholder="Add new cathegory" />\
										</form>';

		function toggleInnerCathegory(elem)
		{
				var id = $(elem).attr('data');
				var li = $("#"+id);
				if(li.hasClass('activeList'))
				{
					li.removeClass('activeList');
					li.find('.triangle').removeClass('down').addClass('left');
					li.find('ul').addClass('hidden');
				}
				else
				{
					li.addClass('activeList');
					li.find('.triangle').addClass('down').removeClass('left');
					li.find('ul').removeClass('hidden');
				}
		}

		// Additionaly for ajax
		function additionalyForAjax(data)
		{
				$('.tree_cat').html(firstForm+	data);
				$('.toggleInnerLi>.main>.list_elem_title').on('click', function(){
					toggleInnerCathegory(this);
				});
				hoverStart();
		}

		$('.toggleInnerLi>.main>.list_elem_title').on('click', function(){
			toggleInnerCathegory(this);
		});


		function addFirstCategory()
		{
				var nameCat = $('#t0').val();
				addFormInput(0, nameCat);

		}


		// Delete category
		function deleteCategory(id)
		{
				if(!confirm('You really want to delete cathegory?'))
				{
					return false;
				}
				else {
					$.ajax({
							type: "POST",
							url: "/admin/categories/delete-category",
							data: {id:id},
					}).success(function(data){
								additionalyForAjax(data)
					});
				}


		}


// < Add inputs

var total = 0;
function add_new_image(){
    total++;
    $('<tr>')
    .attr('id','tr_image_'+total)
    .css({lineHeight:'20px'})
    .append (
        $('<td>')
        .attr('id','td_title_'+total)
        .css({paddingRight:'5px',width:'200px'})
        .append(
            $('<input type="text" />')
            .css({width:'200px'})
            .attr('id','input_title_'+total)
            .attr('name','input_title_'+total)
            .attr('class','ln form-control')
        )

  )
  .append (
      $('<td>')
        .css({width:'60px'})
        .append (
            $('<span id="progress_'+total+'" class="padding5px"><a  onclick="$(\'#tr_image_'+total+'\').remove();" class="ico_delete"><img src="/web/uploads/others/delete.png" alt="del" border="0"></a></span>')
      )
  )
  .appendTo('#table_container');
}



// >



// < Uploads images for article

var $ = jQuery.noConflict();

$(document).ready(function() {
	// В dataTransfer помещаются изображения которые перетащили в область div
	jQuery.event.props.push('dataTransfer');

	// Максимальное количество загружаемых изображений за одни раз
	var maxFiles = 20;

	// Оповещение по умолчанию
	var errMessage = 0;

	// Кнопка выбора файлов
	var defaultUploadBtn = $('#uploadbtn');

	// Массив для всех изображений
	var dataArray = [];

	// Область информер о загруженных изображениях - скрыта
	$('#uploaded-files').hide();

	// Метод при падении файла в зону загрузки
	$('#drop-files').on('drop', function(e) {
		// Передаем в files все полученные изображения
		var files = e.dataTransfer.files;
		// Проверяем на максимальное количество файлов
		if (files.length <= maxFiles) {
			// Передаем массив с файлами в функцию загрузки на предпросмотр
			loadInView(files);
		} else {
			alert('You can not upload more then '+ maxFiles+' images!');
			files.length = 0; return;
		}
	});

	// При нажатии на кнопку выбора файлов
	defaultUploadBtn.on('change', function() {
   		// Заполняем массив выбранными изображениями
   		var files = $(this)[0].files;
   		// Проверяем на максимальное количество файлов
		if (files.length <= maxFiles) {
			// Передаем массив с файлами в функцию загрузки на предпросмотр
			loadInView(files);
			// Очищаем инпут файл путем сброса формы
            $('#frm').each(function(){
	        	    this.reset();
			});
		} else {
			alert('You can not upload more then '+maxFiles+' images!');
			files.length = 0;
		}
	});

	// Функция загрузки изображений на предросмотр
	function loadInView(files) {
		// Показываем обасть предпросмотра
		$('#uploaded-holder').show();

		// Для каждого файла
		$.each(files, function(index, file) {

			// Несколько оповещений при попытке загрузить не изображение
			if (!files[index].type.match('image.*')) {

				if(errMessage == 0) {
					$('#drop-files p').html('Only image');
					++errMessage
				}
				else if(errMessage == 1) {
					$('#drop-files p').html('Only image');
					++errMessage
				}
				else if(errMessage == 2) {
					$('#drop-files p').html("Only image");
					++errMessage
				}
				else if(errMessage == 3) {
					$('#drop-files p').html("Only image");
					errMessage = 0;
				}
				return false;
			}

			// Проверяем количество загружаемых элементов
			if((dataArray.length+files.length) <= maxFiles) {
				// показываем область с кнопками
				$('#upload-button').css({'display' : 'block'});
			}
			else { alert('You can not upload more then '+maxFiles+' images!'); return; }

			// Создаем новый экземпляра FileReader
			var fileReader = new FileReader();
				// Инициируем функцию FileReader
				fileReader.onload = (function(file) {

					return function(e) {
						// Помещаем URI изображения в массив
						dataArray.push({name : file.name, value : this.result});
						addImage((dataArray.length-1));
					};

				})(files[index]);
			// Производим чтение картинки по URI
			fileReader.readAsDataURL(file);
		});
		return false;
	}

	// Процедура добавления эскизов на страницу
	function addImage(ind) {
		// Если индекс отрицательный значит выводим весь массив изображений
		if (ind < 0 ) {
		start = 0; end = dataArray.length;
		} else {
		// иначе только определенное изображение
		start = ind; end = ind+1; }
		// Оповещения о загруженных файлах
		if(dataArray.length == 0) {
			// Если пустой массив скрываем кнопки и всю область
			$('#upload-button').hide();
			//$('#uploaded-holder').hide();
		} else if (dataArray.length == 1) {
			$('#upload-button span').html("One file has been selected ");
		} else {
			$('#upload-button span').html(dataArray.length+" files were selected");
		}
		// Цикл для каждого элемента массива
		for (i = start; i < end; i++) {
			// размещаем загруженные изображения
			if($('#dropped-files > .image').length <= maxFiles) {
				$('#dropped-files').append('<div id="img-'+i+'" class="image" style="background: url('+dataArray[i].value+'); background-size: cover;"> <a href="#" id="drop-'+i+'" class="drop-button">Delete image</a></div>');
			}
		}
		return false;
	}

	// Функция удаления всех изображений
	function restartFiles() {

		// Установим бар загрузки в значение по умолчанию
		$('#loading-bar .loading-color').css({'width' : '0%'});
		$('#loading').css({'display' : 'none'});
		$('#loading-content').html(' ');

		// Удаляем все изображения на странице и скрываем кнопки
		$('#upload-button').hide();
		$('#dropped-files > .image').remove();
		$('#uploaded-holder').hide();

		// Очищаем массив
		dataArray.length = 0;

		return false;
	}

	// Удаление только выбранного изображения
	$("#dropped-files").on("click","a[id^='drop']", function() {
		// получаем название id
 		var elid = $(this).attr('id');
		// создаем массив для разделенных строк
		var temp = new Array();
		// делим строку id на 2 части
		temp = elid.split('-');
		// получаем значение после тире тоесть индекс изображения в массиве
		dataArray.splice(temp[1],1);
		// Удаляем старые эскизы
		$('#dropped-files > .image').remove();
		// Обновляем эскизи в соответсвии с обновленным массивом
		addImage(-1);
	});

	// Удалить все изображения кнопка
	$('#dropped-files #upload-button .delete').click(restartFiles);

	// Загрузка изображений на сервер
	$('#upload-button .upload').click(function() {

		// Показываем прогресс бар
		$("#loading").show();
		// переменные для работы прогресс бара
		var totalPercent = 100 / dataArray.length;
		var x = 0;
    var url = $(this).attr('href');


		$('#loading-content').html('Upload '+dataArray[0].name);
		// Для каждого файла
		$.each(dataArray, function(index, file) {
			// загружаем страницу и передаем значения, используя HTTP POST запрос


        //console.log(url);
			$.post(url, dataArray[index], function(data) {
        //console.log(data);return false;

				var fileName = dataArray[index].name;
				++x;
				// Изменение бара загрузки
				$('#loading-bar .loading-color').css({'width' : totalPercent*(x)+'%'});
				// Если загрузка закончилась
				if(totalPercent*(x) == 100) {
					// Загрузка завершена
					$('#loading-content').html('Loading is complete!');

					// Вызываем функцию удаления всех изображений после задержки 1 секунда
					setTimeout(restartFiles, 1000);
				// если еще продолжается загрузка
				} else if(totalPercent*(x) < 100) {
					// Какой файл загружается
					$('#loading-content').html('Loading '+fileName);
				}

				// Формируем в виде списка все загруженные изображения
				// data формируется в upload.php
				var dataSplit = data.split(':');
				if(dataSplit[1] == 'loaded successfully') {
					$('#uploaded-files').append('<li><a href="images/'+dataSplit[0]+'">'+fileName+'</a> loaded successfully</li>');

				} else {
					$('#uploaded-files').append('<li><a href="images/'+data+'. File name: '+dataArray[index].name+'</li>');
				}

			});
		});
		return false;
	});

	// Простые стили для области перетаскивания
	$('#drop-files').on('dragenter', function() {
		$(this).css({'box-shadow' : 'inset 0px 0px 20px rgba(0, 0, 0, 0.1)', 'border' : '4px dashed #bb2b2b'});
		return false;
	});

	$('#drop-files').on('drop', function() {
		$(this).css({'box-shadow' : 'none', 'border' : '4px dashed rgba(0,0,0,0.2)'});
		return false;
	});
});

$(document).ready(function() {
	modalJS.init();

  $('.form-site_url').blur(function(){
		console.log(this.value);

		var patt = new RegExp("http(s)?://www.youtube.com/user/([^/]*)");
		var res = patt.exec(this.value);
		if (res && res[2])
			$('.form-feed_url').val('http://www.youtube.com/feeds/videos.xml?user='+res[2]);
	});


	MakeSortable('.outerUl');
	MakeSortable('.innerUl');

	$(".chosen-select").chosen();

	$('.select-btn').click(function(){
			var id = $(this).attr('data-id');
	    $('#' + id + ' option').prop('selected', true);
	    $('#' + id).trigger('chosen:updated').trigger('change');
	});

	$('.deselect-btn').click(function(){
			var id = $(this).attr('data-id');
	    $('#' + id + ' option').prop('selected', false);
	    $('#' + id).trigger('chosen:updated').trigger('change');
	});

});
