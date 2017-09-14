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

	$( '#panel-' + panel.name ).load( 'pages/' + panel.name + '.html' );
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
	select.select2(
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

	jPost.setTagSelect(
		$( '#excludedDatasets' ),
		'execute_sparql.php',
		{
			columns: 'distinct ?dataset_id',
			template: 'exclusion'
		},
		'dataset_id',
		'dataset_id'
	);
	$( '#excludedProteins' ).change(
		function() {
			jPost.updateTables( '' );
		}
	);

	jPost.setTagSelect(
		$( '#excludedProteins' ),
		'execute_sparql.php',
		{
			columns: 'distinct ?mnemonic',
			template: 'exclusion'
		},
		'mnemonic',
		'mnemonic'
	);
	$( '#exceptedProteins' ).change(
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
					scrollX: ( totalWidth > 800 ),
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
	var array = [ 'species', 'tissue', 'disease', 'celltype', 'modification', 'instrument', 'instrumentMode' ];
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

// add
jPost.excludeDatasets = function() {
	var array = jPost.getCheckedArray( 'check-dataset-dataset' );
	$( '#excludedDatasets' ).select2( array.join( ',' ) );
	jPost.updateTables( '' );
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
		$( '#dialog-slice' ).modal( 'hide' );
	}
}

// create slice
jPost.createSlice = function( name ) {
	var length = jPost.slices.length;

	jPost.slices.push(
		{
			name: name,
			datasets: []
		}
	);

	jPost.updateSliceSelection( length );
	jPost.refreshSlices( name );

	$( '.select-slice' ).append( '<option value="' + name + '">' + name + '</option> ');
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
				itemTab = '<li class="nav-item active"><a class="nav-link bg-primary" href="#slice-' + slice.name + '" data-toggle="tab">' + slice.name + '</a></li>'
				panelTab = '<div class="tab-pane fade in active table-panel" id="slice-' + slice.name + '"></div>';
			}
			else {
				itemTab = '<li class="nav-item"><a class="nav-link bg-primary" href="#slice-' + slice.name + '" data-toggle="tab">' + slice.name + '</a></li>';
				panelTab = '<div class="tab-pane fade" id="slice-' + slice.name + '"></div>';
			}

			$( '#slice-tab' ).append( itemTab );
			$( '#slice-panels' ).append( panelTab )

			jPost.addSliceTables( slice.name );
		}
	);

	var tab = '<li class="nav-item"><a href="javascript:jPost.openSliceDialog()">+</a></li>';
	$( '#slice-tab' ).append( tab );
}

// add slice tables
jPost.addSliceTables = function( name ) {
	jPost.tables[ name ] = [];
	var slice = jPost.getSlice( name );

	$( '#slice-' + name ).append( '<ul class="nav nav-tabs" id="slice-' + name + '-tab"></ul>' );
	$( '#slice-' + name ).append( '<div class="tab-content" id="slice-' + name + '-panels"></div>' );

	$( '#slice-' + name + '-tab' ).append( '<li class="nav-item active"><a class="nav-link bg-primary" href="#slice-dataset-' + name + '-panel" data-toggle="tab">Dataset</a></li>' );
	$( '#slice-' + name + '-panels' ).append( '<div class="tab-pane fade in active table-panel" id="slice-dataset-' + name + '-panel"></div>' );
	$( '#slice-dataset-' + name + '-panel' ).append( '<table id="table-slice-dataset-' + name + '"></table>' );
	jPost.createDbTable(
		'slice-dataset-' + name,
		name,
		'datasets.php',
		function( params ) {
			for( key in slice ) {
				params[ key ] = slice[ key ];
			}
		}
	);

	$( '#slice-' + name + '-tab' ).append( '<li class="nav-item"><a class="nav-link bg-primary" href="#slice-protein-' + name + '-panel" data-toggle="tab">Protein</a></li>' );
	$( '#slice-' + name + '-panels' ).append( '<div class="tab-pane fade table-panel" id="slice-protein-' + name + '-panel"></div>' );
	$( '#slice-protein-' + name + '-panel' ).append( '<table id="table-slice-protein-' + name + '"></table>' );
	jPost.createDbTable(
		'slice-protein-' + name,
		name,
		'proteins.php',
		function( params ) {
			for( key in slice ) {
				params[ key ] = slice[ key ];
			}
		}
	);
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
	$( '.check-dataset-dataset' ).prop( 'checked', false );
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

	var counter = 0;
	jPost.slices.forEach(
		function( slice ) {
			if( counter == index ) {
				$( '#select-slice' ).append( '<option value="' + slice.name + '" selected>' + slice.name + '</option>' );
			}
			else {
				$( '#select-slice' ).append( '<option value="' + slice.name + '">' + slice.name + '</option>' );
			}
			counter++;
		}
	);
}

