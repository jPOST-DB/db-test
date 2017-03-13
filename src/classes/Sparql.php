<?php

require_once( __DIR__ . '/../conf/config.php' );

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

		$url = $this->endpoint . '?query=' . urlencode( $this->sparql )
			 . '&format=' . $format;

		$content = file_get_contents( $url );
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
}

?>