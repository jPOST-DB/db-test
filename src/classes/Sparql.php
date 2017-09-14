<?php

require_once( __DIR__ . '/../conf/config.php' );
require_once( __DIR__ . '/../libs/smarty/Smarty.class.php' );

ini_set('max_execution_time', 0);

/**
 * sparql query maangement class
  */
class Sparql {
	// sparql
	private $sparql;

	// endpoint
	private $endpoint;

	// headers
	private $headers;

	// result
	private $result;

	// last sparql
	private static $lastSparql;

	/**
	 *  constructor
	 * @param unknown $sparql
	 * @param unknown $endpoint
	 */
	public function __construct( $sparql, $endpoint = null ) {
		$this->sparql = $sparql;
		$this->endpoint = $endpoint;
		if( $endpoint == null ) {
			$this->endpoint = Config::$SPARQL_ENDPOINT;
		}

		$this->headers = null;
		$this->result = null;
	}

	/**
	 *  executes sparql query
	 */
	public function execute() {
		$format = 'json';

		self::setLastSparql( $this->sparql );

		$data = array(
			'query' => $this->sparql,
			'timeout' => 0,
			'format' => 'json'
		);
		$data = http_build_query( $data, '', '&' );

		$header = array(
			'Content-Type:application/x-www-form-urlencoded',
			'Content-Length: ' . strlen($data)
		);

		$context = array(
			'http' => array(
				'method' => 'POST',
				'header' => implode( "\r\n", $header ),
				'content'=> $data
			)
		);

		$content = file_get_contents( $this->endpoint, false, stream_context_create( $context ) );
		$result = json_decode( $content );

		$headers = $result->head->vars;

		$this->headers = array();
		foreach( $headers as $header ) {
			array_push( $this->headers, $header );
		}

		$bindings = $result->results->bindings;
		$this->result = array();

		foreach( $bindings as $binding ) {
			$array = array();
			foreach( $headers as $header ) {
				if( property_exists( $binding, $header ) ) {
					$element = $binding->{ $header };
					$array[ $header ] = $element->value;
				}
				else {
					$array[ $header ] = null;
				}
			}
			array_push( $this->result, $array );
		}
	}

	/**
	 * get headers
	 * @return headers
	 */
	public function getHeaders() {
		return $this->headers;
	}

	/**
	 * gets the result set
	 * @return resut set
	 */
	public function getResultSet() {
		return $this->result;
	}

	/**
	 * gets the response
	 * @return response
	 */
	public function getResponse() {
		return array(
			'headers' => $this->headers,
			'result'  => $this->result
		);
	}


	/**
	 *  calls sparql
	 */
	public static function callSparql( $parameters, $template ) {
		$smarty = new Smarty();
		$smarty->assign( $parameters );
		$query = $smarty->fetch( __DIR__ . '/../templates/sparql/' . $template . '.sparql.tpl' );

		$sparql = new Sparql( $query );
		$sparql->execute();

		return $sparql->getResultSet();
	}

	/**
	 * sets the last SPARQL
	 */
	public static function setLastSparql( $sparql ) {
		self::$lastSparql = $sparql;
	}

	/**
	 * gets the last SPARQL
	 */
	public static function getLastSparql() {
		return self::$lastSparql;
	}
}

?>