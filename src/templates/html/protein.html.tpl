    <div class="container">
      <h2>Protein: {$protein_id}</h2>
      <table class="table table-striped">
        <tr>
          <th>Protein Name</th>
          <td>{$full_name}</td>
        </tr>
        <tr>
          <th>ID</th>
          <td>{$mnemonic}</td>
        </tr>
        <tr>
          <th>Accession</th>
          <td><a href="{$protein}" target="_blank">{$protein_id}</a></td>
        </tr>
        <tr>
          <th>Mass</th>
          <td>{$mass}</td>
        </tr>
        <tr>
          <th>Sequence</th>
          <td style="word-break: break-all;">{$sequence}</td>
        </tr>
      </table>

      <h3>Protein Browser</h3>
      <div id="protein_browser"></div>

      <h3>Proteoforms</h3>
      <div id="proteoforms"></div>

      <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link bg-primary" href="#dataset-table-tab"  data-toggle="tab">Dataset</a></li>
        <li class="nav-item"><a class="nav-link bg-primary" href="#peptide-table-tab"  data-toggle="tab">Peptide</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade in table-panel active" id="dataset-table-tab">
          <table id="table-dataset-detail" class="display"></table>
        </div>
        <div class="tab-pane fade table-panel" id="peptide-table-tab">
          <table id="table-peptide-detail" class="display"></table>
        </div>
      </div>
    </div>
    <script>
      jPost.createDbTable(
          'dataset-detail',
          '{$slice}',
          'datasets.php',
          function( params ) {
              var slice = jPost.getSlice( '{$slice}' );
              if( slice != null ) {
                  for( key in slice ) {
                      params[ key ] = slice[ key ];
                  }
              }
              params[ 'protein' ] = '{$protein_id}';
          }
	  );
      jPost.createDbTable(
          'peptide-detail',
          '{$slice}',
          'peptides.php',
          function( params ) {
              var slice = jPost.getSlice( '{$slice}' );
              if( slice != null ) {
                  for( key in slice ) {
                      params[ key ] = slice[ key ];
                  }
              }
              params[ 'protein' ] = '{$protein_id}';
          }
	  );

	  var parameters = 'stanza=protein_browser&service=ts&uniprot={$protein_id}&dataset=' + encodeURIComponent( '{$dataset}' );
	  var url = 'load_stanza.php?' + parameters;
	  $( '#protein_browser' ).load( url );

	  parameters = 'stanza=proteoform_browser&service=ts&uniprot={$protein_id}&dataset=' + encodeURIComponent( '{$dataset}' );
	  url = 'load_stanza.php?' + parameters;
	  $( '#proteoforms' ).load( url );


    </script>
