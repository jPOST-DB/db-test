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
	$column->setName( 'peptide_id' );
	$column->setTitle( 'Peptide ID' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 150 );
	$result->addColumn( $column );

	if( $category != '<dataset>' ) {
		$column = new ColumnInfo();
		$column->setName( 'dataset_id' );
		$column->setTitle( 'Dataset ID' );
		$column->setSortable( true );
		$column->setSearchable( true );
		$column->setAlign( 'left' );
		$column->setWidth( 150 );
		$result->addColumn( $column );
	}

	if( $category != '<protein>') {
		$column = new ColumnInfo();
		$column->setName( 'full_name' );
		$column->setTitle( 'Protein Name' );
		$column->setSortable( true );
		$column->setSearchable( true );
		$column->setAlign( 'left' );
		$column->setWidth( 250 );
		$result->addColumn( $column );

		$column = new ColumnInfo();
		$column->setName( 'mnemonic' );
		$column->setTitle( 'ID' );
		$column->setSortable( true );
		$column->setSearchable( true );
		$column->setAlign( 'left' );
		$column->setWidth( 150 );
		$result->addColumn( $column );

		$column = new ColumnInfo();
		$column->setName( 'protein_id' );
		$column->setTitle( 'Accession' );
		$column->setSortable( true );
		$column->setSearchable( true );
		$column->setAlign( 'left' );
		$column->setWidth( 150 );
		$result->addColumn( $column );
	}

	$column = new ColumnInfo();
	$column->setName( 'peptide_label' );
	$column->setTitle( 'Sequence' );
	$column->setSortable( true );
	$column->setSearchable( true );
	$column->setAlign( 'left' );
	$column->setWidth( 200 );
	$result->addColumn( $column );
}
else if( $method == 'list' ) {
	$draw = $_REQUEST[ 'draw' ];

	$result = new DataList();
	$result->setDrawNumber( intval( $draw ) );

	$params = array();
	$params[ 'columns' ] = '( count( distinct ?peptide ) as ?count )';
	PageTools::setFilterInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );
	$result->setRecordsTotal( intval( $sparqlResult[ 0 ][ 'count' ] ) );
	$result->setRecordsFiltered( intval( $sparqlResult[ 0 ][ 'count' ] ) );


	$params[ 'columns' ] = 'distinct ?dataset_id ?protein ?peptide ?peptide_id ?full_name ?mnemonic ?peptide_label ';
	PageTools::setPageInfo( $params );

	$sparqlResult = Sparql::callSparql( $params, 'filter' );

	foreach( $sparqlResult as $row ) {
		$datasetId = $row[ 'dataset_id' ];
		$fullName = $row[ 'full_name' ];
		$protein = $row[ 'protein' ];
		$proteinId = end( explode( '/', $protein ) );
		$peptideId = $row[ 'peptide_id' ];

		$row[ 'peptide_id' ] = "<a href=\"javascript:jPost.openPeptide( '$peptideId', '$category' )\">$peptideId</a>";
		$row[ 'dataset_id' ] = "<a href=\"javascript:jPost.openDataset( '$datasetId', '$category' )\">$datasetId</a>";
		$row[ 'full_name' ] = "<a href=\"javascript:jPost.openProtein( '$proteinId', '$category'  )\">$fullName</a>";
		$row[ 'protein_id' ] = "<a href=\"$protein\" target=\"_blank\">$proteinId</a>";
		$result->addData( $row );
	}
}


echo json_encode( $result );


?>
