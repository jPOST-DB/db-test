// jPOST JavaScript file

// namespace
var jPost = {};


// variables
jPost.tables = [];
jPost.slices = [];
jPost.slice = null;
jPost.datasets = null;

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
}

// create panels
jPost.createPanels = function( data ) {
	jPost.pageCounter = data.length;
	data.forEach(
		jPost.addPanel
	);

	if( data.length > 0 ) {
		var firstPanel = data[ 0 ];
		jPost.showPanel( firstPanel.name );
	}
}

// add panel
jPost.addPanel = function( panel ) {
	var tag = '<li id="menu-item-' + panel.name + '" class="menu-item"><a href="javascript:jPost.showPanel( '
			+ "'" + panel.name + "'" + ' )">' + panel.title + '</a></li>';
	$( '#header-menu' ).append( tag );

	tag = '<div id="panel-' + panel.name + '" class="top-panel" style="display: none;"></div>';
	$( '#panels' ).append( tag );

	$( '#panel-' + panel.name ).load(
		'pages/' + panel.name + '.html',
		function() {
			jPost.pageCounter = jPost.pageCounter - 1;
			if( jPost.pageCounter == 0 ) {
				var json = localStorage.getItem( 'jPOST-slices' );
				if( json != null ) {
					jPost.slices = JSON.parse( json );
					jPost.refreshSlices( -1 );
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
			tags: true
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

// create table
jPost.createDbTable = function( name, category, url, fnParams ) {
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
jPost.addSlice = function() {
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

// create slice
jPost.createSlice = function( name ) {
	var label = name.replace( ' ', '_' );
	label = label.replace( '.', 'dot' );
	label = label.replace( '#', 'sharp' );

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
	$( '#slice-panels' ).html( '' )

	jPost.slices.forEach(
		function( slice ) {
			var itemTab = null;
			var panelTab = null;

			if( slice.name == activePanel ) {
				itemTab = '<li class="nav-item active"><a class="nav-link bg-primary" href="#slice-' + slice.label + '" data-toggle="tab">' + slice.name + '</a></li>'
				panelTab = '<div class="tab-pane fade in active table-panel" id="slice-' + slice.label + '"></div>';
			}
			else {
				itemTab = '<li class="nav-item"><a class="nav-link bg-primary" href="#slice-' + slice.label + '" data-toggle="tab">' + slice.name + '</a></li>';
				panelTab = '<div class="tab-pane fade" id="slice-' + slice.label + '"></div>';
			}

			$( '#slice-tab' ).append( itemTab );
			$( '#slice-panels' ).append( panelTab )

			jPost.addSliceTables( slice.name );
		}
	);

	var tab = '<li class="nav-item"><a href="javascript:jPost.createNewSlice()">+</a></li>';
	$( '#slice-tab' ).append( tab );

	jPost.saveSlices();
}

// save slices
jPost.saveSlices = function() {
	var json = JSON.stringify( jPost.slices );
	localStorage.setItem( 'jPOST-slices', json );
}

// add slice tables
jPost.addSliceTables = function( name ) {
	jPost.tables[ name ] = [];
	var slice = jPost.getSlice( name );
	var label = slice.label;

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

	var tag = '<button onclick="jPost.deleteSlice( ' + "'" + name + "'" + ' )" class="btn">Delete Slice</button>';
	$( '#slice-' + label + '-panels' ).append( tag );
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

// update slice selection
jPost.updateSliceSelection = function( index ) {
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

	datasets.forEach(
		function( dataset ) {
			if( slice.dataset.indexOf( dataset ) < 0 ) {
				slice.dataset.push( dataset );
			}
		}
	);

	jPost.updateTables( slice.name );
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

		jPost.refreshSlices( -1 );
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

	var parameters = 'method=sc&valid=eb&dataset1=' + encodeURIComponent( slice1.dataset.join( ' ' ) )
				   + '&dataset2=' + encodeURIComponent( slice2.dataset.join( ' ' ) );
	var url = 'stanza/compare.php?' + parameters;
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
	var url = 'dataset.php?' + parameters;

	window.open( url );
}

//open protein
jPost.openProtein = function( proteinId, category ) {
	var slice = jPost.getSlice( category );
	var parameters = 'protein=' + proteinId;
	if( slice != null ) {
		parameters = parameters + '&slice=' + category + '&dataset=' + encodeURIComponent( slice.dataset.join( ' ' ) );
	}
	var url = 'protein.php?' + parameters;
	window.open( url );
}

//open peptide
jPost.openPeptide = function( peptideId, category ) {
	var slice = jPost.getSlice( category );
	var parameters = 'peptide=' + peptideId;
	if( slice != null ) {
		parameters = parameters + '&slice=' + category + '&dataset=' + encodeURIComponent( slice.dataset.join( ' ' ) );
	}
	var url = 'peptide.php?' + parameters;
	window.open( url );
}
