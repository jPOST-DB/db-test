<?php
    $method = "sc";
    if( array_key_exists( 'method', $_REQUEST ) ) {
    	$method = $_REQUEST[ 'method' ];
    }

    $valid = "eb";
    if( array_key_exists( 'valid', $_REQUEST ) ) {
    	$valid = $_REQUEST[ 'valid' ];
    }

    $dataset1 = $_REQUEST[ 'dataset1' ];
    $dataset2 = $_REQUEST[ 'dataset2' ];
?>

<!DOCTYPE html>

<html>
  <head>
    <title>jPOST</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="/ts/stanza/assets/components/webcomponentsjs/webcomponents.min.js"></script>
    <link href="/ts/stanza/group_comp/" rel="import">
  </head>
  <body>
    <togostanza-group_comp method="<?php echo $method ?>" valid="<?php echo $valid ?>"
        dataset1="<?php echo $dataset1 ?>" dataset2="<?php echo $dataset2 ?>"
        style="width: 950px; height: 500px;"></togostanza-group_comp>
  </body>
</html>
