<?php

require_once( __DIR__ . '/conf/config.php' );
require_once( __DIR__ . '/classes/PageTools.php' );
require_once( __DIR__ . '/libs/smarty/Smarty.class.php' );

$sparqlParams = array();
PageTools::setFilterInfo( $sparqlParams );
$sparqlParams[ 'columns' ] = 'distinct ?protein ?full_name ?mnemonic ?sequence ?mass';
$result = Sparql::callSparql( $sparqlParams, 'filter' );

$params = array();
foreach( $result as $row) {
	foreach( $row as $key => $value ) {
		$params[ $key ] = $value;
	}
}
if( array_key_exists( 'protein', $params ) ) {
	$params[ 'protein_id' ] = end( explode( '/', $params[ 'protein' ] ) );
}

$sparqlParams[ 'columns' ] = 'distinct ?dataset_id ?dataset';
$result = Sparql::callSparql( $sparqlParams, 'filter' );
$datasets = '';
foreach( $result as $row ) {
	$datasets .= ' ' . $row[ 'dataset_id' ];
}
$params[ 'datasets' ] = $datasets;


$html = PageTools::getHtml( $params, 'protein' );
echo $html;

?>
