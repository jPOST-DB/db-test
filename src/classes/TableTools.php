<?php

require_once( __DIR__ . '/../conf/config.php' );
require_once( __DIR__ . '/../libs/smarty/Smarty.class.php' );

/**
 * TableTools class
 */
class TableTools {
	public static $KEY_TABLE         = 'table';
	public static $KEY_TEMPLATE      = 'template';
	public static $KEY_OBJECT        = 'object';
	public static $KEY_SUFFIX        = 'suffix';

	public static $KEY_TABLE_NAME    = 'name';
	public static $KEY_TABLE_TITLE   = 'title';
	public static $KEY_TABLE_SEARCH  = 'search';
	public static $KEY_TABLE_DISPLAY = 'display';

	/**
	 * gets the table name titles
	 * @param $array
	 * @return
	 */
	public static function getTableHeaderTitles( $array ) {
		$smarty = new Smarty();
		$smarty->assign( $_REQUEST );

		$titles = array();

		foreach( $array as $element ) {
			array_push(
				$titles,
				$smarty->fetch( 'string:' . $element[ self::$KEY_TABLE_TITLE ] )
			);
		}

		return $titles;
	}

	/**
	 * gets the array of table header
	 */
	public static function getHeadersArray() {
		$table = $_REQUEST[ self::$KEY_TABLE ];
		$array = Config::$TABLE_COLUMN_MAP[ $table ];
		return $array;
	}

	/**
	 * gets the table header titles
	 */
	public static function getTableHeaders() {
		$array = self::getHeadersArray();

		if( $array == null ) {
			$headers = [];
			return $headers;
		}

		$headers = self::getTableHeaderTitles( $array );
		return $headers;
	}

	/**
	 * gets the data
	 */
	public static function getData() {
		$table = $_REQUEST[ self::$KEY_TABLE ];
		$template = $_REQUEST[ self::$KEY_TEMPLATE ];

		$result = self::getTableData( $table, Config::$TABLE_COLUMN_MAP[ $table ], $template );

		return $result;
	}

	/**
	 * gets table data
	 */
	public static function getTableData( $object, $columns, $template ) {
		$parameters = array(
			'columns' => 'count( distinct ?' . $object . ' ) as ?count'
		);

		if( array_key_exists( 'object', $_REQUEST ) ) {
			$parameters[ self::$KEY_OBJECT ] = $_REQUEST[ self::$KEY_OBJECT ];
		}
		if( array_key_exists( self::$KEY_TABLE, $_REQUEST ) ) {
			$parameters[ self::$KEY_TABLE ] = $_REQUEST[ self::$KEY_TABLE ];
		}
		if( array_key_exists( 'objects', $_REQUEST ) ) {
			$objects = json_decode( $_REQUEST[ 'objects' ] );
			if( $objects == null ) {
				$objects = array();
			}
			$parameters[ 'objects' ] = self::getUrlValuesString( $objects );
		}
		if( array_key_exists( 'minus', $_REQUEST ) ) {
			$minus = json_decode( $_REQUEST[ 'minus' ] );
			if( $minus != null && count( $minus ) > 0 ) {
				$parameters[ 'minus' ] = $minus;
			}
		}

		$resultSet = self::executeSparql( $parameters, $template );
		$count = self::getCount( $resultSet );

		$parameters = self::setSearch( $parameters, $columns );
		$parameters = self::setFilters( $parameters );
		$resultSet = self::executeSparql( $parameters, $template );
		$filteredCount = self::getCount( $resultSet );

		$parameters[ 'columns' ] = self::getColumnsString( $object, $columns );
		$parameters = self::setPageInfo( $parameters, $columns );

		$resultSet = self::executeSparql( $parameters, $template );
		$data = self::getSparqlData( $columns, $resultSet );

		$result = array(
			'draw' => $_REQUEST[ 'draw' ],
			'recordsTotal' => $count,
			'recordsFiltered' => $filteredCount,
			'data' => $data
		);

		return $result;
	}

	/**
	 * executes sparql
	 * @param unknown $parameters
	 * @return resut
	 */
	public static function executeSparql( $parameters, $template ) {
		$smarty = new Smarty();
		$smarty->assign( $parameters );
		$query = $smarty->fetch( __DIR__ . '/../templates/sparql/' . $template . '.sparql.tpl' );

		$sparql = new Sparql( $query );
		$sparql->execute();

		return $sparql->getResultSet();
	}

