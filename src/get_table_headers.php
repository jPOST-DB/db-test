<?php

require_once( __DIR__ . '/conf/config.php' );
require_once( __DIR__ . '/classes/TableTools.php' );

$result = TableTools::getTableHeaders();

echo json_encode( $result );

?>

