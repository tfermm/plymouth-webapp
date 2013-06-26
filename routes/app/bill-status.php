<?php
/*  
if( file_exists( 'dev-environment.php' ) ) {
 	include 'dev-environment.php';
}
else{
 	require_once 'autoload.php';
 	PSU::session_start(); // force ssl + start a session
}
  
if ( ! $GLOBALS['BASE_URL'] ){
 	$GLOBALS['BASE_URL'] = '/webapp/bill-status';
} 
 */

// includes_psu_register( 'bill-status', $GLOBALS['BASE_DIR'] . '/includes' );

// require_once 'klein/klein.php';
// require_once 'includes/status.php';
// require_once 'includes/BillStatus.php';
 
 
/**
 * Routing provided by klein.php (https://github.com/chriso/klein.php)
 * Make some objects available elsewhere.
 */
  
//Catch all
respond( function( $request, $response, $app ) {

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
/*
	$app->tpl->channel(array(
		'channel_callback' => 'billStatus.echo',
	));
*/
	if(!$_GET['channel_id']){
		$_GET['channel_id'] = 1;
	}//end if 
 
 	// changing date format
  
 	// creating the Bill Status object

	$app->bs = $app->user->bill->bill_status;
	$app->bs->status['type'] = "WARNING";
	$app->bs->status['type'] = "PROTECTED";
	$app->bs->status['type'] = "ERROR";
 	// assign user to template
 	$app->tpl->assign('status', $app->bs->status);
 	$app->tpl->assign('user', $app->user);
 	$app->tpl->assign('base_url', $GLOBALS['BASE_URL']);

});
 
respond( '[*]', function( $request, $response, $app ) {
 	// display the template
 	$app->tpl->display('index.tpl');
});
/*
$app_routes = array(
);
 
foreach( $app_routes as $base ) {
 	with( "/{$base}", $GLOBALS['BASE_DIR'] . "/routes/{$base}.php" );
}//end foreach
  
dispatch( $_SERVER['PATH_INFO'] );
 */
