<?php
    $stanza = $_REQUEST['stanza'];

    $service = 'tsv1';
    if( array_key_exists( 'service', $_REQUEST ) ) {
    	$service = $_REQUEST[ 'service' ];
    }

    if( array_key_exists( 'type', $_REQUEST ) ) {
      $type = $_REQUEST['type'];
    }
    if( array_key_exists( 'dataset', $_REQUEST ) ) {
      $dataset = $_REQUEST['dataset'];
    }
    if( array_key_exists( 'uniprot', $_REQUEST ) ) {
      $uniprot = $_REQUEST['uniprot'];
    }
?>


<!DOCTYPE html>

<html>
  <head>
    <title>jPOST</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="/<?php echo $service ?>/stanza/assets/components/webcomponentsjs/webcomponents-loader.js"></script>
    <link href="/<?php echo $service ?>/stanza/<?php echo $stanza ?>/" rel="import">
  </head>
  <body>
    <togostanza-<?php echo $stanza ?><?php

foreach ( $_REQUEST as $key => $value) {
  if ($key == "stanza")
    continue;
  print " $key=\"$value\"";
}

?>></togostanza-<?php echo $stanza ?>>
  </body>
</html>
