<?php

require_once( __DIR__ . '/conf/config.php' );
require_once( __DIR__ . '/classes/PageTools.php' );
require_once( __DIR__ . '/libs/smarty/Smarty.class.php' );

$sparqlParams = array();
PageTools::setFilterInfo( $sparqlParams );
$sparqlParams[ 'columns' ] = 'distinct ?protein ?full_name ?mnemonic ?sequence ?mass';

$slice = PageTools::getParameter( 'slice' );
if( $slice == null ) {
	$slice = '<details>';
}


$result = Sparql::callSparql( $sparqlParams, 'filter' );

$params = array(
	'slice' => $slice
);

foreach( $result as $row) {
	foreach( $row as $key => $value ) {
		$params[ $key ] = $value;
	}
}
if( array_key_exists( 'protein', $params ) ) {
	$params[ 'protein_id' ] = end( explode( '/', $params[ 'protein' ] ) );
}

$dataset = PageTools::getParameter( 'dataset' );
if( $dataset != null && $dataset != '' ) {
	$params[ 'dataset' ] = $dataset;
}

$html = PageTools::getHtml( $params, 'protein' );
echo $html;

?>
