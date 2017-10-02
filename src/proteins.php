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
	$result->setName( 'protein' );
	$result->setTitle( 'Protein' );
	$result->setUrl( basename( __FILE__ ) );

	$column = new ColumnInfo();
	$column->setName( 'checkbox' );
	$column->setTitle(  "<input type=\"checkbox\" id=\"check-protein-$name\" onchange=\"jPost.toggleCheckboxes('check-protein-$name')\">" );
	$column->setSortable( false );
	$column->setSearchable( false );
	$column->setAlign( 'center' );
	$column->setWidth( 50 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'full_name' );
	$column->setTitle( 'Full Name' );
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
	$column->setName( 'length' );
	$column->setTitle( 'Length' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'right' );
	$column->setWidth( 150 );
	$result->addColumn( $column );
}
else if( $method == 'list' ) {
	$draw = $_REQUEST[ 'draw' ];

	$result = new DataList();
	$result->setDrawNumber( intval( $draw ) );

	$params = array();
	$params[ 'columns' ] = 'count( distinct ?mnemonic ) as ?count';

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

	$params[ 'columns' ] = 'distinct ?protein ?full_name ?mnemonic strlen( ?sequence ) as ?length ';
	PageTools::setPageInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	foreach( $sparqlResult as $row ) {
		$mnemonic = $row[ 'mnemonic' ];
		$fullName = $row[ 'full_name' ];
		$protein = $row[ 'protein' ];
		$proteinId = end( explode( '/', $protein ) );

		$row[ 'checkbox' ] = "<input type=\"checkbox\" class=\"check-protein-$name\" name=\"protein[]\" value=\"$proteinId\">";
		$row[ 'full_name' ] = "<a href=\"javascript:jPost.openProtein( '$proteinId', '$category'  )\">$fullName</a>";
		$row[ 'mnemonic' ] = "<a href=\"$protein\" target=\"_blank\">$mnemonic</a>";

		$result->addData( $row );
	}
}


echo json_encode( $result );



?>