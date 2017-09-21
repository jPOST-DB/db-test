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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../css/select2.min.css" rel="stylesheet">
    <link href="../css/jpost.css" rel="stylesheet">

    <link href="http://db-dev.jpostdb.org/ts/stanza/group_comp/" rel="import">

    <script src="../js/jquery-3.1.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/select2.full.min.js"></script>
    <script src="../js/jpost.js"></script>
  </head>
  <body>
    <togostanza-group_comp method="<?php echo $method ?>" valid="<?php echo $valid ?>"
        dataset1="<?php echo $dataset1 ?>" dataset2="<?php echo $dataset2 ?>"
        style="width: 950px; height: 500px;"></togostanza-group_comp>
  </body>
</html>
