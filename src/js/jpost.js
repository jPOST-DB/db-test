// jPOST JavaScript file

// namespace
var jPost = {};


// variables
jPost.waiting = false;
jPost.tables = [];


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
}

// create dataset page
jPost.createDatasetPage = function() {
	jPost.createItemTable( '#profile-table', 'profile', 'dataset_items' );
	jPost.createItemTable( '#protein-table', 'protein', 'dataset_items' );
	jPost.createItemTable( '#peptide-table', 'peptide', 'dataset_items' );
}

// create protein page
jPost.createProteinPage = function() {
	jPost.createItemTable( '#dataset-table', 'dataset', 'protein_items' );
	jPost.createItemTable( '#peptide-table', 'peptide_position', 'protein_items' );
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
	jPost.createTopTable( '#dataset-table', 'dataset' );
	jPost.createTopTable( '#protein-table', 'protein' );
}

// create top table
jPost.createTopTable = function( table, name ) {
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
					fnServerParams: function( data ) {
						data.table = name;
						data.template = 'proteins';
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
					fnServerParams: function( data ) {
						data.table = name;
						data.template = template;
						data.id = $( '#item_id' ).val();
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
