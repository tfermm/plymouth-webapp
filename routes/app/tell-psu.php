<?php

/**
 * Uncomment once object structure has been written
 * use \PSU\TellPSU;
 */

respond( function( $request, $response, $app ) {
	PSU::session_start();

	// Base directory of application
	$GLOBALS['BASE_DIR'] = dirname(__FILE__);

	// Base URL
	$GLOBALS['BASE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].'/app/tell-psu';

	// Base URL
	$GLOBALS['WEBAPP_URL'] = 'https://'.$_SERVER['HTTP_HOST'].'/webapp';
	//$GLOBALS['BASE_URL'] = $app->config->get( 'tell-psu', 'base_url' );

	$GLOBALS['TITLE'] = 'Tell PSU';
	$GLOBALS['TEMPLATES'] = PSU_BASE_DIR . '/app/tell-psu/templates';

	if( file_exists( PSU_BASE_DIR . '/debug/tell-psu-debug.php' ) ) {
		include PSU_BASE_DIR . '/debug/tell-psu-debug.php';
	}

	IDMObject::authN();

	if( IDMObject::authZ('permission', 'mis') || IDMObject::authZ('permission', 'tell_psu') ) {
		$app->admin = true;
		//die('You do not have access to this application. If you believe that this is in error, please contact the helpdesk at 535-2929 and explain that you are requesting access to administer "tell-psu".');
	}

	$response->denied = function() use ( $app ) {
		$app->tpl->display( 'access-denied.tpl' );

		// Is it ok to die here, or do we need a way to skip
		// future routes? (For example, if there is a final cleanup
		// routine.)
		die();
	};

	$app->tpl = new \PSU\Template;
	//$app->tpl->channel();
	$app->tpl->channel(array(
		'channel_callback' => 'tellPSU.echo',
	));
	if(!$_GET['channel_id']){
		$_GET['channel_id'] = 1;
	}//end if
	$app->user = PSUPerson::get( $_SESSION['wp_id'] ); 
	$app->tp = new PSU\TellPSU( $app->user->wp_id );

	/**
	 * Not all apps need this cool breadcrumb
	 * functionality, so delete it if you aren't going to 
	 * use it. If you are, then uncomment it.
	 *
	 * $app->breadcrumbs = new \PSU\Template\Breadcrumbs;
	 * $app->breadcrumbs->push( new \PSU\Template\Breadcrumb( 'Home', $app->config->get( '%CUSTDIR', 'base_url' ) . '/' ) );
	 */

	$app->tpl->assign( 'user', $app->user );
	$app->tpl->assign( 'admin', $app->admin );
	$app->tpl->assign( 'back_url', $_SERVER['HTTP_REFERER'] );
});

//
// Nothing specific requested; show list of gatesystems
//
respond( 'GET', '/', function( $request, $response, $app ) {
	//PSU::dbug( $app->user->portal_roles);
	//PSU::db('myplymouth')->debug = true;
	foreach( $app->tp->questions() as $question) {
		//var_dump( $question->user_response( $app->user->wp_id ) );
		foreach( $question->responses() as $response ) {
		}//end foerach
	}//end foreach
	$app->tpl->assign( 'questions', $app->tp->questions() );
	$app->tpl->display( 'index.tpl' );
});

//with( '/admininister', __DIR__ . '/tell-psu/administer.php' );
with( '/answer', __DIR__ . '/tell-psu/answer.php' );
