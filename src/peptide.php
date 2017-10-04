<?php

require_once( __DIR__ . '/conf/config.php' );
require_once( __DIR__ . '/classes/PageTools.php' );
require_once( __DIR__ . '/libs/smarty/Smarty.class.php' );

$params = array();
PageTools::setFilterInfo( $params );
$params[ 'columns' ] = 'distinct ?dataset_id ?protein ?peptide ?peptide_id ?full_name ?mnemonic ?peptide_label ';
$result = Sparql::callSparql( $params, 'filter' );

$params = array();
foreach( $result as $row) {
	foreach( $row as $key => $value ) {
		$params[ $key ] = $value;
	}
	$params[ 'protein_id' ] = end( explode( '/', $row[ 'protein' ] ) );
}


$html = PageTools::getHtml( $params, 'peptide' );
echo $html;

?>

