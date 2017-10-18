<!DOCTYPE html>
<html>
  <head>
    <title>{$peptide_id} - jPOST</title>
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
      <h2>Peptide: {$peptide_id}</h2>
      <table class="table table-striped">
        <tr>
          <th>Peptide ID</th>
          <td>{$peptide_id}</td>
        </tr>
        <tr>
        <tr>
          <th>Dataset</th>
          <td><a href="javascript:jPost.openDataset('{$dataset_id}', null)">{$dataset_id}</td>
        </tr>
        <tr>
          <th>Protein</th>
          <td><a href="javascript:jPost.openProtein('{$protein_id}', null)">{$full_name}</td>
        </tr>
        <tr>
          <th>Mnemonic</th>
          <td>{$mnemonic}</td>
        </tr>
        <tr>
          <th>Uniprot ID</th>
          <td><a href="{$protein}" target="_blank">{$protein_id}</a></td>
        </tr>
        <th>Sequence</th>
          <td style="word-break: break-all;">{$peptide_label}</td>
        </tr>
      </table>
      <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link bg-primary" href="#psm-table-tab"  data-toggle="tab">Psm</a></li>
        <li class="nav-item"><a class="nav-link bg-primary" href="#position-table-tab"  data-toggle="tab">Position</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade in table-panel active" id="psm-table-tab">
          <table id="table-psm" class="display"></table>
        </div>
        <div class="tab-pane fade table-panel active" id="position-table-tab">
          <table id="table-position" class="display"></table>
        </div>
      </div>
    </div>

    <script>
        jPost.createDbTable(
            'psm',
		    '{$slice}',
		    'psms.php',
		    function( params ) {
		        var slice = jPost.getSlice( '{$slice}' );
                if( slice != null ) {
                    for( key in slice ) {
                        params[ key ] = slice[ key ];
                    }
                }
		        params[ 'peptide' ] = '{$peptide_id}';
		    }
	    );
	    jPost.createDbTable(
            'position',
		    '{$slice}',
		    'positions.php',
		    function( params ) {
                var slice = jPost.getSlice( '{$slice}' );
                if( slice != null ) {
                    for( key in slice ) {
                        params[ key ] = slice[ key ];
                    }
                }
		        params[ 'peptide' ] = '{$peptide_id}';
		    }
	    );
    </script>
  </body>
</html>
