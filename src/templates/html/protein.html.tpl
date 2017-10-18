<!DOCTYPE html>
<html>
  <head>
    <title>{$protein_id} - jPOST</title>
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
      <h2>Protein: {$protein_id}</h2>
      <table class="table table-striped">
        <tr>
          <th>Full Name</th>
          <td>{$full_name}</td>
        </tr>
        <tr>
          <th>Mnemonic</th>
          <td>{$mnemonic}</td>
        </tr>
        <tr>
          <th>Uniprot ID</th>
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
      <div data-stanza="http://db-dev.jpostdb.org/stanza/js_stanza_wrapper" data-stanza-server="http://db-dev.jpostdb.org/ts/stanza" data-stanza-name="protein_browser" data-stanza-options="uniprot={$protein_id}"></div>
      <h3>Proteoforms</h3>
      <div data-stanza="http://db-dev.jpostdb.org/stanza/js_stanza_wrapper" data-stanza-server="http://db-dev.jpostdb.org/ts/stanza" data-stanza-name="proteoform_browser" data-stanza-options="uniprot={$protein_id}"></div>

      <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link bg-primary" href="#dataset-table-tab"  data-toggle="tab">Dataset</a></li>
        <li class="nav-item"><a class="nav-link bg-primary" href="#peptide-table-tab"  data-toggle="tab">Peptide</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade in table-panel active" id="dataset-table-tab">
          <table id="table-dataset" class="display"></table>
        </div>
        <div class="tab-pane fade table-panel" id="peptide-table-tab">
          <table id="table-peptide" class="display"></table>
        </div>
      </div>
    </div>
    <script>
      jPost.createDbTable(
          'dataset',
          '{$slice}',
          'datasets.php',
          function( params ) {
              var slice = jPost.getSlice( '{$slice}' );
              console.log( slice );
              if( slice != null ) {
                  for( key in slice ) {
                      params[ key ] = slice[ key ];
                  }
              }
              params[ 'protein' ] = '{$protein_id}';
          }
	  );
      jPost.createDbTable(
          'peptide',
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
    </script>
  </body>
</html>
