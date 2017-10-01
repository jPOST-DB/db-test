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
	$result->setName( 'dataset' );
	$result->setTitle( 'DataSet' );
	$result->setUrl( basename( __FILE__ ) );

	$column = new ColumnInfo();
	$column->setName( 'checkbox' );
	$column->setTitle(  "<input type=\"checkbox\" id=\"check-dataset-$name\" onchange=\"jPost.toggleCheckboxes('check-dataset-$name')\">" );
	$column->setSortable( false );
	$column->setSearchable( false );
	$column->setAlign( 'center' );
	$column->setWidth( 50 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'dataset_id' );
	$column->setTitle( 'ID' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 150 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'project_id' );
	$column->setTitle( 'Project ID' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 150 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'project_title' );
	$column->setTitle( 'Project Title' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 200 );
	$result->addColumn( $column );

	$column = new ColumnInfo();
	$column->setName( 'project_date' );
	$column->setTitle( 'Project Date' );
	$column->setSortable( true );
	$column->setSearchable( false );
	$column->setAlign( 'left' );
	$column->setWidth( 100 );
	$result->addColumn( $column );
}
else if( $method == 'list' ) {
	$draw = $_REQUEST[ 'draw' ];

	$result = new DataList();
	$result->setDrawNumber( intval( $draw ) );

	$params = array();
	$params[ 'columns' ] = 'count( distinct ?dataset ) as ?count';

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

	$params[ 'columns' ] = 'distinct ?dataset_id ?project_id ?project_title ?project_date';

	PageTools::setPageInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	foreach( $sparqlResult as $row ) {
		$datasetId = $row[ 'dataset_id' ];
		$row[ 'checkbox' ] = "<input type=\"checkbox\" class=\"check-dataset-$name\" name=\"dataset[]\" value=\"$datasetId\">";
		$row[ 'dataset_id' ] = "<a href=\"javascript:jPost.openDataset( '$datasetId', '$category' )\">$datasetId</a>";
		$result->addData( $row );
	}
}


echo json_encode( $result );



?>