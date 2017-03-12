<?php

require_once( __DIR__ . '/conf/config.php' );

?>

<!DOCTYPE html>

<html>
  <head>
    <?php include( __DIR__ . '/pages/head.php' ); ?>
  </head>

  <body>
    <?php include( __DIR__ . '/pages/header.php' ); ?>

	<div id="loading"><img src="img/waiting.gif"></div>

    <div id="container" class="container">
      <?php
        include( __DIR__ . '/pages/' . 'search.php' );
      ?>

      <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link bg-primary" href="#dataset-table-tab" data-toggle="tab">Dataset</a></li>
        <li class="nav-item"><a class="nav-link bg-primary" href="#protein-table-tab"  data-toggle="tab">Protein</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade in active table-panel" id="dataset-table-tab">
          <table id="dataset-table" class="display"></table>
        </div>
        <div class="tab-pane fade table-panel" id="protein-table-tab">
          <table id="protein-table" class="display"></table>
        </div>
      </div>
    </div>

    <?php include( __DIR__ . '/pages/footer.php' ); ?>
  </body>
</html>