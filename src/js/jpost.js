// jPOST JavaScript file

// namespace
var jPost = {};


// variables
jPost.tables = [];
jPost.slices = [];
jPost.slice = null;
jPost.datasets = null;
jPost.loaded = [];
jPost.species = [];

//create page
jPost.createPage = function() {
	$.ajax(
		{
			url: 'information.php',
			data: {
				type: 'panels'
			},
			dataType: 'json'

		}
	).then(
		function( data ) {
			jPost.createPanels( data );
		}
	);

        jPost.getSpecies();
}

// get species
jPost.getSpecies = function() {
    $.ajax(
        {
            url: 'species.php',
            dataType: 'json'
        }
    ).then(
        function( data ) {
            
            data.forEach( 
                function( element ) {
                    jPost.species[ element.dataset ] = element.species;
                }
            );
        }
    );
}


// create panels
jPost.createPanels = function( data ) {
	jPost.pageCounter = data.length;
	data.forEach(
		jPost.addPanel
	);

	$( '#header-menu' ).append( '<li class="menu-item"><a href="javascript:jPost.showHelp()">Help</a></li>' );

        var panel = jPost.addExtendedPanel();

	if( panel == null && data.length > 0 ) {
		var firstPanel = data[ 0 ];
		jPost.showPanel( firstPanel.name );
	}

}

jPost.addExtendedPanel = function() {
    var url = new URL( window.location.href );
    var dataset = url.searchParams.get( 'dataset' );
    var protein = url.searchParams.get( 'protein' );
    var peptide = url.searchParams.get( 'peptide' );

    var panel = null;

    if( dataset != null || protein != null || peptide != null ) {
        $( '#panels' ).append( '<div id="panel-extended" class="top-panel"></div>' );
        var params = window.location.search;

        if( peptide != null ) {
            $( '#panel-extended' ).load( 'peptide.php' + params );
            panel = 'peptide';
        }
        else if( protein != null ) {
            $( '#panel-extended' ).load( 'protein.php' + params );
            panel = 'protein';
        }
        else if( dataset != null ) {
            $( '#panel-extended' ).load( 'dataset.php' + params );
            panel = 'dataset';
        }
    }
    return panel;
}


// add panel
jPost.addPanel = function( panel ) {
	var tag = '<li id="menu-item-' + panel.name + '" class="menu-item"><a id="tab-' + panel.name + '-link" href="javascript:jPost.showPanel( '
			+ "'" + panel.name + "'" + ' )">' + panel.title + '</a></li>';
	$( '#header-menu' ).append( tag );

	tag = '<div id="panel-' + panel.name + '" class="top-panel" style="display: none;"></div>';
	$( '#panels' ).append( tag );

	$( '#panel-' + panel.name ).load(
		'pages/' + panel.name + '.html',
		function() {
			jPost.pageCounter = jPost.pageCounter - 1;
			if( panel.name == 'slices' ) {
				var json = localStorage.getItem( 'jPOST-slices' );
				if( json != null ) {
					var activeName = '';
					jPost.slices = JSON.parse( json );
					if( jPost.slices.length > 0 ) {
						activeName = jPost.slices[ 0 ];
					}
					jPost.refreshSlices( activeName );
					jPost.updateSliceSelection( -1 );
				}
			}
		}
	);
}

// show panel
jPost.showPanel = function( panel ) {
	$( '.top-panel' ).css( 'display', 'none' );
	$( '.menu-item' ).removeClass( 'active' );
	$( '#panel-' + panel ).css( 'display', 'block' );
	$( '#menu-item-' + panel ).addClass( 'active' );

	if( panel == 'slices' ) {
            jPost.slices.forEach( 
                function( slice ) {
                    var element = $( '#slice-' + slice.label );
                    if( element.is( ':visible' ) ) {  
			jPost.loadSliceStanza( slice.name );
		    }
		}
	    );
        }
}

//call sparql
jPost.callSparql = function( data, fun ) {
	$.ajax(
		{
			type: 'POST',
			url: 'execute_sparql.php',
			data: data,
			dataType: 'json'
		}
	).then( fun );
}

