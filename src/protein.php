<?php

require_once( __DIR__ . '/conf/config.php' );
require_once( __DIR__ . '/classes/PageTools.php' );
require_once( __DIR__ . '/libs/smarty/Smarty.class.php' );

$params = array();
PageTools::setFilterInfo( $params );
$params[ 'columns' ] = 'distinct ?protein ?full_name ?mnemonic ?sequence ?mass';
$result = Sparql::callSparql( $params, 'filter' );

$params = array();
foreach( $result as $row) {
	foreach( $row as $key => $value ) {
		$params[ $key ] = $value;
	}
}

$html = PageTools::getHtml( $params, 'protein' );
echo $html;

?>
