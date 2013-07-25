<?php

//Catch all
respond( '[*]', function( $request, $response, $app ) {
 	PSU::session_start();

	$GLOBALS['BASE_DIR'] = __DIR__;
		
	$GLOBALS['BASE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].'/app/bill-status';
	 
	$GLOBALS['WEBAPP_URL'] = 'https://'.$_SERVER['HTTP_HOST'].'/webapp';
	$GLOBALS['TITLE'] = 'Bill Status';
	 
	$GLOBALS['TEMPLATES'] = PSU_BASE_DIR . '/app/bill-status/templates';
	// $GLOBALS['TEMPLATES'] = $GLOBALS['BASE_DIR'] . '/templates';
	 
	if( file_exists( $GLOBALS['BASE_DIR'] . '/debug.php' ) ) {
		include $GLOBALS['BASE_DIR'] . '/debug.php';
	}
	 
	IDMObject::authN();

 	// get the logged in user
 	$app->user = PSUPerson::get( $_SESSION['wp_id'] ); 
  
 	// initialize the template
 	$app->tpl = new PSUTemplate;

	$app->tpl->channel();

	if(!$_GET['channel_id']){
		$_GET['channel_id'] = 1;
	}//end if 
 
  
 	// creating the Bill Status object

	$app->bs = $app->user->bill->bill_status;

 	// assign user to template
 	$app->tpl->assign('status', $app->bs->status);
 	$app->tpl->assign('user', $app->user);
 	$app->tpl->assign('base_url', $GLOBALS['BASE_URL']);

 	$app->tpl->display('index.tpl');
});