// set tag select
jPost.setTagSelect = function( select, url, data, valueIndex, displayIndex ) {
	if( data == null ) {
		data = {};
	}

	select.css( 'display', 'inline' );
	var select2 = select.select2(
		{
			ajax: {
				url: url,
				dataType: 'json',
				delay: 50,
				data: function( params ) {
					data.term = params;

					return data;
				},
				processResults: function( result, params ) {
					var array = [];
					result.result.forEach(
						function( element ) {
							array.push(
								{
									id: element[ valueIndex ],
									text: element[ displayIndex ]
								}
							);
						}
					);
					return { results: array };
				}
			},
			tags: true
		}
	);

	return select2;
}


//add options
jPost.addOptions = function( select, array, valueIndex, displayIndex ) {
	for( var i = 0; i < array.length; i++ ) {
		var item = array[ i ];
		var tag = '<option value="' + item[ valueIndex ] + '">'
				+ item[ displayIndex ] + '</option>'
		select.append( tag );
	}
}

// create tag select
jPost.createTagSelect = function( element ) {
	element.css( 'display', 'inline' );
	element.select2(
		{
			tags: true,
			width: '500px'
		}
	);
}

// create search page
jPost.createSearchPage = function() {
	jPost.setTagSelect(
		$( '#species' ),
		'execute_sparql.php',
		{
			item: 'species',
			template: 'items'
		},
		'label',
		'label'
	);
	$( '#species' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#tissue'),
		'execute_sparql.php',
		{
			item: 'tissue',
			template: 'items'
		},
		'label',
		'label'
	);
	$( '#tissue' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#disease'),
		'execute_sparql.php',
		{
			item: 'disease',
			template: 'items'
		},
		'label',
		'label'
	);
	$( '#disease' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#celltype' ),
		'execute_sparql.php',
		{
			item: 'cellType',
			template: 'items'
		},
		'label',
		'label'
	);
	$( '#celltype' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#modification'),
		'execute_sparql.php',
		{
			template: 'modifications'
		},
		'label',
		'label'
	);
	$( '#modification' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#instrument'),
		'execute_sparql.php',
		{
			item: 'instrument',
			template: 'instruments'
		},
		'label',
		'label'
	);
	$( '#instrument' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#instrumentMode'),
		'execute_sparql.php',
		{
			item: 'instrumentMode',
			template: 'instruments'
		},
		'label',
		'label'
	);
	$( '#instrumentMode' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.excludedDatasetSelect2 = jPost.setTagSelect(
		$( '#excludedDataset' ),
		'execute_sparql.php',
		{
			columns: 'distinct ?dataset_id',
			template: 'exclusion'
		},
		'dataset_id',
		'dataset_id'
	);
	$( '#excludedDataset' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#excludedProtein' ),
		'execute_sparql.php',
		{
			columns: 'distinct ?mnemonic',
			template: 'exclusion'
		},
		'mnemonic',
		'mnemonic'
	);
	$( '#exceptedProtein' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	$( '#datasetKeywords' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);
	$( '#proteinKeywords' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);
}

jPost.updating = [];

// create table
jPost.createDbTable = function( name, category, url, fnParams ) {
        var index = jPost.updating.indexOf( name );
        if( index >= 0 ) {
            return;
        }
        jPost.updating.push( name );

	$.ajax(
		{
			url: url,
			data: {
				method: 'table',
				name: name,
				category: category
			},
			dataType: 'json'
		}
	).then(
		function( data ) {
			var tag = '<thead><tr id="table-headers1-' + name + '"></tr></thead>';
			$( '#table-' + name ).append( tag );
			var order = -1;
			columns = [];
			var totalWidth = 0;

			data.columns.forEach(
				function( column, index ) {
					var tag = '<th>' + column.title + '</th>';
					$( '#table-headers1-' + name ).append( tag );

					if( column.sortable ) {
						if( order < 0 ) {
							order = index;
						}
					}

					totalWidth += column.width;

					var col = {
						data: column.name,
						orderable: column.sortable,
						className: 'dt-' + column.align,
						width: column.width
					};

					columns.push( col );
				}
			);

			var table = $( '#table-' + name ).DataTable(
				{
					dom: '<"top"i>rt<"bottom"lp><"clear">',
					processing: true,
					serverSide: true,
					searching: false,
					ajax: {
						url: data.url,
						type: 'POST'
					},
					fnServerParams: function( data ) {
						fnParams( data );
						data.method = 'list';
						data.name = name;
						data.category = category;
					},
//					scrollX: true,
					columns: columns,
					order: [[ order, 'asc']]
				}
			);
			if( category in jPost.tables ) {
				jPost.tables[ category ].push( table );
			}
			else {
				jPost.tables[ category ] = [ table ];
			}

                        index = jPost.updating.indexOf( name );
                        jPost.updating.splice( index, 1 );
                        
		}
	);
}

// update tables
jPost.updateTables = function( category ) {
	jPost.tables[ category ].forEach(
		function( table ) {
			table.ajax.reload();
		}
	);
}

// get filter parameters
jPost.getFilterParameters = function( data ) {
	var array = [
		'species', 'tissue', 'disease', 'celltype', 'modification', 'instrument', 'instrumentMode',
		'datasetKeywords', 'proteinKeywords', 'excludedDataset', 'excludedProtein'
	];
	array.forEach(
		function( element ) {
			data[ element ] = $( '#' + element ).val();
		}
	);
}

// get form data
jPost.getFormData = function( name, data ) {
	var query = $( '#' + name ).serializeArray();
	query.forEach(
		function( object ) {
			if( object.value != null && object.value != '' ) {
				if( object.name in data  ) {
					data[ object.name ] = data[ object.name ] + '&' + object.value;
				}
				else {
					data[ object.name ] = object.value;
				}
			}
		}
	);
}

// toggle checkboxes
jPost.toggleCheckboxes = function( name ) {
	$( '.' + name ).prop( 'checked', $( '#' + name ).prop('checked') );
}

// get selected values
jPost.getCheckedArray = function( name ) {
	var array = [];
	$( '.' + name + ':checked' ).map(
		function() {
			var value = $(this).val();
			array.push( value );
		}
	);

	return array;
}

// exclude datasets
jPost.excludeDatasets = function() {
	var array = jPost.getCheckedArray( 'check-dataset-dataset' );

	array.forEach(
		function( dataset ) {
			$( '#excludedDataset' ).select2(
				'trigger',
				'select',
				{
					data: { id: dataset, text: dataset }
				}
			);
		}
	);

	jPost.updateTables( '' );
}

// exclude proteins
jPost.excludeProteins = function() {
	var array = jPost.getCheckedArray( 'check-protein-protein' );

	array.forEach(
		function( protein ) {
			$( '#excludedProtein' ).select2(
				'trigger',
				'select',
				{
					data: { id: protein, text: protein}
				}
			);
		}
	);

	jPost.updateTables( '' );
}

// create new slice
jPost.createNewSlice = function() {
	jPost.slice = null;
	jPost.datasets = null;

	jPost.openSliceDialog();
}

// open slice dialog
jPost.openSliceDialog = function() {
	$( '#dialog-slice-name' ).val( '' );
	$( '#slice-dialog-message' ).html( '' );

	$( '#dialog-slice' ).modal( 'show' );
}

// add slice
jPost.addNewSlice = function() {
	var found = false;
	var name = $( '#dialog-slice-name' ).val();
	jPost.slices.forEach(
		function( slice ) {
			if( slice.name == name ) {
				found = true;
			}
		}
	);

	if( name.trim() == '' ) {
		alert( 'Please enter the slice name.' );
	}
	else if( found ) {
		alert( 'The specified slice name is already exists. Please enter another name.');
	}
	else {
		jPost.createSlice( name );
		if( jPost.datasets != null ) {
			var slice = jPost.getSlice( name );
			jPost.setSliceInfo( slice, jPost.datasets );
			$( '#dialog-slice-selection' ).modal( 'hide' );
		}
		$( '#dialog-slice' ).modal( 'hide' );
	}
}

// create label
jPost.getLabel = function( name ) {
    var label = name.replace( ' ', '_' );
    label = label.replace( '.', 'dot' );
    label = label.replace( '#', 'sharp' );

    return label;
}

// create slice
jPost.createSlice = function( name ) {
	var label = jPost.getLabel( name );

	var length = jPost.slices.length;

	jPost.slices.push(
		{
			name: name,
			dataset: [],
			label: label
		}
	);

	jPost.updateSliceSelection( length );
	jPost.refreshSlices( name );
}

// refresh slice
jPost.refreshSlices = function( activePanel ) {
	$( '#slice-tab' ).html( '' );
	$( '#slice-panels' ).html( '' );

        jPost.loaded = [];

        var slice = jPost.getSlice( activePanel );
        if( jPost.slices.length > 0 && slice == null ) {
            slice = jPost.slices[ 0 ];
            activePanel = slice.name;
        }

	jPost.slices.forEach(
		function( slice ) {
			var itemTab = '<li class="nav-item"><a class="nav-link bg-primary slice-tab" id="slice-' + slice.label + '-link" href="#slice-' + slice.label + '" data-toggle="tab">' + slice.name + '</a></li>';
			var panelTab = '<div class="tab-pane fade" id="slice-' + slice.label + '"></div>';

			$( '#slice-tab' ).append( itemTab );
			$( '#slice-panels' ).append( panelTab );

			jPost.addSliceTables( slice.name );
		}
	);

        $( '.slice-tab' ).on( 
            'shown.bs.tab',
            function( e ) {
                var name = e.target.innerText;
                jPost.loadSliceStanza( name );
            }
        );
        if( slice != null ) {
            $( '#slice-' + slice.label + '-link' ).tab( 'show' );
        }

	var tab = '<li class="nav-item"><a href="javascript:jPost.createNewSlice()">+</a></li>';
	$( '#slice-tab' ).append( tab );

        jPost.loadSliceStanza( activePanel );
	jPost.saveSlices();
}

// save slices
jPost.saveSlices = function() {
        if( jPost.slices.length > 0 ) {
	    var json = JSON.stringify( jPost.slices );
	    localStorage.setItem( 'jPOST-slices', json );
        }
        else {
            localStorage.removeItem( 'jPOST-slices' );
        }
}

// add slice tables
jPost.addSliceTables = function( name ) {
	jPost.tables[ name ] = [];
	var slice = jPost.getSlice( name );
	var label = slice.label;

        $( '#slice-' + label ).append( '<div id="slice-' + label + '-buttons" style="margin-left: auto; text-align: right;"></div>' );

	$( '#slice-' + label ).append( '<ul class="nav nav-tabs" id="slice-' + label + '-tab"></ul>' );

	$( '#slice-' + label ).append( '<div class="tab-content" id="slice-' + label + '-panels"></div>' );


	$( '#slice-' + label + '-tab' ).append( '<li class="nav-item active"><a class="nav-link bg-primary" href="#slice-dataset-' + label + '-panel" data-toggle="tab">Dataset</a></li>' );
	$( '#slice-' + label + '-panels' ).append( '<div class="tab-pane fade in active table-panel" id="slice-dataset-' + label + '-panel"></div>' );
	$( '#slice-dataset-' + label + '-panel' ).append( '<table id="table-slice-dataset-' + label + '"></table>' );
	jPost.createDbTable(
		'slice-dataset-' + label,
		name,
		'datasets.php',
		function( params ) {
			for( key in slice ) {
				params[ key ] = slice[ key ];
			}
			if( slice.dataset.length == 0 ) {
				params[ 'dataset' ] = [ 'empty dataset' ];
			}
		}
	);

        var tag = '<button onclick="jPost.removeDatasetsFromSlice( ' +  "'" + slice.name + "'" + ')">Remove Datasets</button>';
        $( '#slice-dataset-' + label + '-panel' ).append( tag );

	$( '#slice-' + label + '-tab' ).append( '<li class="nav-item"><a class="nav-link bg-primary" href="#slice-protein-' + label + '-panel" data-toggle="tab">Protein</a></li>' );
	$( '#slice-' + label + '-panels' ).append( '<div class="tab-pane fade table-panel" id="slice-protein-' + label + '-panel"></div>' );
	$( '#slice-protein-' + label + '-panel' ).append( '<table id="table-slice-protein-' + label + '"></table>' );
	jPost.createDbTable(
		'slice-protein-' + label,
		name,
		'proteins.php',
		function( params ) {
			for( key in slice ) {
				params[ key ] = slice[ key ];
			}
			if( slice.dataset.length == 0 ) {
				params[ 'dataset' ] = [ 'empty dataset' ];
			}
		}
	);

	$( '#slice-' + label + '-tab' ).append( '<li class="nav-item"><a class="nav-link bg-primary" href="#slice-peptide-' + label + '-panel" data-toggle="tab">Peptide</a></li>' );
	$( '#slice-' + label + '-panels' ).append( '<div class="tab-pane fade table-panel" id="slice-peptide-' + label + '-panel"></div>' );
	$( '#slice-peptide-' + label + '-panel' ).append( '<table id="table-slice-peptide-' + label + '"></table>' );
	jPost.createDbTable(
		'slice-peptide-' + label,
		name,
		'peptides.php',
		function( params ) {
			for( key in slice ) {
				params[ key ] = slice[ key ];
			}
			if( slice.dataset.length == 0 ) {
				params[ 'dataset' ] = [ 'empty dataset' ];
			}
		}
	);
        

	$( '#slice-' + label + '-panels' ).append( '<div id="slice-' + label + '-stanza"></div>' );

        $( '#slice-' + label + '-stanza' ).append( '<h3>Chromosome Info.</h3>' );
        $( '#slice-' + label + '-stanza' ).append( '<div id="slice-' + label + '-stanza-chromosome"></div>' );
        $( '#slice-' + label + '-stanza' ).append( '<h3>Protein Evidence</h3>' );
        $( '#slice-' + label + '-stanza' ).append( '<div id="slice-' + label + '-stanza-protein"></div>' );

	tag = ' <button onclick="jPost.exportSlice( ' + "'" + name + "'" + ' )" class="glyphicon glyphicon-export" data-toggle="tooltip" title="Export Slice"></button>'
			+ ' <button onclick="jPost.openRenameDialog( ' + "'" + name + "'" + ' )" class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Rename Slice"></button>'
			+ ' <button onclick="jPost.deleteSlice( ' + "'" + name + "'" + ' )" class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Delete Slice"></button>';
	$( '#slice-' + label + '-buttons' ).append( tag );
}

// get slice
jPost.getSlice = function( name ) {
	var slice = null;
	jPost.slices.forEach(
		function( tmp ) {
			if( tmp.name == name ) {
				slice = tmp;
			}
		}
	);
	return slice;
}

// add datasets to slice
jPost.addDatasetsToSlice = function() {
	jPost.datasets = null;
	jPost.slice = null;

	var array = jPost.getCheckedArray( 'check-dataset-dataset' );
	if( array.length == 0 ) {
		alert( "No datasets are not selected. Please check one or more datasets." );
		return;
	}

	jPost.datasets = array;

	if( jPost.slices.length == 0 ) {
		jPost.updateSliceSelection( -1 );
	}
	$( '#dialog-slice-selection' ).modal( 'show' );
	if( jPost.slices.length == 0 ) {
		jPost.openSliceDialog();
	}
}

// remove datasets from slice
jPost.removeDatasetsFromSlice = function( name ) {
    var slice = jPost.getSlice( name );
    var array = jPost.getCheckedArray( 'check-dataset-slice-dataset-' + slice.label );

    if( array.length == 0 ) {
        alert( "No datasets are not selected. Please check one or more datasets." );
                return;
    }

    if( !confirm( 'Are you sure to remove selected datasets from the slice?' ) ) {
        return;
    }

    array.forEach(
        function( element ) {
            var index = slice.dataset.indexOf( element );
            if( index >= 0 ) {
                slice.dataset.splice( index, 1 );
            }
        }
    );

    jPost.refreshSlices( name );
} 

// update slice selection
jPost.updateSliceSelection = function( index ) {
        if( index < 0 ) {
            if( jPost.slices.length > 0 ) {
                index = 0;
            }
        }

	if( index < 0 ) {
		$( '#select-slice' ).html( '<option value="" selected>+ (New Slice)</option>' );
	}
	else {
		$( '#select-slice' ).html( '<option value="">+ (New Slice)</option>' );
	}
	$( '.select-slice' ).html( '<option value="">( Select a slice. )</option> ');

	var counter = 0;
	jPost.slices.forEach(
		function( slice ) {
			if( counter == index ) {
				$( '#select-slice' ).append( '<option value="' + slice.name + '" selected>' + slice.name + '</option>' );
			}
			else {
				$( '#select-slice' ).append( '<option value="' + slice.name + '">' + slice.name + '</option>' );
			}
			$( '.select-slice' ).append( '<option value="' + slice.name + '">' + slice.name + '</option> ');

			counter++;
		}
	);
}

// on close slice selection dialog
jPost.onCloseSliceSelectionDialog = function() {
	var name = $( '#select-slice' ).val();
	if( name == '' ) {
		alert( 'Select a slice.' );
	}
	else {
		var slice = jPost.getSlice( name );
		if( slice != null && jPost.datasets != null ) {
			jPost.setSliceInfo( slice, jPost.datasets );
		}
		$( '#dialog-slice-selection' ).modal( 'hide' );
	}
}

// set slice information
jPost.setSliceInfo = function( slice, datasets ) {
	jPost.getFilterParameters( slice );

        var speciesArray = [];

        var fun = function( element ) {
            var species = jPost.species[ element ];
            if( speciesArray.indexOf( species ) < 0 ) {
                speciesArray.push( species );
            }
        }

        slice.dataset.forEach( fun );
        datasets.forEach( fun );

        if( speciesArray.length > 1 ) {
            var message = 'Datasets you selected have two or more species.\n';
            message = message + '[' + speciesArray.join( ',' ) + ']\n\n';
            message = message + 'Are you sure to continue?';

            if( !confirm( message ) ) {
                return;
            }
        } 

	datasets.forEach(
		function( dataset ) {
			if( slice.dataset.indexOf( dataset ) < 1 ) {
				slice.dataset.push( dataset );
			}
		}
	);

        jPost.refreshSlices( slice.name );
	jPost.saveSlices();
}

// delete slice
jPost.deleteSlice = function( name ) {
	if( confirm( 'Are you sure to delete the slice?' ) ) {
		var index = -1;
		for( var i = 0; i < jPost.slices.length; i++ ) {
			if( jPost.slices[ i ].name == name ) {
				index = i;
			}
		}

		if( index >= 0 ) {
			jPost.slices.splice( index, 1 );
		}

     	        jPost.updateSliceSelection( -1 );
		jPost.refreshSlices( -1 );
                jPost.saveSlices();
	}
}

//compare slices
jPost.compareSlices = function() {
	var name1 = $( '#select-comparison-slice1' ).val();
	var name2 = $( '#select-comparison-slice2' ).val();

	if( name1 == '' || name2 == '' ) {
		return;
	}

	var slice1 = jPost.getSlice( name1 );
	var slice2 = jPost.getSlice( name2 );

	if( slice1 == null || slice2 == null ) {
		return;
	}
	var parameters = 'stanza=group_comp&service=ts&method=sc&valid=eb&dataset1=' + encodeURIComponent( slice1.dataset.join( ' ' ) )
	+ '&dataset2=' + encodeURIComponent( slice2.dataset.join( ' ' ) );
var url = 'load_stanza.php?' + parameters;
$( '#comparison-result' ).load( url );
}

// add slice
jPost.addSlice = function( name, datasets ) {
	jPost.createSlice( name );
	var slice = jPost.getSlice( name );
	slice.dataset = datasets.split( ' ' );
}

//open dataset
jPost.openDataset = function( datasetId, category ) {
	var slice = jPost.getSlice( category );
	var parameters = 'dataset=' + datasetId;
	if( slice != null ) {
		parameters = parameters + '&slice=' + category;
	}
	var url = 'index.html?' + parameters;

	window.location.href = url;
}

//open protein
jPost.openProtein = function( proteinId, category ) {
	var slice = jPost.getSlice( category );
	var parameters = 'protein=' + proteinId;
	if( slice != null ) {
		parameters = parameters + '&slice=' + category + '&dataset=' + encodeURIComponent( slice.dataset.join( ' ' ) );
	}
	var url = 'index.html?' + parameters;
	window.location.href = url;
}

//open peptide
jPost.openPeptide = function( peptideId, category ) {
	var slice = jPost.getSlice( category );
	var parameters = 'peptide=' + peptideId;
	if( slice != null ) {
		parameters = parameters + '&slice=' + category + '&dataset=' + encodeURIComponent( slice.dataset.join( ' ' ) );
	}
	var url = 'index.html?' + parameters;
	window.location.href = url;
}

// export slice
jPost.exportSlice = function( name ) {
	var array = [];
	var filename = '';

	if( name == null || name == '' ) {
		filename = 'all.json';
		array = jPost.slices;
	}
	else {
		filename = name + '.json';
		var slice = jPost.getSlice( name );
		if( slice != null ) {
			array.push( slice );
		}
	}

	if( array.length == 0 ) {
		alert( 'There are no slices.' );
	}
	else {
		var json = JSON.stringify( array );
		var file = new File(
				[ json ],
				filename,
				{
					type: 'text/plain;charset=utf-8'
				}
		);
		saveAs( file );

	}
}

// open rename dialog
jPost.openRenameDialog = function( name ) {
	$( '#dialog-rename-slice-old-name' ).val( name );
	$( '#dialog-rename-slice-new-name' ).val( name );
	$( '#dialog-rename-slice' ).modal( 'show' );
}

// rename slice
jPost.renameSlice = function() {
	var oldName = $( '#dialog-rename-slice-old-name' ).val();
	var newName = $( '#dialog-rename-slice-new-name' ).val();

	if( oldName == newName ) {
		return;
	}

	var slice = jPost.getSlice( newName );
	if( slice != null ) {
		alert( 'Slice "' + newName + '" already exists.' );
		return;
	}

	slice = jPost.getSlice( oldName );
	slice.name = newName;
        slice.label = jPost.getLabel( newName );
	$( '#dialog-rename-slice' ).modal( 'hide' );

	jPost.updateSliceSelection( -1 );
	jPost.refreshSlices( newName );
}

// import slices
jPost.importSlices = function() {
	 $( '#upload_slices' ).click();
}

// show help
jPost.showHelp = function() {
    window.open( 'help/' );
}

// load slice stanza
jPost.loadSliceStanza = function( name ) {
    if( jPost.loaded.indexOf( name ) >= 0 ) {
        return;
    }

    var slice = jPost.getSlice( name );
    if( slice == null ) {
        return;
    }

    if( $( '#panel-slices' ).is( ':hidden' ) ) {
        return;
    }

    var label = slice.label;

    var datasets = encodeURIComponent( slice.dataset.join( ' ' ) );
    if( datasets == '' ) {
        datasets = 'dummy';
    }

    var parameters = 'service=ts&dataset=' + datasets;
    var url = 'load_stanza.php?stanza=dataset_chromosome&' + parameters;

    $( '#slice-' + label + '-stanza-chromosome' ).load( url );

    var url = 'load_stanza.php?stanza=protein_evidence&' + parameters;
    $( '#slice-' + label + '-stanza-protein' ).load( url );

    jPost.loaded.push( name );
}

