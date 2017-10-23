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
{if isset( $dataset)}
    <script>
        jPost.addSlice( '{$slice}', '{$dataset}' );
    </script>
{/if}
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
      <div id="kegg_global_map"></div>

      <h3>Chromosome Info.</h3>
      <div id="dataset_chromosome"></div>

      <h3>Protein Existence</h3>
      <div id="protein_evidence"></div>

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
		'{$slice}>',
		'proteins.php',
		function( params ) {
			params[ 'dataset' ] = '{$dataset_id}';
		}
	);
	jPost.createDbTable(
		'peptide',
		'{$slice}',
		'peptides.php',
		function( params ) {
			params[ 'dataset' ] = '{$dataset_id}';
		}
	);

	  var parameters = 'stanza=kegg_global_map&service=tsv1&dataset={$dataset_id}';
	  var url = 'load_stanza.php?' + parameters;
	  $( '#kegg_global_map' ).load( url );

	  var parameters = 'stanza=dataset_chromosome&service=tsv1&dataset={$dataset_id}';
	  var url = 'load_stanza.php?' + parameters;
	  $( '#dataset_chromosome' ).load( url );

	  var parameters = 'stanza=protein_evidence&service=tsv1&dataset={$dataset_id}';
	  var url = 'load_stanza.php?' + parameters;
	  $( '#protein_evidence' ).load( url );
</script>

  </body>
</html>
