<?php

require_once( __DIR__ . '/classes/Sparql.php' );
require_once( __DIR__ . '/classes/TableTools.php' );

require_once( __DIR__ . '/conf/config.php' );

$result = TableTools::getData();

echo json_encode( $result );

?>
