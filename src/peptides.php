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
	$column->setName( 'full_name' );
	$column->setTitle( 'Protein Name' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 300 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'mnemonic' );
	$column->setTitle( 'Mnemonic' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 150 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'peptide_label' );
	$column->setTitle( 'Sequence' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 350 );
	$result->addColumn( $column );
}
else if( $method == 'list' ) {
	$draw = $_REQUEST[ 'draw' ];

	$result = new DataList();
	$result->setDrawNumber( intval( $draw ) );

	$params = array();
	$params[ 'columns' ] = 'count( distinct ?peptide ) as ?count';

	if( $category == null || $category == '' ) {
		$sparqlResult = Sparql::callSparql( $params, 'filter' );
		$result->setRecordsTotal( intval( $sparqlResult[ 0 ][ 'count' ] ) );
	}

	PageTools::setFilterInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );
	$result->setRecordsFiltered( intval( $sparqlResult[ 0 ][ 'count' ] ) );
	if( $category != null && $category != '' ) {
		$result->setRecordsTotal( intval( $sparqlResult[ 0 ][ 'count' ] ) );
	}

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	$params[ 'columns' ] = 'distinct ?peptide ?full_name ?mnemonic ?peptide_label  ';
	PageTools::setPageInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	foreach( $sparqlResult as $row ) {
		$mnemonic = $row[ 'mnemonic' ];
		$result->addData( $row );
	}
}


echo json_encode( $result );


?>
