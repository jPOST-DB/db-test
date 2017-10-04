<?php

require_once( __DIR__ . '/classes/entity/TableInfo.php' );
require_once( __DIR__ . '/classes/entity/ColumnInfo.php' );
require_once( __DIR__ . '/classes/entity/DataList.php' );
require_once( __DIR__ . '/classes/Sparql.php' );
require_once( __DIR__ . '/classes/PageTools.php' );

$method = $_REQUEST[ 'method' ];
$name = $_REQUEST[ 'name' ];
$category = PageTools::getParameter( 'category' );

$result = null;

if( $method == 'table' ) {
	$result = new TableInfo();
	$result->setName( 'peptide' );
	$result->setTitle( 'Peptide' );
	$result->setUrl( basename( __FILE__ ) );

	$column = new ColumnInfo();
	$column->setName( 'psm_id' );
	$column->setTitle( 'Psm ID' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 100 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'psm_label' );
	$column->setTitle( 'Sequence' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 250 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'mascot_ev' );
	$column->setTitle( 'Mascot Expected Value' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 100 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'mascot_score' );
	$column->setTitle( 'Mascot Score' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 100 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'jpost_ev' );
	$column->setTitle( 'jPOST Expected Value' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 100 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'jpost_ev' );
	$column->setTitle( 'jPOST Expected Value' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 100 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'charge' );
	$column->setTitle( 'Charge' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 75 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'cal_mass' );
	$column->setTitle( 'Calculated Mass' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 100 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'exp_mass' );
	$column->setTitle( 'Experimental Mass' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 100 );
	$result->addColumn( $column );
}
else if( $method == 'list' ) {
	$draw = $_REQUEST[ 'draw' ];

	$result = new DataList();
	$result->setDrawNumber( intval( $draw ) );

	$params = array();
	$params[ 'columns' ] = 'count( distinct ?psm ) as ?count';
	PageTools::setFilterInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );
	$result->setRecordsTotal( intval( $sparqlResult[ 0 ][ 'count' ] ) );
	$result->setRecordsFiltered( intval( $sparqlResult[ 0 ][ 'count' ] ) );


	$params[ 'columns' ] = 'distinct ?psm ?psm_id ?psm_label ?mascot_ev ?mascot_score ?jpost_ev ?charge ?cal_mass ?exp_mass';
	PageTools::setPageInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	foreach( $sparqlResult as $row ) {
		$result->addData( $row );
	}
}


echo json_encode( $result );

?>