// on close slice selection dialog
jPost.onCloseSliceSelectionDialog = function() {
	var name = $( '#select-slice' ).val();
	if( name == '' ) {
		jPost.openSliceDialog();
		if( jPost.slices.length > length ) {
			jPost.updateSliceSelection( length );
		}
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
			if( slice.datasets.indexOf( dataset ) < 0 ) {
				slice.datasets.push( dataset );
			}
		}
	);

	jPost.updateTables( slice.name );
}

// compare slices
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

	var tag = '<togostanza-group_comp method="sc" valud="eb "'
		    + 'dataset1="' + slice1.datasets.join( ' ' ) + '" '
		    + 'dataset2="' + slice2.datasets.join( ' ' ) + '"></togostanza-group_comp>';

	$( '#comparison-result' ).html( tag );
}

/*

// create page
jPost.createTopPage = function() {
	jPost.createSearchPage();
	jPost.createTopTables();

	$( 'body' ).css( 'display', 'block' );
	$( '#search-filter-title' ).click();

	$( '#pickup_proteins_button' ).click( jPost.addPickedUpProteins );
	$( '#except_proteins_button' ).click( jPost.addExceptedProteins );
	$( '#pickup_datasets_button' ).click( jPost.addPickedUpDatasets );
	$( '#except_datasets_button' ).click( jPost.addExceptedDatasets );
	$( '#remove_pickup_proteins_button' ).click( jPost.removePickedUpProteins );
	$( '#remove_except_proteins_button' ).click( jPost.removeExceptedProteins );
	$( '#remove_pickup_datasets_button' ).click( jPost.removePickedUpDatasets );
	$( '#remove_except_datasets_button' ).click( jPost.removeExceptedDatasets );


	jPost.showPanel( 'search-panel' );
}

// create dataset page
jPost.createDatasetPage = function() {
	jPost.createItemTable( '#profile-table', 'profile', 'dataset_items' );
	jPost.createItemTable( '#protein-table', 'protein', 'dataset_items' );
	jPost.createItemTable( '#peptide-table', 'peptide', 'dataset_items' );

	$( '.menu-item' ).css( 'display', 'none' );
}

// create protein page
jPost.createProteinPage = function() {
	jPost.createItemTable( '#dataset-table', 'dataset', 'protein_items' );
	jPost.createItemTable( '#peptide-table', 'peptide_position', 'protein_items' );

	$( '.menu-item' ).css( 'display', 'none' );
}

// create peptide page
jPost.createPeptidePage = function() {
	jPost.createItemTable( '#psm-table', 'psm', 'peptide_items' );

	$( '.menu-item' ).css( 'display', 'none' );
}


// create tables
jPost.createTopTables = function() {
	jPost.createTopTable( '#dataset-table', 'dataset', 'datasets', jPost.KEY_EXCEPTED_DATASETS );
	jPost.createTopTable( '#protein-table', 'protein', 'proteins', jPost.KEY_EXCEPTED_PROTEINS );
	jPost.createStorageTable( '#picked-proteins-table', 'protein', 'proteins', jPost.KEY_PICKED_UP_PROTEINS, '-pp' );
	jPost.createStorageTable( '#picked-datasets-table', 'dataset', 'datasets', jPost.KEY_PICKED_UP_DATASETS, '-pd' );
	jPost.createStorageTable( '#excepted-proteins-table', 'protein', 'proteins', jPost.KEY_EXCEPTED_PROTEINS, '-ep' );
	jPost.createStorageTable( '#excepted-datasets-table', 'dataset', 'datasets', jPost.KEY_EXCEPTED_DATASETS, '-ed' );
}

// create top table
jPost.createTopTable = function( table, name, template, minusKey ) {
	$.ajax(
		{
			type: 'POST',
			url: 'get_table_headers.php',
			data: {
				table: name,
				suffix: '',
			},
			dataType: 'json'
		}
	).then(
		function( data ) {
			jPost.addTableHeader( $( table ), data );

			var datatable = $( table ).DataTable(
				{
					pageLength: 25,
					serverSide: true,
					processing: true,
					pagingType: "full_numbers",
					columnDefs: [
						{
							orderable: false,
							targets: 0
						}
					],
					order: [ [ 1, 'asc' ] ],
					fnServerParams: function( data ) {
						data.table = name;
						data.template = template;
						data.suffix = '';
						data.minus = JSON.stringify( jPost.getArray( minusKey ) );
						data.species = $( '#species' ).val();
						data.tissue = $( '#tissue' ) .val();
						data.disease = $( '#disease' ).val();
						data.modification = $( '#modification' ).val();
						data.instrument = $( '#instrument' ).val();
						data.instrumentMode = $( '#instrumentMode' ).val();
					},
					ajax: 'get_table_data.php'
				}
			);

			jPost.tables.push( datatable );
		}
	);
}

jPost.createStorageTable = function( table, name, template, key, suffix ) {
	$.ajax(
		{
			type: 'POST',
			url: 'get_table_headers.php',
			data: {
				table: name,
				suffix: suffix
			},
			dataType: 'json'
		}
	).then(
		function( data ) {
			jPost.addTableHeader( $( table ), data );

			var datatable = $( table ).DataTable(
				{
					pageLength: 25,
					serverSide: true,
					processing: true,
					pagingType: "full_numbers",
					columnDefs: [
						{
							orderable: false,
							targets: 0
						}
					],
					order: [ [ 1, 'asc' ] ],
					fnServerParams: function( data ) {
						data.table = name;
						data.template = template;
						data.suffix = suffix;
						data.objects = JSON.stringify( jPost.getArray( key ) );
					},
					ajax: 'get_table_data.php'
				}
			);

			jPost.tables.push( datatable );
		}
	);
}

// create table
jPost.createItemTable = function( table, name, template ) {
	$.ajax(
		{
			type: 'POST',
			url: 'get_table_headers.php',
			data: { table: name },
			dataType: 'json'
		}
	).then(
		function( data ) {
			jPost.addTableHeader( $( table ), data );

			var datatable = $( table ).DataTable(
				{
					pageLength: 25,
					serverSide: true,
					processing: true,
					pagingType: "full_numbers",
					columnDefs: [
						{
							orderable: false,
							targets: 0
						}
					],
					order: [ [ 1, 'asc' ] ],
					fnServerParams: function( data ) {
						data.table = name;
						data.template = template;
						data.object = $( '#item_object' ).val();
						data.suffix = '';
					},
					ajax: 'get_table_data.php'
				}
			);
		}
	);
}

// add table header
jPost.addTableHeader = function( table, headers ) {
	var tag = '';
	for( var i = 0 ;i < headers.length; i++ ) {
		tag += '<th>' + headers[ i ] + '</th>';
	}
	tag = '<thead><tr>' + tag + '</tr></thead>';
	table.append( tag );
}

// update tables
jPost.updateTables = function() {
	var tables = jPost.tables;
	for( var i = 0 ;i < tables.length; i++ ) {
		var table = tables[ i ];
		table.ajax.reload();
	}
}

// start waiting
jPost.startWaiting = function() {
	if( !jPost.waiting ) {
		jPost.waiting = true;
		$( '#loading' ).fadeIn();
		$( '#container' ).fadeOut();
	}
}

// end waiting
jPost.endWaiting = function() {
	if( jPost.waiting ) {
		jPost.waiting = false;
		$( '#loading' ).fadeOut();
		$( '#container' ).fadeIn();
	}
}

// toggle protein checkboxes
jPost.toggleProteinCheckboxes = function() {
	jPost.toggleCheckboxes('protein_check');
}

// toggle dataset checkboxes
jPost.toggleDatasetCheckboxes = function() {
	jPost.toggleCheckboxes('dataset_check');
}

// toggle peptide checkboxes
jPost.togglePeptideCheckboxes = function() {
	jPost.toggleCheckboxes('peptide_check');
}

// toggle profile checkboxes
jPost.toggleProfileCheckboxes = function() {
	jPost.toggleCheckboxes('profile_check');
}



// gets array
jPost.getArray = function( key ) {
	var json = localStorage.getItem( key );
	if( json == null ) {
		return null;
	}

	return JSON.parse( json );
}

// sets array
jPost.setArray = function( key, array ) {
	if( array == null ) {
		localStorage.removeItem( key );
	}
	else {
		localStorage.setItem( key, JSON.stringify(array) );
	}
}

// add objects
jPost.addObjectsToArray = function( key, className ) {
	var array = jPost.getArray( key );
	if( array == null ) {
		array = [];
	}

	$( '.' + className + ':checked' ).map(
		function() {
			var value = $(this).val();
			if( array.indexOf( value ) < 0 ) {
				array.push( value );
			}
		}
	);

	jPost.setArray( key, array );

	$( '.' + className + ':checked' ).prop( 'checked', false );
	jPost.updateTables();
}

// remove objects
jPost.removeObjectsFromArray = function( key, className ) {
	var array = jPost.getArray( key );
	if( array == null ) {
		return;
	}

	$( '.' + className + ':checked' ).map(
		function() {
			var value = $(this).val();
			var index = array.indexOf( value );
			if( index >= 0 ) {
				array.splice( index, 1 );
			}
		}
	);

	jPost.setArray( key, array );

	$( '.' + className + ':checked' ).prop( 'checked', false );
	jPost.updateTables();
}

// add picked up proteins
jPost.addPickedUpProteins = function() {
	jPost.addObjectsToArray( jPost.KEY_PICKED_UP_PROTEINS, 'protein_check' );
}

// add excepted proteins
jPost.addExceptedProteins = function() {
	jPost.addObjectsToArray( jPost.KEY_EXCEPTED_PROTEINS, 'protein_check' );
}

// add picked up datasets
jPost.addPickedUpDatasets = function() {
	jPost.addObjectsToArray( jPost.KEY_PICKED_UP_DATASETS, 'dataset_check' );
}

// add excepted datasets
jPost.addExceptedDatasets = function() {
	jPost.addObjectsToArray( jPost.KEY_EXCEPTED_DATASETS, 'dataset_check' );
}

// remove picked up proteins
jPost.removePickedUpProteins = function() {
	jPost.removeObjectsFromArray( jPost.KEY_PICKED_UP_PROTEINS, 'protein_check-pp' );
}

// remove excepted proteins
jPost.removeExceptedProteins = function() {
	jPost.removeObjectsFromArray( jPost.KEY_EXCEPTED_PROTEINS, 'protein_check-ep' );
}

// remove picked up datasets
jPost.removePickedUpDatasets = function() {
	jPost.removeObjectsFromArray( jPost.KEY_PICKED_UP_DATASETS, 'dataset_check-pd' );
}

// remove excepted datasets
jPost.removeExceptedDatasets = function() {
	jPost.removeObjectsFromArray( jPost.KEY_EXCEPTED_DATASETS, 'dataset_check-ed' );
}

//show panel
jPost.showPanel = function( panel ) {
	$( '.top-panel' ).css( 'display', 'none' );
	$( '.menu-item' ).removeClass( 'active' );
	$( '#' + panel ).css( 'display', 'block' );
	$( '#' + panel + '-menu-item' ).addClass( 'active' );
}

*/