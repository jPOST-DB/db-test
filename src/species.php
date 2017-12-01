<?php

require_once( __DIR__ . '/classes/Sparql.php' );


$result = array();
foreach( Sparql::callSparql( null, 'species' ) as $row ) {
    array_push(
        $result,
        array( 
            'dataset' => $row[ 'dataset_id' ], 
            'species' => $row[ 'species' ]
        )
    );
}

echo json_encode( $result );

?>
