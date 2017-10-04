<!DOCTYPE html>
<html>
  <head>
    <title>{$dataset_id} - jPOST</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/stanza.js"></script>
    <script src="js/jpost.js"></script>
  </head>
  <body>
    <div class="container">
      <h2>Dataset: {$dataset_id}</h2>
      <table class="table table-striped">
        <tr>
          <th>ID</th>
          <td>{$dataset_id}</td>
        </tr>
        <tr>
          <th>Project ID</th>
          <td>{$project_id}</td>
        </tr>
        <tr>
          <th>Project Title</th>
          <td>{$project_title}</td>
        </tr>
        <tr>
          <th>Project Description</th>
          <td>{$project_desc}</td>
        </tr>
        <tr>
          <th>Project Date</th>
          <td>{$project_date}</td>
        </tr>
      </table>

      <h3>KEGG Global Pathway</h3>
      <div data-stanza="http://db-dev.jpostdb.org/stanza/js_stanza_wrapper" data-stanza-server="http://db-dev.jpostdb.org/ts/stanza" data-stanza-name="kegg_global_map" data-stanza-options="dataset={$dataset_id}"></div>
      <h3>Chromosome Info.</h3>
      <div data-stanza="http://db-dev.jpostdb.org/stanza/js_stanza_wrapper" data-stanza-server="http://db-dev.jpostdb.org/ts/stanza" data-stanza-name="dataset_chromosome" data-stanza-options="dataset={$dataset_id}"></div>
      <h3>Protein Existence</h3>
      <div data-stanza="http://db-dev.jpostdb.org/stanza/js_stanza_wrapper" data-stanza-server="http://db-dev.jpostdb.org/ts/stanza" data-stanza-name="protein_evidence" data-stanza-options="dataset={$dataset_id}"></div>

      <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link bg-primary" href="#protein-table-tab"  data-toggle="tab">Protein</a></li>
        <li class="nav-item"><a class="nav-link bg-primary" href="#peptide-table-tab"  data-toggle="tab">Peptide</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade in table-panel active" id="protein-table-tab">
          <table id="table-protein" class="display"></table>
        </div>
        <div class="tab-pane fade table-panel" id="peptide-table-tab">
          <table id="table-peptide" class="display"></table>
        </div>
      </div>
    </div>

<script>
	jPost.createDbTable(
		'protein',
		'<details>',
		'proteins.php',
		function( params ) {
			params[ 'dataset' ] = '{$dataset_id}';
		}
	);
	jPost.createDbTable(
		'peptide',
		'<dataset>',
		'peptides.php',
		function( params ) {
			params[ 'dataset' ] = '{$dataset_id}';
		}
	);
</script>

  </body>
</html>
