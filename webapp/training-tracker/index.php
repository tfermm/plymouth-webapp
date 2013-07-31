<?php

if( file_exists( 'dev-environment.php' ) ) {
	include 'dev-environment.php';
}

require_once 'autoload.php';

PSU::session_start(); // force ssl + start a session

if ( ! $GLOBALS['BASE_URL'] ){
	$GLOBALS['BASE_URL'] = '/webapp/training-tracker';
}

$GLOBALS['BASE_DIR'] = __DIR__;
$GLOBALS['TITLE'] = 'Training Tracker';
$GLOBALS['TEMPLATES'] = $GLOBALS['BASE_DIR'] . '/templates';

if( file_exists( $GLOBALS['BASE_DIR'] . '/debug.php' ) ) {
	include $GLOBALS['BASE_DIR'] . '/debug.php';
}

includes_psu_register( 'TrainingTracker', $GLOBALS['BASE_DIR'] . '/includes' );

require_once 'klein/klein.php';

require_once $GLOBALS['BASE_DIR'] . '/includes/TrainingTrackerAPI.class.php';

IDMObject::authN();

/**
 * Routing provided by klein.php (https://github.com/chriso/klein.php)
 * Make some objects available elsewhere.
 */

//Catch all
respond( function( $request, $response, $app ) {
	// get the logged in user

	$app->user = PSUPerson::get( $_SESSION['wp_id'] ); 

	if(IDMObject::authZ('role', 'training_tracker')) {
		$is_valid = true;
	}
	else{
		die("You do not have access to this application.");
	}

	$staff_collection = new TrainingTracker\StaffCollection();
	$staff_collection->load(); 

	$is_mentor = false;
	$is_admin = false;

	$teams_data = TrainingTracker::get_teams();

	$has_team = false;
	$wpid = $app->user->wpid;
	if (isset($teams_data["$wpid"])){
		$has_team = true;
	}

	if(IDMObject::authZ('permission', 'training_tracker_admin')) {
		$is_admin = true;
	}
	if(IDMObject::authZ('permission', 'training_tracker_mentor')) {
		$is_mentor = true;
	}

	$active_user = $staff_collection->get($wpid);

	$app->is_admin = $is_admin;
	$app->is_mentor = $is_mentor;
	$app->staff_collection = $staff_collection;
	$app->active_user = $active_user;

	// initialize the template
	$app->tpl = new PSUTemplate;

	// assign user to template
	$app->tpl->assign('active_user', $active_user);
	$app->tpl->assign('user', $app->user);
	$app->tpl->assign('base_url', $GLOBALS['BASE_URL']);
	$app->tpl->assign('has_team', $has_team);
	$app->tpl->assign('wpid', $wpid);
	$app->tpl->assign('is_admin', $is_admin);
	$app->tpl->assign('is_mentor', $is_mentor);
});

// the person select page
respond( '/?', function( $request, $response, $app ) {
	if ($app->is_mentor){
		$staff = $app->staff_collection;
	}
	else{
		$person = $app->active_user;
		$staff[0] = $person;
	}

	foreach ($staff as $person){
		$pidm = $person->pidm;
		
		$person->merit = TrainingTracker::merit_get($pidm);
		$person->demerit = TrainingTracker::demerit_get($pidm);
		$type = TrainingTracker::checklist_type($person->privileges);
		if (!TrainingTracker::checklist_exists($pidm, $type, 0)){
			//get tybe based off of a persons privileges
			$type = TrainingTracker::checklist_type($person->privileges);
			//insert new checklist (pidm, type)
			TrainingTracker::checklist_insert($pidm, $type);
		}
	}
	$app->tpl->assign('staff', $staff);
	$app->tpl->display('index.tpl');
});

$app_routes = array(
	 'staff', 
	 'team' 
);

foreach( $app_routes as $base ) {
	with( "/{$base}", $GLOBALS['BASE_DIR'] . "/routes/{$base}.php" );
}//end foreach

dispatch( $_SERVER['PATH_INFO'] );
