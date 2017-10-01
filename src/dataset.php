<?php

require_once( __DIR__ . '/conf/config.php' );
require_once( __DIR__ . '/classes/PageTools.php' );
require_once( __DIR__ . '/libs/smarty/Smarty.class.php' );

$params = array();
PageTools::setFilterInfo( $params );
$params[ 'columns' ] = 'distinct ?dataset_id ?project_id ?project_title ?project_date ?project_desc';
$result = Sparql::callSparql( $params, 'filter' );

$params = array();
foreach( $result as $row) {
	foreach( $row as $key => $value ) {
		$params[ $key ] = $value;
	}
}

$html = PageTools::getHtml( $params, 'dataset' );
echo $html;

?>
