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
          <table id="table-protein-detail" class="display"></table>
        </div>
        <div class="tab-pane fade table-panel" id="peptide-table-tab">
          <table id="table-peptide-detail" class="display"></table>
        </div>
      </div>
    </div>

<script>
	jPost.createDbTable(
		'protein-detail',
		'{$slice}>',
		'proteins.php',
		function( params ) {
			params[ 'dataset' ] = '{$dataset_id}';
		}
	);
	jPost.createDbTable(
		'peptide-detail',
		'{$slice}',
		'peptides.php',
		function( params ) {
			params[ 'dataset' ] = '{$dataset_id}';
		}
	);

	  var parameters = 'stanza=kegg_global_map&service=ts&dataset={$dataset_id}';
	  var url = 'load_stanza.php?' + parameters;
	  $( '#kegg_global_map' ).load( url );

	  var parameters = 'stanza=dataset_chromosome&service=ts&dataset={$dataset_id}';
	  var url = 'load_stanza.php?' + parameters;
	  $( '#dataset_chromosome' ).load( url );

	  var parameters = 'stanza=protein_evidence&service=ts&dataset={$dataset_id}';
	  var url = 'load_stanza.php?' + parameters;
	  $( '#protein_evidence' ).load( url );
</script>
