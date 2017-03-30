<?php

require_once( __DIR__ . '/conf/config.php' );

?>

<!DOCTYPE html>

<html>
  <head>
    <?php include( __DIR__ . '/pages/head.php' ); ?>

    <script>
    	$(document).ready( jPost.createTopPage );
    </script>
  </head>

  <body>
    <?php include( __DIR__ . '/pages/header.php' ); ?>

	<div id="loading"><img src="img/waiting.gif"></div>

    <div id="container" class="container">
      <div id="search-panel" class="top-panel">
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
            <div>
              <button id="pickup_datasets_button">Pick Up</button>
              <button id="except_datasets_button">Add to Excepted Datasets</button>
            </div>
          </div>
          <div class="tab-pane fade table-panel" id="protein-table-tab">
            <table id="protein-table" class="display"></table>
            <div>
              <button id="pickup_proteins_button">Pick Up</button>
              <button id="except_proteins_button">Add to Excepted Proteins</button>
            </div>
          </div>
        </div>
      </div>
      <div id="picked-proteins-panel" class="top-panel">
        <table id="picked-proteins-table"></table>
        <div>
          <button id="remove_pickup_proteins_button">Remove</button>
        </div>
      </div>
      <div id="picked-datasets-panel" class="top-panel">
        <table id="picked-datasets-table"></table>
        <div>
          <button id="remove_pickup_datasets_button">Remove</button>
        </div>
      </div>
      <div id="excepted-proteins-panel" class="top-panel">
        <table id="excepted-proteins-table"></table>
        <div>
          <button id="remove_except_proteins_button">Remove</button>
        </div>
      </div>
      <div id="excepted-datasets-panel" class="top-panel">
        <table id="excepted-datasets-table"></table>
        <div>
          <button id="remove_except_datasets_button">Remove</button>
        </div>
      </div>
    </div>

    <?php include( __DIR__ . '/pages/footer.php' ); ?>
  </body>
</html>