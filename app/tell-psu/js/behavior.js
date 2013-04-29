$(function() {
	$('#tp-accordion').accordion({
		heightStyle: "auto",
		icons: false,
		animated: false,
	});
	tellPSU.init('tell-psu');
});
var tellPSU = {
	init: function(channel_id) {
		$('.tpq-form').submit(function(){
			var response = $('input[name=tp_response]:checked', this).val();
			$.my.channelFetch($(this).attr('action') + response, channel_id);
			return false;
		});
	},
	echo: function( text_to_display, channel_id )
	{
		$('#'+channel_id).html(text_to_display);
		tellPSU.init(channel_id);
	}
};
