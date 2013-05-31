<?php

respond( function( $request, $response, $app ) {
	PSU::session_start();

	$GLOBALS['BASE_URL'] = $app->config->get( 'bill-video-tutorials', 'base_url' );

	$GLOBALS['TITLE'] = 'Student Bill and Financial Aid Video Tutorials';
	$GLOBALS['TEMPLATES'] = PSU_BASE_DIR . '/app/bill-video-tutorials/templates';

	if( file_exists( PSU_BASE_DIR . '/debug/bill-video-tutorials-debug.php' ) ) {
		include PSU_BASE_DIR . '/debug/bill-video-tutorials-debug.php';
	}

	IDMObject::authN();

	$response->denied = function() use ( $app ) {
		$app->tpl->display( 'access-denied.tpl' );

		// Is it ok to die here, or do we need a way to skip
		// future routes? (For example, if there is a final cleanup
		// routine.)
		die();
	};

	$app->tpl = new \PSU\Template;
});

//
// Nothing specific requested; show list of gatesystems
//
respond( 'GET', '/', function( $request, $response, $app ) {
	$app->tpl->display( 'index.tpl' );
});
