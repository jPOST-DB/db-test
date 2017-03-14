<?php

require_once( __DIR__ . '/../conf/config.php' );
require_once( __DIR__ . '/../libs/smarty/Smarty.class.php' );

/**
 * TableTools class
 */
class TableTools {
	public static $KEY_TABLE              = 'table';
	public static $KEY_TEMPLATE           = 'template';
	public static $KEY_ID                 = 'id';

	public static $KEY_TABLE_HEADER_NAME  = 'name';
	public static $KEY_TABLE_HEADER_TITLE = 'title';

	/**
	 * gets table name headers
	 * @param unknown $array
	 * @return
	 */
	public static function getTableHeaderNames( $array ) {
		$names = array();

		foreach( $array as $element ) {
			array_push( $names, $element[ self::$KEY_TABLE_HEADER_NAME ] );
		}

		return names;
	}

	/**
	 * gets the table name titles
	 * @param $array
	 * @return
	 */
	public static function getTableHeaderTitles( $array ) {
		$titles = array();

		foreach( $array as $element ) {
			array_push( $titles, $element[ self::$KEY_TABLE_HEADER_TITLE ] );
		}

		return $titles;
	}

	/**
	 * gets the array of table header
	 */
	public static function getHeadersArray() {
		$table = $_POST[ self::$KEY_TABLE ];

		$array = null;
		if( $table == 'dataset' ) {
			$array = Config::$DATASET_COLUMNS;
		}
		else if( $table == 'protein' ) {
			$array = Config::$PROTEIN_COLUMNS;
		}
		else if( $table == 'peptide' ) {
			$array = Config::$PEPTIDE_COLUMNS;
		}
		else if( $table == 'peptide_position' ) {
			$array = Config::$PEPTIDE_POSITION_COLUMNS;
		}
		else if( $table == 'profile' ) {
			$array = Config::$PROFILE_COLUMNS;
		}

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
		$result = array();

		$table = $_REQUEST[ self::$KEY_TABLE ];
		$template = $_REQUEST[ self::$KEY_TEMPLATE ];

		if( $table == 'protein' ) {
			$result = self::getTableData( 'protein', Config::$PROTEIN_COLUMNS, $template );
		}
		else if( $table == 'peptide' ) {
			$result = self::getTableData( 'peptide', Config::$PEPTIDE_COLUMNS, $template );
		}
		else if( $table == 'peptide_position' ) {
			$result = self::getTableData( 'peptide_position', Config::$PEPTIDE_POSITION_COLUMNS, $template );
		}
		else if( $table == 'dataset' ) {
			$result = self::getTableData( 'dataset', Config::$DATASET_COLUMNS, $template );
		}
		else if( $table == 'profile' ) {
			$result = self::getTableData( 'profile', Config::$PROFILE_COLUMNS, $template );
		}

		return $result;
	}

	/**
	 * gets the protein data
	 */
	public static function getTableData( $object, $columns, $template ) {
		$parameters = array(
			'columns' => 'count( distinct ?' . $object . ' ) as ?count'
		);

		if( array_key_exists( 'id', $_REQUEST ) ) {
			$parameters[ self::$KEY_ID ] = $_REQUEST[ self::$KEY_ID ];
		}
		if( array_key_exists( self::$KEY_TABLE, $_REQUEST ) ) {
			$parameters[ self::$KEY_TABLE ] = $_REQUEST[ self::$KEY_TABLE ];
		}

		$resultSet = self::executeSparql( $parameters, $template );
		$count = self::getCount( $resultSet );

		$parameters = self::setSearch( $parameters, $columns );
		$parameters = self::setFilters( $parameters );
		$parameters[ $object ] = true;
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
					$name = $element[ self::$KEY_TABLE_HEADER_NAME ];
					$filter = $filter . "|| contains( lcase( str( ?$name ) ), lcase( \"$keyword\" ) )";
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
								. $array[ $index ][ self::$KEY_TABLE_HEADER_NAME ]
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
			$string = $string . ' ?' . $column[ self::$KEY_TABLE_HEADER_NAME ];
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

		foreach( $result as $record ) {
			$element = array();

			foreach( $columns as $column ) {
				$value = $record[ $column[ self::$KEY_TABLE_HEADER_NAME ] ];
				if( array_key_exists( 'url', $column ) ) {
					$url = $column[ 'url' ];
					$value = '<a href="' . $url . $value . '" target="_blank">' . $value . '</a>';
				}

				array_push( $element, $value );
			}

			array_push( $array, $element );
		}

		return $array;
	}

}

?>

