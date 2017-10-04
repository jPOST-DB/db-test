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
	$result->setName( 'pep_position' );
	$result->setTitle( 'Peptide Position' );
	$result->setUrl( basename( __FILE__ ) );

	$column = new ColumnInfo();
	$column->setName( 'peptide_begin' );
	$column->setTitle( 'Begin' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 80 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'peptide_end' );
	$column->setTitle( 'End' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 80 );
	$result->addColumn( $column );
}
else if( $method == 'list' ) {
	$draw = $_REQUEST[ 'draw' ];

	$result = new DataList();
	$result->setDrawNumber( intval( $draw ) );

	$params = array();
	$params[ 'columns' ] = 'count( distinct ?peptide_location ) as ?count';
	PageTools::setFilterInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );
	$result->setRecordsTotal( intval( $sparqlResult[ 0 ][ 'count' ] ) );
	$result->setRecordsFiltered( intval( $sparqlResult[ 0 ][ 'count' ] ) );


	$params[ 'columns' ] = 'distinct ?peptide_location ?peptide_begin ?peptide_end ';
	PageTools::setPageInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	foreach( $sparqlResult as $row ) {
		$result->addData( $row );
	}
}

echo json_encode( $result );


?>
