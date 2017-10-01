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

		$keyword = self::getParameter( 'keyword' );
		if( $keyword != null ) {
			$keywords = array();
			$strings = explode( ' ', $keyword );
			foreach( $strings as $string ) {
				$sting = trim( $string );
				if( $string != '' ) {
					array_push( $keywords, $string );
				}
			}

			if( count( $keywords ) > 0 ) {
				$params[ 'keywords' ] = $keywords;
			}
		}

		$datasets = self::getObjects( 'dataset', 'datasets', 'dataset', false );
		if( $datasets != null ) {
			$params[ 'datasets' ] = $datasets;
		}

		$datasets = self::getObjects( 'protein', 'proteins', 'protein', false );
		if( $datasets != null ) {
			$params[ 'proteins' ] = $datasets;
		}

		$excludedDatasets = self::getObjects( 'excludedDataset', 'datasets', 'dataset', true );
		if( $excludedDatasets != null ) {
			$params[ 'excludedDatasets' ] = $excludedDatasets;
		}

		$excludedProteins = self::getObjects( 'excludedProtein', 'proteins', 'protein', true );
		if( $excludedProteins != null ) {
			$params[ 'excludedProteins' ] = $excludedProteins;
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

		if( is_array( $values ) ) {
			foreach( $values as $value ) {
				if( $string != '' ) {
					$string = $string . ', ';
				}
				$string = $string . '"'. $value . '"';
			}
		}
		else {
			$string = '"' . $values . '"';
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
	public static function getObjects( $name, $template, $item, $comma ) {
		$objects = null;

		if( array_key_exists( $name, $_REQUEST ) ) {
			$params = array();
			$params[ $template ] = PageTools::getFilterValues( $_REQUEST[ $name ] );

			$sparqlResult = Sparql::callSparql( $params, $template );
			$datasets = '';
			foreach( $sparqlResult as $object ) {
				if( $objects != '' && $comma ) {
					$objects = $objects . ',';
				}
				$objects = $objects . ' <' . $object[ $item ] . '>';
			}

			if( $objects == '' ) {
				$objects = '<http://example.com/dummy>';
			}
		}

		return $objects;
	}

	/**
     * gets HTML string
	 */
	public static function getHtml( $parameters, $template ) {
		$smarty = new Smarty();
		$smarty->assign( $parameters );
		$html = $smarty->fetch( __DIR__ . '/../templates/html/' . $template . '.html.tpl' );
		return $html;
	}
}

?>