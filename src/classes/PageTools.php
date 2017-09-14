<?php

require_once( __DIR__ . '/../conf/config.php' );
require_once( __DIR__ . '/Sparql.php' );
require_once( __DIR__ . '/Messages.php' );
require_once( __DIR__ . '/../libs/smarty/Smarty.class.php' );

/**
 * page tools class
  */
class PageTools {

	/**
	 * sets the page information
	 */
	public static function setPageInfo( &$params ) {
		if( array_key_exists( 'order', $_REQUEST ) ) {
			$order = $_REQUEST[ 'order' ];
			$columns = $_REQUEST[ 'columns' ];

			$params[ 'order' ]= $order[ 0 ][ 'dir' ]
							  . '( ?' . $columns[ intval( $order[ 0 ][ 'column' ] ) ][ 'data' ] . ' )';
		}

		if( array_key_exists( 'start', $_REQUEST ) ) {
			$params[ 'offset' ] = intval( $_REQUEST[ 'start' ] );
		}

		if( array_key_exists( 'length', $_REQUEST ) ) {
			$params[ 'limit' ] = intval( $_REQUEST[ 'length' ] );
		}
	}

	/**
	 *  sets the filter information
	 */
	public static function setFilterInfo( &$params ) {
		$filters = array( 'species', 'tissue', 'disease', 'celltype', 'modification', 'instrument', 'instrumentMode' );
		foreach( $filters as $filter ) {
			$values = PageTools::getParameter( $filter );
			if( $values != null ) {
				$params[ $filter ] = PageTools::getFilterValues( $values );
			}
		}

		$datasets = self::getDatasets();
		if( $datasets != null && $datasets != '' ) {
			$params[ 'datasets' ] = $datasets;
		}
	}

	/**
	 * gets the parameter
	 */
	public static function getParameter( $key ) {
		$object = null;
		if( array_key_exists( $key, $_REQUEST ) ) {
			$object = $_REQUEST[ $key ];
		}

		return $object;
	}

	/**
	 * gets filter values
	 */
	public static function getFilterValues( $values ) {
		$string = '';

		foreach( $values as $value ) {
			if( $string != '' ) {
				$string = $string . ', ';
			}
			$string = $string . '"' . $value . '"';
		}

		return $string;
	}

	/**
	 * gets values
	 */
	public static function getValues( $array, $key ) {
		$string = '';

		foreach( $array as $row ) {
			$string = $string . ' <' . $row[ $key ] . '>';
		}

		return $string;
	}

	/**
	 * get datasets
	 */
	public static function getDatasets() {
		$datasets = null;

		if( array_key_exists( 'datasets', $_REQUEST ) ) {
			$params = array();
			$params[ 'datasets' ] = PageTools::getFilterValues( $_REQUEST[ 'datasets' ] );

			$sparqlResult = Sparql::callSparql( $params, 'datasets' );
			$datasets = '';
			foreach( $sparqlResult as $dataset ) {
				$datasets = $datasets . ' <' . $dataset[ 'dataset' ] . '>';
			}
		}

		return $datasets;
	}
}

?>