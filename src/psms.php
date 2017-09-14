<?php

require_once( __DIR__ . '/classes/entity/TableInfo.php' );
require_once( __DIR__ . '/classes/entity/ColumnInfo.php' );
require_once( __DIR__ . '/classes/entity/DataList.php' );
require_once( __DIR__ . '/classes/Sparql.php' );
require_once( __DIR__ . '/classes/PageTools.php' );

$method = $_REQUEST[ 'method' ];

$result = null;

if( $method == 'dataset' ) {
	$params = array();
	$params[ 'datasets' ] = PageTools::getFilterValues( $_REQUEST[ 'datasets'] );

	$sparqlResult = Sparql::callSparql( $params, 'datasets' );
	$datasets = '';
	foreach( $sparqlResult as $dataset ) {
		$datasets = $datasets . ' <' . $dataset[ 'dataset' ] . '>';
	}

	$params = array();
	$params[ 'columns' ] = 'distinct ?psm_id';
	$params[ 'datasets' ] = $datasets;
	PageTools::setFilterInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	$result = array();
	foreach( $sparqlResult as $psm ) {
		array_push( $result, $psm[ 'psm_id'] );
	}
}


echo json_encode( $result );

?>
