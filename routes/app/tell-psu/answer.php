<?php

/**
 * Show the user what they answered if they navigate here directly
 */
respond('GET','/[:question]', function( $request, $response, $app ) {
});

respond('POST','/[:question]', function( $request, $response, $app ) {
	
	\PSU::db('myplymouth')->debug = true;
	$app->tp->respond( $request->param('question'), $_POST['tp_response'] );
});
