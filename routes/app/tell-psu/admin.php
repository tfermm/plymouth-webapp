<?php

respond( 'GET', '/?', function( $request, $response, $app ) {
	$app->tpl->display( 'admin/index.tpl' );
});

respond( 'GET', '/view-answers/?', function( $request, $response, $app ) {
	$app->tpl->assign( 'questions', $app->tp->questions());
	$app->tpl->display( 'admin/view-answers.tpl' );
});
