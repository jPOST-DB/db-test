<?php

require_once( __DIR__ . '/libs/smarty/Smarty.class.php' );
require_once( __DIR__ . '/classes/Sparql.php' );
require_once( __DIR__ . '/conf/config.php' );

$template = $_REQUEST[ 'template' ];

$smarty = new Smarty();
$smarty->assign( $_REQUEST );
$query = $smarty->fetch( __DIR__ . "/templates/sparql/$template.sparql.tpl" );

$sparql = new Sparql( $query );
$sparql->execute();

echo json_encode( $sparql->getResponse() );

?>
