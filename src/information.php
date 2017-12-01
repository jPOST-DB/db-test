<?php

require_once( __DIR__ . '/classes/entity/PanelInfo.php' );

$type = $_REQUEST[ 'type' ];

$result = null;

if( $type == 'panels' ) {
	$result = array();

	$panel = new PanelInfo();
	$panel->setName( 'search' );
	$panel->setTitle( 'Search' );
	array_push( $result, $panel );

	$panel = new PanelInfo();
	$panel->setName( 'slices' );
	$panel->setTitle( 'Slices' );
	array_push( $result, $panel );

	$panel = new PanelInfo();
	$panel->setName( 'compare' );
	$panel->setTitle( 'Compare' );
	array_push( $result, $panel );
}

echo json_encode( $result );



?>
