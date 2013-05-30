<?php

/**
 * Uncomment once object structure has been written
 * use \PSU\BillVideoTutorials;
 */

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
	$app->user = PSUPerson::get( $_SESSION['wp_id'] ); 

	/**
	 * Not all apps need this cool breadcrumb
	 * functionality, so delete it if you aren't going to 
	 * use it. If you are, then uncomment it.
	 *
	 * $app->breadcrumbs = new \PSU\Template\Breadcrumbs;
	 * $app->breadcrumbs->push( new \PSU\Template\Breadcrumb( 'Home', $app->config->get( '%CUSTDIR', 'base_url' ) . '/' ) );
	 */

	$app->tpl->assign( 'user', $app->user );
	$app->tpl->assign( 'back_url', $_SERVER['HTTP_REFERER'] );
});

//
// Nothing specific requested; show list of gatesystems
//
respond( 'GET', '/', function( $request, $response, $app ) {
	$app->tpl->display( 'index.tpl' );
});
