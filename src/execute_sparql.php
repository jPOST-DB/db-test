<?php

require_once( __DIR__ . '/libs/Skinny/Skinny.php' );
require_once( __DIR__ . '/classes/Sparql.php' );
require_once( __DIR__ . '/conf/config.php' );

$template = $_POST[ 'template' ];

$query = $Skinny->SkinnyFetchHTML( __DIR__ . "/templates/sparql/${ template }.sparql.tpl", $_POST );

$sparql = new Sparql( $query );
$sparql->execute();

echo json_encode( $sparql->getResponse() );

?>
