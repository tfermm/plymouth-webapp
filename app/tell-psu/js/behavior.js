$(function() {
	$('#tp-accordion').accordion();
	tellPSU.init('tell-psu');
});

var tellPSU = {
	init: function(channel_id) {
		
		$('.tpq-form').submit(function(){
			var answer = $('input[name=tp_response]:checked', this).val();
			my.channelInit('#'+channel_id,$(this).attr('action')+'/answer/'+answer);
			return false;
		});
	},
	echo: function( text_to_display, channel_id ) {
		('#'+channel_id).html(text_to_display);
		tellPSU.init(channel_id);
	}
};
