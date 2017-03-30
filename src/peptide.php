<?php

require_once( __DIR__ . '/conf/config.php' );
require_once( __DIR__ . '/classes/PageTools.php' );

?>

<!DOCTYPE html>

<html>
  <head>
    <?php include( __DIR__ . '/pages/head.php' ); ?>
    <script>
        $(document).ready( jPost.createPeptidePage );
    </script>
  </head>

  <body>
    <?php include( __DIR__ . '/pages/header.php' ); ?>

	<div id="loading"><img src="img/waiting.gif"></div>

    <div id="container" class="container">
      <?php
		PageTools::showPage( 'peptide' );
      ?>
    </div>

    <?php include( __DIR__ . '/pages/footer.php' ); ?>
  </body>
</html>