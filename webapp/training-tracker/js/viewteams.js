$(document).on('click', '.delete', function(event){

	var $el = $(this.parentElement);
	var wpid = $el.data('wpid')
	var type = $el.data('type')
	postData = {type: type, wpid: wpid};

	$.ajax({
		type: 'POST',
		url: 'remove',
		data: { data: postData },
		async: true,
		dataType: 'json',
		success: function(data) {
			if (type == 'mentor'){
				$el.next('ul').empty();
				$el.remove();		
			}
			else{
				$el.remove();
			}
		}
	});
});
