// jPOST JavaScript file

// namespace
var jPost = {};


// variables
jPost.waiting = false;
jPost.tables = [];

// constant values
jPost.KEY_PICKED_UP_PROTEINS = 'jPost-PickedUpProteins';
jPost.KEY_EXCEPTED_PROTEINS  = 'jPost-ExceptedProteins';
jPost.KEY_PICKED_UP_DATASETS = 'jPost-PickedUpDatasets';
jPost.KEY_EXCEPTED_DATASETS  = 'jPost-ExceptedDatasets';

// call sparql
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


// create search page
jPost.createSearchPage = function() {
	jPost.callSparql(
		{
			item: 'species',
			template: 'items'
		},
		function( result ) {
			var items = result.result;
			jPost.addOptions( $( '#species' ), items, 'object', 'label' );
			jPost.createTagSelect( $( '#species' ) );
		}
	);
	$( '#species' ).change( jPost.updateTables );

	jPost.callSparql(
		{
			item: 'tissue',
			template: 'items'
		},
		function( result ) {
			var items = result.result;
			jPost.addOptions( $( '#tissue' ), items, 'object', 'label' );
			jPost.createTagSelect( $( '#tissue' ) );
		}
	);
	$( '#tissue' ).change( jPost.updateTables );

	jPost.callSparql(
		{
			item: 'disease',
			template: 'items'
		},
		function(result) {
			var items = result.result;
			jPost.addOptions( $( '#disease' ), items, 'object', 'label' );
			jPost.createTagSelect( $( '#disease' ) );
		}
	);
	$( '#disease' ).change( jPost.updateTables );

	jPost.callSparql(
		{
			template: 'modifications'
		},
		function(result) {
			var items = result.result;
			jPost.addOptions( $( '#modification' ), items, 'object', 'label' );
			jPost.createTagSelect( $( '#modification' ) );
		}
	);
	$( '#modification' ).change( jPost.updateTables );

	jPost.callSparql(
		{
			item: 'instrument',
			template: 'instruments'
		},
		function(result) {
			var items = result.result;
			jPost.addOptions( $( '#instrument' ), items, 'object', 'label' );
			jPost.createTagSelect( $( '#instrument' ) );
		}
	);
	$( '#instrument' ).change( jPost.updateTables );

	jPost.callSparql(
		{
			item: 'instrumentMode',
			template: 'instruments'
		},
		function(result) {
			var items = result.result;
			jPost.addOptions( $( '#instrumentMode' ), items, 'object', 'label' );
			jPost.createTagSelect( $( '#instrumentMode' ) );
		}
	);
	$( '#instrumentMode' ).change( jPost.updateTables );
}

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

// add options
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

// toggle checkboxes
jPost.toggleCheckboxes = function( name ) {
	$( '.' + name ).prop( 'checked', $( '#' + name ).prop('checked') );
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

// show panel
jPost.showPanel = function( panel ) {
	$( '.top-panel' ).css( 'display', 'none' );
	$( '.menu-item' ).removeClass( 'active' );
	$( '#' + panel ).css( 'display', 'block' );
	$( '#' + panel + '-menu-item' ).addClass( 'active' );
}