	/**
	 *  gets the count value from result
	 * @param unknown $reuslt
	 * @return number
	 */
	public static function getCount( $result ) {
		$count = 0;
		if( count( $result ) > 0 ) {
			$element = $result[ 0 ];
			if( array_key_exists( 'count', $element ) ) {
				$count = intval( $element[ 'count' ] );
			}
		}

		return $count;
	}

	/**
	 * sets the filters
	 */
	public static function setFilters( $parameters ) {
		$urlFilters = array(
			'species', 'tissue', 'disease', 'modification', 'instrument', 'instrumentMode'
		);

		foreach( $urlFilters as $filter ) {
			if( array_key_exists( $filter, $_REQUEST ) ) {
				$values = self::getUrlValuesString( $_REQUEST[ $filter ] );
				if( $values != null && strlen( $values ) > 0 ) {
					$parameters[ $filter ] = $values;
				}
			}
		}

		return $parameters;
	}

	/**
	 * sets search
	 */
	public static function setSearch( $parameters, $array ) {
		if( array_key_exists( 'search', $_REQUEST ) ) {
			$search = $_REQUEST[ 'search' ];
			$keyword = $search[ 'value' ];
			$filter = '';

			if( strlen( $keyword ) > 0 ) {
				$filter = 'filter( false ';
				foreach( $array as $element ) {
					$flag = false;
					if( array_key_exists( self::$KEY_TABLE_SEARCH, $element) ) {
						$flag = $element[ self::$KEY_TABLE_SEARCH ];
					}

					if( $flag ) {
						$name = $element[ self::$KEY_TABLE_NAME ];
						$filter = $filter . "|| contains( lcase( str( ?$name ) ), lcase( \"$keyword\" ) )";
					}
				}
				$filter = $filter . ') .';
			}
			if( strlen( $filter ) > 0 ) {
				$parameters[ 'search' ] = $filter;
			}
		}

		return $parameters;
	}

	/**
	 * sets the page info
	 * @param unknown $parameters
	 */
	public static function setPageInfo( $parameters, $array ) {
		$order = null;

		if( array_key_exists( 'order', $_REQUEST ) ) {
			$order = $_REQUEST[ 'order' ][ 0 ];
		}

		if( $order != null ) {
			$index = intval( $order[ 'column' ] );
			$dir = $order[ 'dir' ];

			$parameters[ 'order' ] = $dir . '( ?'
								. $array[ $index ][ self::$KEY_TABLE_NAME ]
								. ' )';
		}

		if( array_key_exists( 'start', $_REQUEST ) ) {
			$parameters[ 'offset' ] = $_REQUEST[ 'start' ];
		}

		if( array_key_exists( 'length', $_REQUEST ) ) {
			$parameters[ 'limit' ] = $_REQUEST[ 'length' ];
		}

		return $parameters;
	}

	/**
	 * get url values string
	 */
	public static function getUrlValuesString( $urls ) {
		$array = array();
		foreach( $urls as $url ) {
			array_push( $array, '<' . $url . '>' );
		}

		return join( ' ', $array );
	}

	/**
	 * gets columns string
	 */
	public static function getColumnsString( $object, $columns ) {
		$string = 'distinct ?' . $object;

		foreach( $columns as $column ) {
			if( array_key_exists( self::$KEY_TABLE_NAME, $column ) ) {
				$string = $string . ' ?' . $column[ self::$KEY_TABLE_NAME ];
			}
		}

		return $string;
	}

	/**
	 * gets the data from sparql result
	 * @param unknown $columns
	 * @param unknown $result
	 */
	public static function getSparqlData( $columns, $result ) {
		$array = array();
		$smarty = new Smarty();

		foreach( $result as $record ) {
			$element = array();

			$record[ 'suffix' ] = $_REQUEST[ self::$KEY_SUFFIX ];
			$smarty->assign( $record );

			foreach( $columns as $column ) {
				$value = $smarty->fetch( 'string:' . $column[ self::$KEY_TABLE_DISPLAY ] );
				array_push( $element, $value );
			}

			array_push( $array, $element );
		}

		return $array;
	}
}

?>
